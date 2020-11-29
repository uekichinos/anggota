<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

// use App\MainMenu;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // new MainMenu;
        // $this->middleware(['permission:list role|create role|edit role|view role|delete role']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $user = Auth::user();

                    if ($user->hasPermissionTo('view role')) {
                        $btn = '<a href="'.route('role.show', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-book"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('edit role')) {
                        $btn .= '<a href="'.route('role.edit', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-pencil"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('delete role')) {
                        $btn .= '<form method="POST" style="float:right" action="'.route('role.delete', $row->id).'">'.csrf_field().''.method_field('DELETE').'<a href="javascript:this.submit()" class="btn btn-danger btn-sm delete-role"><span style="color:white" class="oi oi-trash"></span></a></form>';
                    }

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        if (count($permissions) > 0) {
            $records = [];
            foreach ($permissions as $key => $permission) {
                $tmp = explode(' ', $permission->name);
                if (count($tmp) > 1) {
                    $records[ucfirst($tmp[1])][$permission->name] = ucfirst($tmp[0]);
                } else {
                    $records[ucfirst($tmp[0])][$permission->name] = ucfirst($tmp[0]);
                }
            }
        }

        return view('role.create')->with(['permissions' => $records]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|max:255',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('role.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $role = new Role();
        $role->name = strtolower($request->name);
        $role->guard_name = 'web';
        $role->save();

        $permissions = $request->permission;
        if (count($permissions) > 0) {
            foreach ($permissions as $permission) {
                $p = Permission::where('name', '=', $permission)->firstOrFail();
                $role = Role::where('name', '=', strtolower($request->name))->first();
                $role->givePermissionTo($p);
            }
        }

        return redirect()->route('role.index')->with('success', 'Role created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        $rolepermissions = [];
        $permissions = $role->permissions()->get();
        if (count($permissions) > 0) {
            foreach ($permissions as $key => $permission) {
                $rolepermissions[] = $permission->name;
            }
        }

        $records = [];
        $permissions = Permission::all();
        if (count($permissions) > 0) {
            foreach ($permissions as $key => $permission) {
                $tmp = explode(' ', $permission->name);
                $records[ucfirst($tmp[1])][$permission->name] = ucfirst($tmp[0]);
            }
        }

        return view('role.show')->with(['role' => $role, 'permissions' => $records, 'rolepermissions' => $rolepermissions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        $rolepermissions = [];
        $permissions = $role->permissions()->get();
        if (count($permissions) > 0) {
            foreach ($permissions as $key => $permission) {
                $rolepermissions[] = $permission->name;
            }
        }

        $records = [];
        $permissions = Permission::all();
        if (count($permissions) > 0) {
            foreach ($permissions as $key => $permission) {
                $tmp = explode(' ', $permission->name);
                $records[ucfirst($tmp[1])][$permission->name] = ucfirst($tmp[0]);
            }
        }

        return view('role.edit')->with(['role' => $role, 'permissions' => $records, 'rolepermissions' => $rolepermissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/role/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->except(['permission']);
        $permissions = $request['permission'];
        $role = Role::find($id);
        $role->name = $request->name;
        $role->fill($input)->save();

        $p_all = Permission::all();
        foreach ($p_all as $p) {
            $role->revokePermissionTo($p);
        }

        if (isset($permissions)) {
            foreach ($permissions as $permission) {
                $p = Permission::where('name', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }
        }

        return redirect()->route('role.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return redirect()->route('role.index')->with('success', 'Role deleted successfully!');
    }
}
