<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleForDeliveryBoy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \Auth::user();
        if($user->role_id != '4'){ // Delivery Boy Role Id 4
            return response()->json(['success' => false, 'message' => "Access denied."], 200);
        }
        return $next($request);
    }
}
