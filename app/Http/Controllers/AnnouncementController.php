<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Http\Requests\Announcements\StoreAnnouncementRequest;
use App\Http\Requests\Announcements\UpdateAnnouncementRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Filters\AnnouncementFilter;
use App\Models\History\AnnouncementHistory;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $auth_user_id = Auth::user()->id;
        $announcement_filter = new AnnouncementFilter($request);
        $announcements = $announcement_filter->filterAnnouncement(Announcement::with(['course', 'user'])->orderBy('created_at','DESC'))->paginate(10);

        $courses = Course::withoutTrashed();
        $instructor_admins = User::withoutTrashed()->role(['Καθηγητής','Διαχειριστής'])->get();

        $user_role = User::find($auth_user_id)->getRoleNames()->first();

        return Inertia::render('announcements/index',[
            'announcements' => $announcements,
            'courses' => $courses,
            'instructor_admins' => $instructor_admins,
            'user_role' => $user_role,
            'auth_user_id' => $auth_user_id
        ]);
    }

    // Download file
    public function download_file(Announcement $announcement){
       return Storage::disk('public')->download($announcement->file);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses_user = User::find(Auth::user()->id)->courses()->get();

        return Inertia::render('announcements/create',[
            'courses_user' => $courses_user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $data = $request->validated();
        $auth_user = Auth::user()->id;
        $path = null;

        $announcement = new Announcement();

        DB::transaction(function () use($request,$data,$auth_user,$announcement) {
            $user_name = User::find($auth_user)->name;
            $course_title = Course::find($data['course_id'])->title;

            // dd($user_name,$course_title);
            $announcement->title = $data['title'];
            $announcement->message = $data['message'] ?? null;

            if($request->hasFile('file')){
                $file = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->storeAs('announcements', $file,'public');
            }

            $announcement->file = $path;

            AnnouncementHistory::create([
                'user' => $user_name,
                'course' => $course_title,
                'title' => $announcement->title,
                'message' => $announcement->message,
                'file' => $path,
                'status' => 'Ενεργή'
            ]);

            $announcement->user()->associate($auth_user);
            $announcement->course()->associate($data['course_id']);
            $announcement->save();
        });

        return redirect()->route('announcements.index')->withSuccess('Η Δημιουργία της ανακοίνωσης έγινε με επιτυχία');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        $announcement->load(['course','user']);

        return Inertia::render('announcements/show',[
            'announcement' => $announcement
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Announcement $announcement)
    {
        $auth = Auth::user()->id;
        $courses_user = User::find($auth)->courses()->get();

        $announcement->load(['course','user']);

        return inertia::render('announcements/edit',[
            'announcement' => $announcement,
            'courses_user' => $courses_user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();
        $announcement->title = $data['title'];
        $path = null;

        if($request->hasFile('file')){
            $file = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('announcements', $file ,'public');
        }

        $announcement->course()->associate($data['course_id']);
        $announcement->file = $path;
        $announcement->save();

        return redirect()->route('announcements.index')->withSuccess('Η ενημέρωση της ανακοίνωσης έγινε με επιτυχία.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        DB::transaction(function () use($announcement){
            $user = $announcement->user()->get();
            $coure = $announcement->course()->get();

            dd($user->name,$coure->title);

            AnnouncementHistory::create([
                'user' => $user->name,
                'course' => $coure->title,
                'title' => $announcement->title,
                'message' => $announcement->message,
                'file' => $announcement->file,
                'status' => 'Διαγραμμένη'
            ]);

            $announcement->delete();
        });


        return redirect()->route('announcements.index')->withSuccess('Η Διαγραφή της ανακοίνωσης έγινε με επιτυχία.');
    }
}
