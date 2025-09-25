<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(10);

        return Inertia::render('users/index',[
            'users' => $users,
        ]);
    }

    public function show(User $user){
        return Inertia::render('users/show',[
            'user' => $user
        ]);
    }

    public function create(){
        return Inertia::render('users/create');
    }

    public function edit(User $user){
        return Inertia::render('users/edit',[
            'user' => $user
        ]);
    }

    public function store(UserRequest $request){
        $user = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user['password'] = Hash::make($request->input('password'));

        User::create([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);

        return redirect()->route('users.index')->withSuccess('Η Δημιουργία του χρήστη έγινε με επιτυχία.');
    }

    public function update(Request $request, User $user){
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);

        $data['password'] = Hash::make($request->input('password'));
        $user->fill($data);
        $user->save();

        return redirect()->route('users.index')->withSuccess('Η Ενημέρωση του χρήστη έγινε με επιτυχία.');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->back()->withSuccess('Η Διαγραφή του χρήστη έγινε με επιτυχία.');
    }
}
