<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user = Auth::user();

        $courses = Course::with('users:id') // φέρνουμε τους users για κάθε course
        ->paginate(10)
        ->through(function ($course) use ($user) {
            // προσθέτουμε ένα extra πεδίο: αν είναι ο χρήστης εγγεγραμμένος
            $course->is_registered = $course->users->contains($user);
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

        $user->courses()->attach($id);

        return redirect()->back()->withSuccess('Η Εγγραφή του Μαθήματος έγινε με επιτυχία.');
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
}
