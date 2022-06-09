<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get token from request
        $token = null;
        $headers = apache_request_headers();
        if(isset($headers['Authorization'])){
            $matches = array();
            preg_match('/Token token="(.*)"/', $headers['Authorization'], $matches);
            if(isset($matches[1])){
                $token = $matches[1];
            }
        } 

        // Check if the token exists
        if(!$token) {
            return response()->json('Not authorize to access this route: token failed"', 401);
        }


        
        return $next($request);
    }
}
