<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History\UserHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Notifications\Users\UserCreatedNotification;
use App\Notifications\Users\UserDeletedNotification;
use App\Notifications\Users\UserFinalDeletedNotification;
use App\Notifications\Users\UserRestoreNotification;
use App\Notifications\Users\UserUpdatedNotification;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(){
        $user_role = Auth::user()->getRoleNames()->first();

        $users = QueryBuilder::for(User::query()->withTrashed())
                ->allowedFilters(
                    AllowedFilter::partial('name'),
                    AllowedFilter::callback('role', function ($query, $value) {
                        $query->whereHas('roles', function ($query) use ($value) {
                            $query->where('name', $value);
                        });
                    }),
                    AllowedFilter::callback('date_from', function ($query, $value) {
                        $query->whereDate('created_at', '>=', $value);
                    }),
                    AllowedFilter::callback('date_to', function ($query, $value) {
                        $query->whereDate('created_at', '<=', $value);
                    }),
                )
                ->orderBy('id')
                ->paginate(10)
                ->through(function ($user) {
                    $user->role = $user->getRoleNames()->first();
                    $user->is_deleted = $user->trashed();
                    return $user;
                })->withQueryString();

        return Inertia::render('users/index', [
            'users' => $users,
            'user_role' => $user_role,
        ]);
    }

    public function exportExcel(){
        return Excel::download(new UsersExport(), 'users.xlsx');
    }

    public function exportPdf(){
        $users = User::all();

        $pdf = Pdf::loadView('pdf.users', compact('users'));

        return $pdf->download('users.pdf');
    }

    public function show(User $user){
        $registered_courses = $user->courses()->paginate(10);
        $user->role = $user->getRoleNames()->first();

        return Inertia::render('users/show',[
            'user' => $user,
            'registered_courses' => $registered_courses
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
        $user_data = $request->validated();
        $user_data['password'] = Hash::make($request->input('password'));

        DB::transaction(function () use ($user_data){
            $admins = User::role('Διαχειριστής')->get();

            $user = User::create([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => $user_data['password']
            ]);

            $user->assignRole($user_data['role']);

            Notification::send($admins, new UserCreatedNotification($user));

            UserHistory::create([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'role' => $user_data['role'],
                'status' => 'Ενεργος'
            ]);
        });

        return redirect()->route('users.index')->withSuccess('Η Δημιουργία του χρήστη έγινε με επιτυχία.');
    }

    public function update(Request $request, User $user){
        $admins = User::role('Διαχειριστής')->get();
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

        Notification::send($admins, new UserUpdatedNotification($user));

        $user->fill($data);
        $user->save();

        return redirect()->route('users.index')->withSuccess('Η Ενημέρωση του χρήστη έγινε με επιτυχία.');
    }

    public function destroy(User $user){
        $this->authorize('delete', $user);

        $role = $user->getRoleNames()->first();

        DB::transaction(function() use($user,$role){
            $admins = User::role('Διαχειριστής')->get();

            UserHistory::create([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'status' => 'Μη Ενεργός'
            ]);

            Notification::send($admins, new UserDeletedNotification($user));
            $user->delete();
        });


        return redirect()->back()->withSuccess('Η Διαγραφή του χρήστη έγινε με επιτυχία.');
    }

    public function restore_user($id){
        $user = User::onlyTrashed()->find($id);

        $this->authorize('restore', $user);

        $role = $user->getRoleNames()->first();

        DB::transaction(function () use($user,$role){
            $admins = User::role('Διαχειριστής')->get();

            UserHistory::create([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'status' => 'Ενεργός'
            ]);

            Notification::send($admins, new UserRestoreNotification($user));
            $user->restore();
        });

        return redirect()->back()->withSuccess('Η Επαναφορά του χρήστη έγινε με επιτυχία.');
    }

    public function final_deleted($id){
        $user = User::onlyTrashed()->find($id);

        $this->authorize('forceDelete', $user);

        $role = $user->getRoleNames()->first();

        DB::transaction(function () use ($user,$role){
            $admins = User::role('Διαχειριστής')->get();

            UserHistory::create([
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'status' => 'Διεγεγραμένος'
            ]);

            Notification::send($admins, new UserFinalDeletedNotification($user));

            $user->removeRole($role);
            $user->forceDelete();
        });

        return redirect()->back()->withSuccess('Η οριστική διαγραφή του χρήστη έγινε με επιτυχία.');
    }
}
