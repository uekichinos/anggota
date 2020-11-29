<?php

namespace App\Http\Controllers;

use Hash;
use Validator;
use App\Avatar;
use App\PasswordHistory;
use App\User;
use App\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function edit(Avatar $avatar)
    {
        return view('profile.detail', array('user' => Auth::user()) );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        if($validator->fails()) {
            return redirect(route('profile.edit'))->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.edit')->with('success','User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avatar $avatar)
    {
        //
    }

    /**
     * Display avatar
     */
    public function show_avatar() 
    {
        $image = asset('img/avatar.png');
        $avatar = Avatar::where('userid', Auth::user()->id)->get();
        if($avatar) {
            foreach ($avatar as $key => $value) {
                $image = 'data:'.$value->filetype.';base64,'.$value->filedata;
            }
        }

        return view('profile.avatar', array('image' => $image));
    }

    /**
     * Update avatar
     */
    public function update_avatar(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:1024',
        ]);

        if($validator->fails()) {
            return redirect()->route('avatar.show')->withErrors($validator)->withInput();
        }

        if ($picture = $request->file('avatar')) {

            $path = $request->file('avatar')->getRealPath();
            $binary = file_get_contents($path);
            $base64 = base64_encode($binary);
            
            Avatar::updateOrCreate(['userid' => $id], ['filedata' => $base64]);
        }

        return redirect()->route('avatar.show')->with('success','Updated successfully!');
    }

    /**
     * Edit password form
     */
    public function edit_password()
    {
        $user = Auth::user();

        return view('profile.password')->with(array('user' => $user));
    }

    /**
     * Update password
     */
    public function update_password(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', new Password],
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $validator->after(function ($validator) use ($user) {
            if (!Hash::check(request('current_password'), $user->password)) { 
                $validator->errors()->add('current_password', 'Invalid current password');
            }

            if (PasswordHistory::isExist(request('new_password')) === true) { 
                $validator->errors()->add('new_password', 'Please insert different password');
            }

            $result = PasswordHistory::coldDown();
            if ($result !== false) { 
                $validator->errors()->add('new_password', 'Password cold down period applied. You can try again after '.$result);
            }
        });

        if($validator->fails()) {
            return redirect(route('password.edit'))->withErrors($validator)->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        PasswordHistory::capturePassword($request->new_password);

        return redirect()->route('password.edit')->with('success','Password updated successfully!');
    }
}
