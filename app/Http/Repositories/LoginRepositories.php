<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\LoginInterface;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRepositories implements LoginInterface
{

    use AuthenticatesUsers;
    protected $maxAttempts = 2;  // Number of allowed attempts
    protected $decayMinutes = .69; // Lockout time in minutes
    // protected $decaySeconds = 20; // Lockout time in Seconds
    protected $redirectTo = '/'; // Lockout time in Seconds

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    // web
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if($this->isBlocked($request)){
            return $this->blockResponse($request);
        }

        if ($this->hasTooManyLoginAttempts($request)) {

            $key             = $this->throttleKey($request);
            $remain_attempts = app(RateLimiter::class)->remaining($key, $this->maxAttempts);
            $this->incrementLoginAttempts($request);
            if($remain_attempts < 0)
            {
                $this->blockAccount($request);
                return $this->blockResponse($request);
            }
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($token = $this->attemptLogin($request)) {
            return $this->sendLoginResponse($token , $request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
    */
    protected function attemptLogin(Request $request)
    {
        if($request->json()){
            return  auth('api')->attempt($this->credentials($request));
        }
        return  auth('api')->attempt(
            $this->credentials($request) , $request->boolean('remember')
        );
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
    */
    protected function guard($guard)
    {
        return auth($guard);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    */
    protected function sendLoginResponse($token , Request $request)
    {
        if($request->wantsJson()){

            $this->storeToken(auth('api')->id() , $request->device_no , $token );
            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
                'user'         => auth('api')->user(),
            ]);
        }

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        try {
            if($request->wantsJson()){
                $this->logoutDeviceToken(auth('api')->id() , $request->device_no );
                auth('api')->logout();
                return response()->json([
                   'message' => 'Logged out Successfully'
                ]);
            }
            $request->user()->logout();
        } catch (\Throwable $th) {
            return $request->wantsJson()
            ? new JsonResponse(['message' => $th->getMessage()], 204)
            : redirect()->intended($this->redirectPath())->with('error' , $th->getMessage());
        }
    }

    function blockAccount($request) {
        $user = User::where('email' , $request->email)->first();
        if($user){
            $user->update(['status' => 'blocked' ]);
            return true;
        }
        return false;
    }

    function isBlocked($request) {
        $user = User::withoutGlobalScope('active')->where('email' , $request->email)->first();
        if($user && !$user->is_active){
            return true;
        }
        return false;
    }

    function blockResponse($request) {
        return $request->wantsJson()
            ? new JsonResponse(['message' => 'Your Account is blocked !!'], 403)
            : redirect()->intended($this->redirectPath())->with('error' , 'Your Account is blocked !!');
    }

    protected function storeToken($user_id , $device_no , $token ) {

        UserToken::updateOrCreate([
            'user_id'    => $user_id,
            'device_no'  => $device_no,
        ],[
            'user_id'    => $user_id,
            'device_no'  => $device_no,
        ]);
    }

    function logoutDeviceToken($user_id , $device_no ) {
        UserToken::where([['user_id'  , $user_id] , [ 'device_no'  , $device_no ]])->update([
            'is_logout'      => 1,
        ]);
        return true;
    }




}
