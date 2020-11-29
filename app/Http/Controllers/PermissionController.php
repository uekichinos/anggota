<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

// use App\MainMenu;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // new MainMenu;
        // $this->middleware(['permission:list permission']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();

            return Datatables::of($data)->addIndexColumn()->make(true);
        }

        return view('permission.index');
    }
}
