<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // new MainMenu;
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ismember = false;

        $user = Auth::user();

        $role = $user->getRoleNames()[0];
        if ($role == 'member') {
            $ismember = true;
        }

        return view('home', ['user' => $user, 'ismember' => $ismember]);
    }
}
