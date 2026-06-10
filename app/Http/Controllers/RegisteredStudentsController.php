<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\User;
use App\Filters\RegisteredStudentFilter;

class RegisteredStudentsController extends Controller
{
    public function index(Request $request, $id){
        $registered_students_class = new RegisteredStudentFilter($request);

        $students = User::role('Φοιτητής')->get();
        $course = Course::findOrFail($id);

        $users = $course->users()->whereHas('roles', function ($query) {
            $query->whereNotIn('name', [
                'Διαχειριστής',
                'Καθηγητής'
            ]);
        });

        $users = $registered_students_class->filterRegisteredStudents($users);

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

    public function unregistered($course){
        dd($course);
    }
}
