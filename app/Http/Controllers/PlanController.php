<?php

namespace App\Http\Controllers;

use App\Plan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Plan::all();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $user = Auth::user();

                    $btn = '';
                    if ($user->hasPermissionTo('view plan')) {
                        $btn .= '<a href="'.route('plan.show', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-book"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('edit plan')) {
                        $btn .= '<a href="'.route('plan.edit', $row->id).'" class="btn btn-primary btn-sm"><span style="color:white" class="oi oi-pencil"></span></a>&nbsp;';
                    }
                    if ($user->hasPermissionTo('delete plan')) {
                        $btn .= '<form method="POST" style="float:right" action="'.route('plan.delete', $row->id).'">'.csrf_field().''.method_field('DELETE').'<a href="javascript:this.submit()" class="btn btn-danger btn-sm delete-plan"><span style="color:white" class="oi oi-trash"></span></a></form>';
                    }

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y, H:i', strtotime($row->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('plan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plan.create');
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
            'desc'            => 'required',
            'price'           => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('plan.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->desc = $request->desc;
        $plan->price = $request->price;
        $plan->save();

        return redirect()->route('plan.index')->with('success', 'Plan created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan = Plan::find($id);

        return view('plan.show')->with(['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::find($id);

        return view('plan.edit')->with(['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Plan                $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|max:255',
            'desc'            => 'required',
            'price'           => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/plan/edit/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->desc = $request->desc;
        $plan->price = $request->price;
        $plan->save();

        return redirect()->route('plan.index')->with('success', 'Plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Plan $plan
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
