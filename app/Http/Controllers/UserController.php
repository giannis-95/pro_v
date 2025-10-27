<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(){
        $users = User::withTrashed()->orderBy('id')->paginate(10)->through(function($user){
            $user->role = $user->getRoleNames()->first();
            $user->is_deleted = $user->trashed();
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
        // $this->isAuthorized($user);

        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->back()->withSuccess('Η Διαγραφή του χρήστη έγινε με επιτυχία.');
    }

    public function restore_user($id){
        $user = User::onlyTrashed()->find($id);

        $this->authorize('restore', $user);

        $user->restore();

        return redirect()->back()->withSuccess('Η Επαναφορά του χρήστη έγινε με επιτυχία.');
    }

    public function final_deleted($id){
        $user = User::onlyTrashed()->find($id);

        $this->authorize('forceDelete', $user);

        $role = $user->getRoleNames()->first();
        $user->removeRole($role);

        $user->forceDelete();

        return redirect()->back()->withSuccess('Η οριστική διαγραφή του χρήστη έγινε με επιτυχία.');
    }


    // protected function isAuthorized(User $user){
    //     if ($user->getRoleNames()->first() == 'Διαχειριστής' && $user->email == 'admin@admin.com') {
    //         throw ValidationException::withMessages([
    //             'unauthorizedAction' => __('validation.action'),
    //         ]);
    //     }
    // }
}
