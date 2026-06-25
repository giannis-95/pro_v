<?php

namespace App\Http\Controllers;

use App\Exports\CourseExport;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\History\CourseHistory;
use App\Notifications\Courses\CourseDeletedNotification;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\Courses\CourseCreatedNotification;
use App\Notifications\Courses\CourseRegisterNotification;
use App\Notifications\Courses\CourseRestoreNotification;
use App\Notifications\Courses\CourseUnregisterNotification;
use App\Notifications\Courses\CourseUpdatedNotification;
use App\Notifications\Courses\CourseFinalDeletedNotification;
use Illuminate\Support\Facades\Notification;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CourseController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = Auth::user();
        $user_role = User::find($user->id)->getRoleNames()->first();

        $courses = QueryBuilder::for(Course::withTrashed())
            ->allowedFilters(
                AllowedFilter::partial('title'),
                AllowedFilter::callback('date_from' , function($query,$date_from){
                    $query->whereDate('created_at', '<=' ,$date_from);
                }),
                AllowedFilter::callback('date_to', function($query,$date_to){
                    $query->whereDate('created_at', '>=' , $date_to);
                })
            )
            ->paginate(10)
            ->through(function ($course) use ($user) {
                $course->is_registered = $course->users->contains($user);
                $course->is_deleted = $course->trashed();
                return $course;
            });

        return Inertia::render('courses/index',[
            'courses' => $courses,
            'user_role' => $user_role
        ]);
    }

    public function export_excel(){
        return Excel::download(new CourseExport(),'courses.xlsx');
    }

    public function export_pdf(){
        $courses = Course::all();

        $pdf = Pdf::loadView('pdf.courses',compact('courses'));

        return $pdf->download('courses.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return inertia::render('courses/create');
    }

    public function my_course(){
        $courses = QueryBuilder::for(
                        User::find(Auth::user()->id)
                            ->courses()
                            ->getQuery()
                    )->allowedFilters(
                        AllowedFilter::partial('title'),
                        AllowedFilter::callback('date_from', function ($query, $date_from) {
                            $query->whereDate('courses.created_at', '<=', $date_from);
                        }),
                        AllowedFilter::callback('date_to', function ($query, $date_to) {
                            $query->whereDate('courses.created_at', '>=', $date_to);
                        })
                    )
                    ->select('courses.*')
                    ->paginate(10);

        return Inertia::render('courses/my-course', [
            'courses' => $courses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(CourseRequest $request){
        $data = $request->validated();

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses','public');
        }

        $course = DB::transaction(function () use ($data){
            $course = Course::create($data);

            CourseHistory::create([
                'title' => $data['title'],
                'image' => null,
                'description' => $data['description'],
                'status' => 'Ενεργό'
            ]);

            return $course;
        });

        auth()->user()->notify(new CourseCreatedNotification($course));

        return redirect()->route('courses.index')->withSuccess('Το Μάθημα δημιουργήθηκε με επιτυχία.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course){
        $auth_user = Auth::user();

        $role = $auth_user->getRoleNames()->first();
        $registered_user = $auth_user->courses()->where('courses.id', $course->id)->exists();

        return inertia::render('courses/show',[
            'course' => $course,
            'registered_user' => $registered_user,
            'role' => $role
        ]);
    }

    public function course_registration($id){
        $user = User::find(Auth::user()->id);
        $course = Course::findOrFail($id);

        // sms Μυνηματα
        // Http::withToken(config('services.sinch.token'))->post('https://us.sms.api.sinch.com/xms/v1/' . config('services.sinch.service_plan_id') . '/batches',[
        //         'from' => config('services.sinch.sender'),
        //         'to' => ['+306978460325'],
        //         'body' => 'Η εγγραφή σας στο μάθημα "' . $course->title . '" ολοκληρώθηκε με επιτυχία!'
        //     ]
        // );


        // $message = [
        //     'title' => 'Εγγραφή Μαθήματος : ' . $course->title,
        //     'body' => 'Η εγγραφή σας ολοκληρώθηκε με επιτυχία.'
        // ];

        // Mail::to('giannispappas95@gmail.com')->send(new TestMail($message,$course));

        $user->notify(new CourseRegisterNotification($course));
        $user->courses()->attach($id);

        // $user->notify(new CourseRegistered($course));


        // $data = [
        //     'message' => "Ο/Η {$user->name} εγγράφηκε στο μάθημα: {$course->title}"
        // ];

        return redirect()->back()->withSuccess('Η Εγγραφή του Μαθήματος έγινε με επιτυχία.');
    }

    public function unregistration_course($id){
        $user = User::find(Auth::user()->id);
        $course = $user->courses()->where('course_id',$id)->first();

        $user->notify(new CourseUnregisterNotification($course));

        $user->courses()->detach($id);

        return redirect()->back()->withSuccess('Η Απεγραφή του Μαθήματος έγινε με επιτυχία.');
    }

    public function unregistration_course_email($id){
        $user = User::find(Auth::user()->id);
        // $course = Course::findOrFail($id);

        $user->courses()->detach($id);

        // $message_title = 'Απεγραφή Μαθήματος : ' . $course->title;
        // $message_body = 'Μόλις κάνατε την απεγραφή του μαθήματος σας.';

        // Mail::raw($message_body, function ($mail) use ($message_title) {
        //     $mail->to('giannispappas95@gmail.com')->subject($message_title);
        // });

        return redirect()->back()->withSuccess('Η Απεγραφή του Μαθήματος έγινε με επιτυχία.');
    }


    public function restore($id){
        $course = Course::onlyTrashed()->findOrFail($id);

        $this->authorize('restore',$course);

        DB::transaction(function () use ($course){
            CourseHistory::create([
                'title' => $course->title,
                'image' => $course->image,
                'description' => $course->description,
                'status' => 'Ενεργό'
            ]);

            Notification::send(User::all(), new CourseRestoreNotification($course));

            $course->restore();
        });

        return redirect()->route('courses.index')->withSuccess('Η Επαναφορά του μαθήματος έγινε με επιτυχία.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course){
        return inertia::render('courses/edit',[
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course){
        $data = $request->validated();
        $users = $course->users()->get();

        if($request->hasFile('image')) {
            if($course->image){
                Storage::disk('public')->delete($course->image);
            }

            $data['image'] = $request->file('image')->store('courses','public');
        }

        Notification::send($users, new CourseUpdatedNotification($course));

        $course->fill($data);
        $course->save();

        return redirect()->route('courses.index')->withSuccess('Η Ενημέρωση του μαθήματος έγινε με επιτυχία.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course){
        DB::transaction(function () use ($course){
            CourseHistory::create([
                'title' => $course->title,
                'image' => $course->image,
                'description' => $course->description,
                'status' => 'Μη Ενεργό'
            ]);

            Notification::send(User::all(), new CourseDeletedNotification($course));

            $course->delete();
        });

        return redirect()->back()->withSuccess('Η Διαγραφή του μαθήματος έγινε με επιτυχία.');
    }

    public function final_deleted($id){
        $course = Course::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete',$course);

        if($course->image){
            Storage::disk('public')->delete($course->image);
        }

        DB::transaction(function () use ($course){
            CourseHistory::create([
                'title' => $course->title,
                'image' => null,
                'description' => $course->description,
                'status' => 'Διεγεγραμένο'
            ]);

            Notification::send(User::all(), new CourseFinalDeletedNotification($course));

            $course->forceDelete();
        });

        return redirect()->route('courses.index')->withSuccess('Η Οριστική Διαγραφή του μαθήματος έγινε με επιτυχία.');
    }
}
