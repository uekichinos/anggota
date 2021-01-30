<?php

namespace App\Http\Controllers;

use App;
use App\Plan;
use App\Rules\Password;
use App\User;
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
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nric = $request->nric;
        $user->contactno = $request->contactno;
        $user->memberno = $request->memberno;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->plan = implode('|', $request->plan);
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
        $user->plan = implode('|', $request->plan);
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

    /**
     * Member acceptance.
     *
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request)
    {
        $user = Auth::user();
        $copywriting = $this->copywriting();

        return view('user.accept')->with(['user' => $user, 'copywriting' => $copywriting]);
    }

    /**
     * Member sign acceptance.
     *
     * @return \Illuminate\Http\Response
     */
    public function sign(Request $request)
    {
        $user = Auth::user();
        $user->accept_at = date('Y-m-d H:i:s');
        $user->save();

        return redirect()->route('home');
    }

    /**
     * Acceptance copy writing.
     *
     * @return \Illuminate\Http\Response
     */
    public function copywriting()
    {
        $string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dapibus turpis quis lorem aliquam lobortis. Donec ut ultricies nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis eget orci sit amet odio suscipit finibus at vel nisi. Aliquam convallis neque ac purus volutpat ultricies. Duis vitae tincidunt turpis, et vestibulum tellus. In purus ante, congue nec nisl non, accumsan venenatis lorem. Vivamus nunc nulla, posuere eu hendrerit a, pretium efficitur est. Vestibulum feugiat tempor elit in scelerisque. Morbi non pellentesque odio. Vestibulum et dignissim nulla.<br><br>Phasellus rutrum ultrices magna quis placerat. Vivamus quis elementum risus. Pellentesque eu dapibus nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent lorem est, rhoncus id ligula ac, aliquet consequat urna. Maecenas tincidunt elementum risus dictum sodales. Nam finibus massa eget ultricies commodo. Nam consequat diam mauris, non lobortis felis sollicitudin sed. Maecenas malesuada mattis consequat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean cursus arcu nisi, vel feugiat diam iaculis a. Pellentesque dapibus metus mi, et laoreet eros imperdiet ut. Pellentesque tincidunt augue eget leo mattis, quis finibus urna mollis. Fusce imperdiet congue suscipit. Praesent molestie ipsum et libero ultricies, in gravida lorem elementum.<br><br>Nulla consequat ipsum commodo leo eleifend, a imperdiet ligula convallis. Cras a odio vel arcu tincidunt tempor. Aenean condimentum velit consequat, fringilla odio a, fringilla ex. Phasellus efficitur finibus felis. Cras ornare pellentesque tincidunt. Cras rhoncus tellus at felis egestas, vel venenatis felis convallis. Donec pellentesque vestibulum erat sagittis facilisis. Ut finibus, lorem vel tempus venenatis, enim urna pellentesque quam, in mattis sapien leo sit amet erat. In ullamcorper congue justo, varius posuere tortor. Nulla porttitor sem et urna consectetur, eget rhoncus tellus dapibus. Sed condimentum felis ut orci pulvinar, ac blandit urna egestas. Quisque in tellus augue. Integer ullamcorper sollicitudin nulla. Nullam egestas iaculis odio aliquet pretium.<br><br>Donec eget iaculis metus. Maecenas nec arcu varius nunc auctor fringilla eget sed tellus. Sed condimentum malesuada enim semper tincidunt. Praesent scelerisque non nisi a ultricies. In egestas ipsum a augue scelerisque, eget luctus ex tincidunt. Etiam et congue lacus. Suspendisse vitae iaculis leo. Mauris ac vulputate orci. Aliquam ut tincidunt risus. Sed dignissim massa id ipsum laoreet, at vehicula ipsum consequat. Nam convallis eu purus quis eleifend. Mauris in tempus lectus. Sed sed purus justo. Integer vehicula iaculis diam eget commodo. Nam id porta augue, et venenatis nulla.<br><br>Nam hendrerit ipsum ut neque tincidunt gravida. Aenean eu orci eget libero iaculis ornare. Donec sagittis varius neque, id scelerisque ipsum sollicitudin sit amet. Ut pulvinar, nunc id vehicula varius, nisi velit convallis lacus, sed sollicitudin eros elit sit amet ante. Etiam tempor eu nunc consectetur pretium. Pellentesque urna nulla, faucibus nec odio at, dictum varius purus. Phasellus at erat et quam porta vulputate. Morbi rutrum orci id magna ullamcorper, et suscipit ex tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut molestie mi in malesuada congue. Sed non est eget est scelerisque congue a maximus felis. Aenean vestibulum vestibulum nibh in pretium. Nullam non semper sem. Donec nec mi nunc.<br><br>';

        return $string;
    }

    /**
     * Download Acceptance.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        $copywriting = $this->copywriting();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($copywriting);

        return $pdf->download('accept.pdf');
    }
}
