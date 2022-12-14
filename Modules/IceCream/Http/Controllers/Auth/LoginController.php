<?php

namespace Modules\Icecream\Http\Controllers\Auth;

use App\Helpers\ActivityLogHelper;
use Modules\Icecream\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating icecreams for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect icecreams after login.
     *
     * @var string
     */
    protected $redirectTo = '/icecream';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:icecream')->except('logout');
    }

    public function showLoginForm(){
        return view('icecream::auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        ActivityLogHelper::addToLog('Signed out the system');
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('icecream.login');
    }

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('icecream');
    }

}
