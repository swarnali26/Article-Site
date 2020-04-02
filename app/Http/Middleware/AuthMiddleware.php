<?php

namespace App\Http\Middleware;

use Closure;
use App\Token;

class AuthMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $gettoken=$request->header('token');
        
         
        $userid = Token::where('token', '=', $gettoken)->value('userid');
        
        if($userid==0)
        {
            return response()->json("Unauthorized",401);
        }
        $request->merge(['userid' => $userid]);
        return $next($request);
    }

}