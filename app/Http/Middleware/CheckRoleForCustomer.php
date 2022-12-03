<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleForCustomer
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
        if($user->role_id != '5'){ // Customer Role Id 5
            return response()->json(['success' => false, 'message' => "Access denied."], 200);
        }
        return $next($request);
    }
}
