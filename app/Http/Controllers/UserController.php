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
        $users = User::orderBy('id')->paginate(10)->through(function($user){
            $user->role =  $user->getRoleNames()->first();
            return $user;
        });

        return Inertia::render('users/index',[
            'users' => $users,
        ]);
    }

    public function show(User $user){
        $user->role = $user->getRoleNames()->first();

        return Inertia::render('users/show',[
            'user' => $user,
        ]);
    }

    public function create(){
        return Inertia::render('users/create');
    }

    public function edit(User $user){
        $user->role = $user->getRoleNames()->first();

        return Inertia::render('users/edit',[
            'user' => $user
        ]);
    }

    public function store(UserRequest $request){
        $user_data = $request->only([
            'name',
            'email',
            'password',
            'role'
        ]);

        $user_data['password'] = Hash::make($request->input('password'));

        $user = User::create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => $user_data['password']
        ]);

        $user->assignRole($user_data['role']);

        return redirect()->route('users.index')->withSuccess('Η Δημιουργία του χρήστη έγινε με επιτυχία.');
    }

    public function update(Request $request, User $user){
        $data = $request->only([
            'name',
            'email',
            'password',
        ]);

        $role = $request->input('role');

        if($user->getRoleNames()->first() != $role){
            $user->syncRoles($role);
        }

        $data['password'] = Hash::make($request->input('password'));
        $user->fill($data);
        $user->save();

        return redirect()->route('users.index')->withSuccess('Η Ενημέρωση του χρήστη έγινε με επιτυχία.');
    }

    public function destroy(User $user){
        $role = $user->getRoleNames()->first();
        $user->removeRole($role);

        $user->delete();

        return redirect()->back()->withSuccess('Η Διαγραφή του χρήστη έγινε με επιτυχία.');
    }
}
