<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ActivitylogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::orderBy('id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $user = Auth::user();

                    if ($user->hasPermissionTo('view activitylog')) {
                        $btn = '<a href="'.route('activitylog.show', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-book"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('delete activitylog')) {
                        $btn .= '<form method="POST" style="float:right" action="'.route('activitylog.delete', $row->id).'">'.csrf_field().''.method_field('DELETE').'<a href="javascript:this.submit()" class="btn btn-danger btn-sm delete-activitylog"><span style="color:white" class="oi oi-trash"></span></a></form>';
                    }

                    return $btn;
                })
                ->editColumn('causer_name', function ($row) {
                    return $row->causer_type::find($row->causer_id)->name;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('activitylog.index');
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $activity = Activity::find($id);
        $activity->causer_name = $activity->causer_type::find($activity->causer_id)->name;

        return view('activitylog.show')->with(['activity' => $activity]);
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
        //
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
        //
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
        $activity = Activity::find($id);
        $activity->delete();

        return redirect()->route('activitylog.index')->with('success', 'Activity deleted successfully!');
    }
}
