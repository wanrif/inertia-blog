<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

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
            'permissions' =>
                Permission::query()
                    ->orderBy('name','ASC')
                    ->filter(request()->only('search'))
                    ->paginate(5)
                    ->withQueryString()
                    ->through(fn ($permission) => [
                        'id' => $permission->id,
                        'name' => $permission->name,
                        'created_at' => $permission->created_at->format('d/m/Y'),
                        'updated_at' => $permission->updated_at->format('d/m/Y'),
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
        return Inertia::render('Dashboard/Permissions/Create');
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
            'name' => ['required', 'string', 'max:255'],
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => strtolower($request->name),
        ]);

        return to_route('permissions.index')->with('message', 'Permission has been updated.');
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

        if ($permission->name == 'can manage roles' || $permission->name == 'can manage permissions') {
            return to_route('permissions.index')->with('error', 'You can not delete "' . $permission->name . '" permission.');
        }

        $permission->delete();

        return to_route('permissions.index')->with('message', 'Permission has been deleted.');
    }
}