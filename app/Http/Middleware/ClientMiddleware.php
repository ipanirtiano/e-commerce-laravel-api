<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // get token from headers
         $token = $request->header('Authorization');

         // set authenticate
         $authanticate = true;
 
         // check token
         if(!$token){
             $authanticate = false;
         }
 
 
         // validate token to database user
         $user = User::where('token', $token)->first();
         if(!$user){
             $authanticate = false;
         }else{
             Auth::login($user);
         }
 
         // check status authenticate
         if($authanticate){
 
             return $next($request);
         }else{
             // return response status unauthorized
             return response()->json([
                 'error' => 'Unauthorized'
             ])->setStatusCode(401);
         }
    }
}
