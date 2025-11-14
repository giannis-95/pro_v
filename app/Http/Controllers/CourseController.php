<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use WebSocket\Client;
use App\Notifications\CourseRegistered;

class CourseController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = Auth::user();

        $courses = Course::withTrashed()
                    ->paginate(10)
                    ->through(function ($course) use ($user) {
                        $course->is_registered = $course->users->contains($user);
                        $course->is_deleted = $course->trashed();
                        return $course;
                    });

        return Inertia::render('courses/index',[
            'courses' => $courses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return inertia::render('courses/create');
    }

    public function my_course(){
        $id = Auth::user()->id;

        $courses = User::findOrFail($id)->courses()->paginate(10);

        return Inertia::render('courses/my-course',[
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

        Course::create($data);

        return redirect()->route('courses.index')->withSuccess('Το Μάθημα δημιουργήθηκε με επιτυχία.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course){
        return inertia::render('courses/show',[
            'course' => $course
        ]);
    }

    public function course_registration($id){
        $user = User::find(Auth::user()->id);
        $course = Course::findOrFail($id);

        // $message = [
        //     'title' => 'Εγγραφή Μαθήματος : ' . $course->title,
        //     'body' => 'Η εγγραφή σας ολοκληρώθηκε με επιτυχία.'
        // ];

        // Mail::to('giannispappas95@gmail.com')->send(new TestMail($message,$course));

        // $user->courses()->attach($id);

        // $user->notify(new CourseRegistered($course));


        // $data = [
        //     'message' => "Ο/Η {$user->name} εγγράφηκε στο μάθημα: {$course->title}"
        // ];

        // Σύνδεση με WebSocket server και αποστολή μηνύματος

        // try {
        //     // Δημιουργούμε client και συνδεόμαστε στον WebSocket server
        //     $client = new Client("ws://127.0.0.1:6001");

        //     // Στέλνουμε το μήνυμα (το library φροντίζει το WebSocket protocol)
        //     $client->send(json_encode($data));

        //     // Κλείνουμε τη σύνδεση
        //     $client->close();
        // } catch (\Exception $e) {

        // }
        return redirect()->back()->withSuccess('Η Εγγραφή του Μαθήματος έγινε με επιτυχία.');
    }

    public function unregistration_course($id){
        $user = User::find(Auth::user()->id);

        $user->courses()->detach($id);

        return redirect()->back()->withSuccess('Η Απεγραφή του Μαθήματος έγινε με επιτυχία.');
    }

    public function unregistration_course_email($id){
        $user = User::find(Auth::user()->id);
        $course = Course::findOrFail($id);

        $user->courses()->detach($id);

        $message_title = 'Απεγραφή Μαθήματος : ' . $course->title;
        $message_body = 'Μόλις κάνατε την απεγραφή του μαθήματος σας.';

        Mail::raw($message_body, function ($mail) use ($message_title) {
            $mail->to('giannispappas95@gmail.com')->subject($message_title);
        });

        return redirect()->back()->withSuccess('Η Απεγραφή του Μαθήματος έγινε με επιτυχία.');
    }


    public function restore($id){
        $course = Course::onlyTrashed()->findOrFail($id);

        $this->authorize('restore',$course);

        $course->restore();

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

        if($request->hasFile('image')) {
            if($course->image){
                Storage::disk('public')->delete($course->image);
            }

            $data['image'] = $request->file('image')->store('courses','public');
        }

        $course->fill($data);
        $course->save();

        return redirect()->route('courses.index')->withSuccess('Η Ενημέρωση του μαθήματος έγινε με επιτυχία.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course){
        if($course->image){
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();
        return redirect()->back()->withSuccess('Η Διαγραφή του μαθήματος έγινε με επιτυχία.');
    }

    public function final_deleted($id){
        $course = Course::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete',$course);

        $course->forceDelete();

        return redirect()->route('courses.index')->withSuccess('Η Οριστική Διαγραφή του μαθήματος έγινε με επιτυχία.');
    }
}
