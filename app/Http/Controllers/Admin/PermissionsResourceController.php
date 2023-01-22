<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionsResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Permissions/Index', [
            'permissions' => Permission::search(request('search'))
                    ->query(fn ($query) => $query->orderBy('name'))
                    ->paginate(5)
                    ->withQueryString()
                    ->through(fn ($permission) => [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'created_at' => $permission->created_at->format('d/m/Y H:i'),
                        'updated_at' => $permission->updated_at->format('d/m/Y H:i'),
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
        //
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
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create([
            'name' => strtolower($request->name),
        ]);

        return to_route('permissions.index')->with('success', 'Permission has been created.');
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
        //
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
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name,'.$id],
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => strtolower($request->name),
        ]);

        if ($permission->wasChanged()) {
            return back()->with('success', 'Permission has been updated.');
        }

        return back()->with('error', 'Something went wrong, please try again. Or you did not change anything.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if (in_array($permission->name, ['manage roles', 'manage permissions'])) {
            return back()->with('error', 'You can not delete "'.$permission->name.'" permission.');
        }

        if ($permission->delete()) {
            return back()->with('success', 'Permission has been deleted.');
        }

        return back()->with('error', 'Something went wrong, please try again.');
    }
}
