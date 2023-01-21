<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/User/Index', [
            'users' => User::search(request('search'))
                        ->query(fn ($query) =>
                            $query->withCount('posts')->orderBy('created_at'))
                        ->paginate(5)
                        ->withQueryString()
                        ->through(fn ($user) => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'role' => $user->getRoleNames()->implode(', '),
                            'permissions' => $user->getAllPermissions()->pluck('name')->implode(', '),
                            'posts_count' => $user->posts_count,
                            'created_at' => $user->created_at->isoFormat('dddd, D MMMM Y H:mm'),
                            'updated_at' => $user->updated_at->isoFormat('dddd, D MMMM Y H:mm'),
                        ]),
            'filters' => request()->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Dashboard/User/Create', [
            'allRoles' => Role::get(['name']),
            'allPermissions' => Permission::get(['name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        abort_if(Auth()->user()->hasRole('admin') && $user->getRoleNames()[0] == 'super-admin', 403, 'You are not authorized to edit this user.');

        return Inertia::render('Dashboard/User/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'userRole' => $user->getRoleNames(),
                'userPermissions' => $user->getAllPermissions()->pluck('name')->toArray(),
            ],
            'allRoles' => Role::get(['name']),
            'allPermissions' => Permission::get(['name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required',
        ]);

        if (Auth()->user()->hasRole('admin')) {
            $user->syncRoles($request->role['value'] ?? $request->role[0])->touch();

            $user->syncPermissions($request->permissions)->touch();

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role['value'] ?? $request->role[0])->touch();

        $user->syncPermissions($request->permissions)->touch();

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}