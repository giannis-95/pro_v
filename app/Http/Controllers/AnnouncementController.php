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

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $announcement_filter = new AnnouncementFilter($request);
        $announcements = $announcement_filter->filterAnnouncement(Announcement::with(['course', 'user']))->get();

        $courses = Course::withoutTrashed();
        $users = User::withoutTrashed()->role('Καθηγητής')->get();
        $user_role = User::find(Auth::user()->id)->getRoleNames()->first();

        return Inertia::render('announcements/index',[
            'announcements' => $announcements,
            'courses' => $courses,
            'users' => $users,
            'user_role' => $user_role
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
        $user = Auth::user()->id;
        $path = null;

        $announcement = new Announcement();
        $announcement->title = $data['title'];
        $announcement->message = $data['message'] ?? null;

        if($request->hasFile('file')){
            $file = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('announcements', $file,'public');
        }

        $announcement->file = $path;
        $announcement->user()->associate($user);
        $announcement->course()->associate($data['course_id']);
        $announcement->save();

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
        $announcement->delete();
        return redirect()->route('announcements.index')->withSuccess('Η Διαγραφή της ανακοίνωσης έγινε με επιτυχία.');
    }
}
