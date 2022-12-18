<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not authorized to access this page');

        $data = Role::query()
        ->filter(request()->only('search'))
        ->orderBy('name')
        ->paginate(5)
        ->withQueryString()
        ->through(fn ($role) => [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->toArray(),
            'created_at' => $role->created_at->isoFormat('dddd, D MMMM Y'),
            'updated_at' => $role->updated_at->isoFormat('dddd, D MMMM Y'),
        ]);

        return Inertia::render('Dashboard/Roles/Index', [
            'roles' => $data,
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
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not authorized to access this page');

        return Inertia::render('Dashboard/Roles/Create', [
            'permissions' => Permission::query()->select(['name','id'])->get(),
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
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not allowed to add roles');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::create([
            'name' => Str::slug($request->name),
            'guard_name' => 'web',
        ]);

        if($request->has('permissions') && count($request->get('permissions')) > 0) {
            $role->syncPermissions($request->get('permissions'));
        }

        return to_route('roles.index')->with('message', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not authorized to access this page');

        return Inertia::render('Dashboard/Roles/Edit', [
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('id')->toArray(),
            'allPermissions' => Permission::query()->select(['name','id'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not allowed to update roles');

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role->update([
            'name' => Str::slug($request->name),
        ]);

        if($request->has('permissions') && count($request->get('permissions')) > 0) {
            $role->syncPermissions($request->get('permissions'));
        }

        return to_route('roles.index')->with('message', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        abort_if(!Auth::user()->hasRole('super-admin') && !Auth::user()->hasRole('admin'), 403, 'You are not allowed to delete roles');

        if($role->name === 'super-admin' || $role->name === 'admin') {
            return back()->with('error', 'You can not delete "' . $role->name . '" role');
        }

        $role->delete();

        return back()->with('message', 'Role deleted successfully');
    }
}