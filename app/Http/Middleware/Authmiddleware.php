<?php

namespace App\Http\Middleware;
use DB;
use Closure;

class Authmiddleware
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
        $gettoken=$request->header('token');
        $userid = Token::where('token', '=', $token)->value('userid');
        $data= DB::table('users')->where('userid',$userid);
        if($userid==0)
        {
            return response()->json("Unauthorized",401);
        }
        
        $request->merge(['userid' => $userid]);
        
        
        return $next($request);
    }
}
