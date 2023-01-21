<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RoleResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Role::search(request('search'))
        ->query(fn ($query) => $query->orderBy('name'))
        ->paginate(5)
        ->withQueryString()
        ->through(fn ($role) => [
            'id' => $role->id,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->toArray(),
            'created_at' => $role->created_at->isoFormat('D MMMM Y H:mm'),
            'updated_at' => $role->updated_at->isoFormat('D MMMM Y H:mm'),
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
        return Inertia::render('Dashboard/Roles/Create', [
            'permissions' => Permission::query()->select(['name', 'id'])->get(),
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
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create([
            'name' => Str::slug($request->name),
            'guard_name' => 'web',
        ]);

        if ($request->has('permissions') && count($request->get('permissions')) > 0) {
            $role->syncPermissions($request->get('permissions'));
        }

        if ($role) {
            return to_route('roles.index')->with('success', 'Role created successfully');
        }

        return to_route('roles.index')->with('error', 'Role could not be created');
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
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return Inertia::render('Dashboard/Roles/Edit', [
            'role' => $role,
            'rolePermissions' => $role->permissions->pluck('id')->toArray(),
            'allPermissions' => Permission::query()->select(['name', 'id'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
        ]);

        $role->update([
            'name' => Str::slug($request->name),
        ]);

        $role->syncPermissions($request->get('permissions'))->touch();

        if ($role) {
            return to_route('roles.index')->with('success', 'Role has been updated.');
        }

        return to_route('roles.index')->with('error', 'Something went wrong, please try again. Or you did not change anything.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['super-admin', 'admin'])) {
            return back()->with('error', 'You can not delete "'.$role->name.'" role');
        }

        if ($role->delete()) {
            return back()->with('success', 'Role deleted successfully');
        }

        return back()->with('error', 'Something went wrong, please try again.');
    }
}