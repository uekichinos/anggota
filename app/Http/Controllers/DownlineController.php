<?php

namespace App\Http\Controllers;

// use App\Downline;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class DownlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $user = Auth::user();

            $data = User::select('name', 'email', 'contactno', 'created_at')->where('i_memberno', $user->memberno)->orderBy('created_at', 'desc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->make(true);
        }

        return view('downline.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Downline  $downline
     * @return \Illuminate\Http\Response
     */
    public function show(Downline $downline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Downline  $downline
     * @return \Illuminate\Http\Response
     */
    public function edit(Downline $downline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Downline  $downline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Downline $downline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Downline  $downline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Downline $downline)
    {
        //
    }
}
