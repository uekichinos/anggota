<?php

namespace App\Http\Controllers;

use App\Rules\Password;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_maintenance()
    {
        $settings = Setting::where('param', 'LIKE', 'maintenance_%')->get();

        return view('setting.maintenance', ['settings' => $settings]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_maintenance(Request $request)
    {
        $fields = [
            'maintenance_msg'   => 'required|max:255',
            'maintenance_retry' => 'required|integer',
            'maintenance_allow' => 'required',
            'maintenance_mode'  => 'required',
        ];

        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return redirect(route('setting.maintenance'))->withErrors($validator)->withInput();
        }

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.maintenance')->with('success', 'Updated successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_ga()
    {
        $settings = Setting::where('param', 'LIKE', 'ga_%')->get();

        return view('setting.ga', ['settings' => $settings]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_ga(Request $request)
    {
        $fields = [
            'ga_mode' => 'required',
            'ga_code' => Rule::requiredIf(function () use ($request) {
                return $request->ga_mode == 'yes';
            }),
            'ga_track' => 'required',
        ];

        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return redirect(route('setting.ga'))->withErrors($validator)->withInput();
        }

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.ga')->with('success', 'Updated successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_announce()
    {
        $settings = Setting::where('param', 'LIKE', 'announce_%')->get();

        return view('setting.announce', ['settings' => $settings]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_announce(Request $request)
    {
        $fields = [
            'announce_mode' => 'required',
            'announce_msg'  => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_start' => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_end' => Rule::requiredIf(function () use ($request) {
                return $request->announce_mode == 'yes';
            }),
            'announce_mood' => 'required',
        ];

        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return redirect(route('setting.announce'))->withErrors($validator)->withInput();
        }

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.announce')->with('success', 'Updated successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_password()
    {
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();

        return view('setting.password', ['settings' => $settings]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request)
    {
        // $fields = [
        //     'password_number' => 'required',
        //     'password_character' => 'required',
        //     'password_uppercase' => 'required',
        //     'password_specialcharacter' => 'required',
        //     'password_min' => 'required',
        //     'password_max' => 'required',
        //     'password_history' => 'required',
        //     'password_colddown' => 'required',
        // ];

        $fields = [];
        $settings = Setting::where('param', 'LIKE', 'password_%')->get();
        if ($settings !== null) {
            foreach ($settings as $key => $setting) {
                $fields[$setting->param] = 'required';
            }
        }

        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return redirect(route('setting.password'))->withErrors($validator)->withInput();
        }

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.password')->with('success', 'Updated successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_header()
    {
        $settings = Setting::where('param', 'LIKE', 'header_%')->get();

        return view('setting.header', ['settings' => $settings]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_header(Request $request)
    {
        $fields = [
            'header_title' => 'required|max:255',
        ];

        $validator = Validator::make($request->all(), $fields);
        if ($validator->fails()) {
            return redirect(route('setting.header'))->withErrors($validator)->withInput();
        }

        foreach ($fields as $field => $rule) {
            $setting = Setting::where('param', $field)->first();
            $setting->value = $request->{$field};
            $setting->save();
        }

        return redirect()->route('setting.header')->with('success', 'Updated successfully!');
    }
}
