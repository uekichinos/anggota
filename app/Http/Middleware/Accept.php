<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class Accept
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $role = $user->getRoleNames()[0];
        if(empty($user->accept_at) && $role == 'member') {
            return redirect()->route('accept.index');
        }
        else {
            return $next($request);
        }
    }
}
