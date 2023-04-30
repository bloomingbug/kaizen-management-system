<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'jabatan', 'departement_id')->when(request()->q, function ($users) {
            $users = $users->where('name', 'like', '%' . request()->q . '%');
        })->with(['roles' => function ($query) {
            $query->select('id', 'name');
        }, 'departement' => function ($query) {
            $query->select('id', 'name');
        }])->latest()->paginate(10);

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        $departements = Departement::all();

        return Inertia::render('User/Create', [
            'roles' => $roles,
            'departements' => $departements
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'exists:roles,name'],
            'departement_id' => ['required', 'string', 'exists:departements,id'],
            'jabatan' => ['required', 'string'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'departement_id' => $request->departement_id,
                'jabatan' => $request->jabatan
            ]);

            $user->assignRole($request->roles);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $departements = Departement::all();

        return Inertia::render('User/Edit', [
            'user' => $user->load('roles'),
            'roles' => $roles,
            'departements' => $departements
        ]);
    }

    public function change_password(User $user)
    {
        return Inertia::render('User/ChangePassword', [
            'user' => $user
        ]);
    }


    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => ['required', 'string'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string', 'exists:roles,name'],
            'departement_id' => ['required', 'string', 'exists:departements,id'],
            'jabatan' => ['required', 'string'],
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'departement_id' => $request->departement_id,
                'jabatan' => $request->jabatan
            ]);

            $user->syncRoles($request->roles);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function update_password(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index')->with('success', 'Password updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
