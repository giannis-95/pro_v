<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RegisteredStudentsController extends Controller
{
    public function index($id){
        $students = User::role('Φοιτητής')->get();
        $course = Course::findOrFail($id);

        $users = QueryBuilder::for(
                $course->users()
            )->allowedFilters(
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            )->whereHas('roles', function ($query) {
                $query->whereNotIn('name', [
                    'Διαχειριστής',
                    'Καθηγητής'
                ]);
            });

        $registered_students = $users->paginate(10)->through(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->is_deleted = $user->trashed();
            return $user;
        });

        return Inertia::render('registered-students/index',[
            'registered_students' => $registered_students,
            'course' => $course,
            'students' => $students
        ]);
    }

    public function store(Request $request,$id){
        $students = $request->input('students');
        $course = Course::findOrFail($id);

        $course->users()->syncWithoutDetaching($students);

        return redirect()->back()->withSuccess('Η προσθήκη των φοιτητών έγινε με επιτυχία.');
    }

    public function unregistered($course_id,$unregistered_student_id){
        $course = Course::findOrFail($course_id);
        $course->users()->detach($unregistered_student_id);

        return redirect()->back()->withsuccess('Η απεγραφή του φοιτητή από το μάθημα σας έγινε με επιτυχία.');
    }
}
