<?php

namespace App\Http\Controllers;

use App\Rules\Password;
use App\User;
use App\Plan;
use DataTables;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $user = Auth::user();

                    $btn = '';
                    if ($user->hasPermissionTo('view user')) {
                        $btn .= '<a href="'.route('user.show', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-book"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('edit user')) {
                        $btn .= '<a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-pencil"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('delete user')) {
                        $btn .= '<form method="POST" style="float:right" action="'.route('user.delete', $row->id).'">'.csrf_field().''.method_field('DELETE').'<a href="javascript:this.submit()" class="btn btn-danger btn-sm delete-permission"><span style="color:white" class="oi oi-trash"></span></a></form>';
                    }
                    if ($user->hasPermissionTo('impersonate user') && $user->id != $row->id) {
                        $btn .= '<a href="'.route('impersonate.impersonate', $row->id).'" class="btn btn-info btn-sm"><span style="color:white" class="oi oi-person"></span></a>&nbsp;';
                    }

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->editColumn('role', function ($row) {
                    $roles = $row->getRoleNames();

                    return ucfirst($roles[0]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $plans = Plan::all();

        return view('user.create')->with(['roles' => $roles, 'plans' => $plans]);
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
            'username'        => 'required|max:128|unique:users,username',
            'name'            => 'required|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => ['required', new Password()],
            'confirmpassword' => 'required|same:password',
            'role'            => 'required',
            'nric'            => 'required|integer|digits:12',
            'contactno'       => 'required|regex:/[0-9]/',
            'memberno'        => 'required',
            'address'         => 'required',
            'dob'             => 'required|date',
            'plan'            => 'required',
            'bankname'        => 'required',
            'bankaccno'       => 'required',
            'n_name'          => 'required|max:255',
            'n_nric'          => 'required|integer|digits:12',
            'n_contactno'     => 'required|regex:/[0-9]/',
            'n_bankname'      => 'required',
            'n_bankaccno'     => 'required',
            'i_memberno'      => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('user.create'))
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = new User();
        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nric = $request->nric;
        $user->contactno = $request->contactno;
        $user->memberno = $request->memberno;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->plan = implode("|", $request->plan);
        $user->bankname = $request->bankname;
        $user->bankaccno = $request->bankaccno;
        $user->n_name = $request->n_name;
        $user->n_nric = $request->n_nric;
        $user->n_contactno = $request->n_contactno;
        $user->n_bankname = $request->n_bankname;
        $user->n_bankaccno = $request->n_bankaccno;
        $user->i_memberno = $request->i_memberno;
        $user->save();

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User created successfully!');
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
        $plans = Plan::all();
        $user = User::find($id);
        $user->role = $user->getRoleNames()[0];
        $introducer = User::where('memberno', $user->i_memberno)->get();
        if (count($introducer) > 0) {
            $introducer = $introducer[0];
        } else {
            $introducer = false;
        }

        return view('user.show')->with(['user' => $user, 'introducer' => $introducer, 'plans' => $plans]);
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
        $user = User::find($id);
        $roles = Role::all();
        $plans = Plan::all();

        $user_roles = [];
        $tmp = $user->getRoleNames();
        if (count($tmp) > 0) {
            foreach ($tmp as $key => $value) {
                $user_roles[] = $value;
            }
        }

        return view('user.edit')->with(['user' => $user, 'user_roles' => $user_roles, 'roles' => $roles, 'plans' => $plans]);
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
            'name'        => 'required|max:255',
            'email'       => 'required|email|unique:users,email,'.$id,
            'role'        => 'required',
            'nric'        => 'required|integer|digits:12',
            'contactno'   => 'required|regex:/[0-9]/',
            'memberno'    => 'required',
            'address'     => 'required',
            'dob'         => 'required|date',
            'plan'        => 'required',
            'bankname'    => 'required',
            'bankaccno'   => 'required',
            'n_name'      => 'required|max:255',
            'n_nric'      => 'required|integer|digits:12',
            'n_contactno' => 'required|regex:/[0-9]/',
            'n_bankname'  => 'required',
            'n_bankaccno' => 'required',
            'i_memberno'  => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/user/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nric = $request->nric;
        $user->contactno = $request->contactno;
        $user->memberno = $request->memberno;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->plan = implode("|", $request->plan);
        $user->bankname = $request->bankname;
        $user->bankaccno = $request->bankaccno;
        $user->n_name = $request->n_name;
        $user->n_nric = $request->n_nric;
        $user->n_contactno = $request->n_contactno;
        $user->n_bankname = $request->n_bankname;
        $user->n_bankaccno = $request->n_bankaccno;
        $user->i_memberno = $request->i_memberno;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
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
        $user = User::find($id);
        $user->delete();

        return redirect()->route('staffs.index')->with('success', 'User deleted successfully!');
    }

    /**
     * Impersonate the given user.
     *
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function impersonate(User $user)
    {
        if ($user->id !== ($original = Auth::user()->id)) {
            session()->put('original_user', $original);
            auth()->login($user);
        }

        return redirect()->route('home');
    }

    /**
     * Revert to the original user.
     *
     * @return \Illuminate\Http\Response
     */
    public function revert()
    {
        auth()->loginUsingId(session()->get('original_user'));
        session()->forget('original_user');

        return redirect()->route('home');
    }

    /**
     * Search user.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchuser(Request $request)
    {
        $result = User::select('id', 'name', 'contactno', 'memberno')
            ->where('memberno', $request->keyword)
            ->get();

        return response()->json(['result'=> $result], 200);
    }
}
