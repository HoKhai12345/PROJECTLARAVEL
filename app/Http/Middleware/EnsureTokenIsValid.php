<?php

namespace App\Http\Middleware;

use Closure;

class EnsureTokenIsValid
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
//        dd($request->expectsJson());
//        if ($request->input('token') !== 'my-secret-token') {
//            return response()->json([
//                "err" => 1,
//                "messenger" => "Un Authorized"
//            ]);
//        }
        dd($request);die;
        if (!$request->expectsJson()){
            return response()->json([
                "err" => 1,
                "messenger" => "Un Authorized"
            ]);
        }
        return $next($request);
    }
}
