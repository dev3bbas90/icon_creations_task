<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaxAllowedLoggedDevices
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('email' , $request->email ?? 'no-mail')->first();
        if($user && $user->tokens()->where('device_no' , '!=' , $request->device_no)->count() >= env('MAX_ALLOWED_LOGGED_DEVICES' , 2)){
            return new JsonResponse(['message' => 'Your are logged in from 2 other devices !!'], 403);
        }
        return $next($request);
    }


}
