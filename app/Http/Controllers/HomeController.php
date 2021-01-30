<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
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

        $count_member = User::role('member')->count();
        $count_withsign = User::role('member')->where('accept_at', '!=', '')->count();
        $count_withoutsign = User::role('member')->where('accept_at', '=', null)->count();

        $user_plan = explode('|', $user->plan);

        $plans = Plan::all();
        if (count($plans) > 0) {
            $planArr = [];
            foreach ($plans as $key => $plan) {
                if (in_array($plan->id, $user_plan)) {
                    $planArr[] = ['name' => $plan->name, 'price' => 'RM '.number_format($plan->price, 2, '.', ',')];
                }
            }
        }

        return view('home', ['user' => $user, 'ismember' => $ismember, 'count_member' => $count_member, 'count_withsign' => $count_withsign, 'count_withoutsign' => $count_withoutsign, 'planArr' => $planArr]);
    }
}
