<?php

namespace App\Http\Controllers;

use App\Exports\AnnouncementExport;
use App\Models\Announcement;
use App\Http\Requests\Announcements\StoreAnnouncementRequest;
use App\Http\Requests\Announcements\UpdateAnnouncementRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Filters\AnnouncementFilter;
use App\Models\History\AnnouncementHistory;
use App\Notifications\Announcements\AnnouncementCreatedNotification;
use App\Notifications\Announcements\AnnouncementDeletedNotification;
use App\Notifications\Announcements\AnnouncementUpdatedNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auth_user_id = Auth::user()->id;

        $announcements = QueryBuilder::for(Announcement::query())
                ->with(['course', 'user'])
                ->allowedFilters(
                    AllowedFilter::partial('title'),
                    AllowedFilter::callback('date_from', function($query,$date_from){
                        $query->whereDate('created_at', '>=', $date_from);
                    }),
                    AllowedFilter::callback('date_to',function($query,$date_to){
                        $query->whereDate('created_at', '<=', $date_to);
                    }),
                    AllowedFilter::callback('course',function($query,$course){
                        $query->whereHas('courses',function($query) use ($course){
                            $query->where('id',$course);
                        });
                    }),
                    AllowedFilter::callback('user',function($query,$value){
                        $query->whereHas('users', function($user,$value){
                            $user->where('id',$value);
                        });
                    })
                )->orderBy('created_at','DESC')->paginate(10);

        $courses = Auth::user()->courses()->withoutTrashed()->get();
        $instructor_admins = User::withoutTrashed()->role(['Καθηγητής','Διαχειριστής'])->get();

        $user_role = Auth::user()->getRoleNames()->first();

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

    public function export_excel(){
        return Excel::download(new AnnouncementExport(),'announcements.xls');
    }

    public function export_pdf(){
        $announcements = Announcement::with(['user','course'])->get();
        $pdf = Pdf::loadView('pdf.announcements',compact('announcements'));
        return $pdf->download('announcements.pdf');
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

        DB::transaction(function () use($request,$data,$auth_user,$announcement,$path) {
            $user_name = User::find($auth_user)->name;
            $course = Course::find($data['course_id']);
            $registered_course_users = $course->users()->get();
            $announcement->title = $data['title'];
            $announcement->message = $data['message'] ?? null;

            if($request->hasFile('file')){
                $file = $request->file('file')->getClientOriginalName();
                $path = $request->file('file')->storeAs('announcements', $file,'public');
            }

            $announcement->file = $path;

            AnnouncementHistory::create([
                'user' => $user_name,
                'course' => $course->title,
                'title' => $announcement->title,
                'message' => $announcement->message,
                'file' => $path,
                'status' => 'Ενεργή'
            ]);

            Notification::send($registered_course_users, new AnnouncementCreatedNotification($announcement));

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
        $course = Course::find($data['course_id']);
        $registered_course_users = $course->users()->get();

        if($request->hasFile('file')){
            $file = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('announcements', $file ,'public');
        }

        Notification::send($registered_course_users ,new AnnouncementUpdatedNotification($announcement));

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
            $registered_course_users = $announcement->course->users;

            AnnouncementHistory::create([
                'user' => $announcement->user->name,
                'course' => $announcement->course->title,
                'title' => $announcement->title,
                'message' => $announcement->message,
                'file' => $announcement->file,
                'status' => 'Διαγραμμένη'
            ]);

            Notification::send($registered_course_users ,new AnnouncementDeletedNotification($announcement));

            $announcement->delete();
        });

        return redirect()->route('announcements.index')->withSuccess('Η Διαγραφή της ανακοίνωσης έγινε με επιτυχία.');
    }
}
