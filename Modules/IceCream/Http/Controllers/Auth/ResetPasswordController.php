<?php

namespace Modules\Icecream\Http\Controllers\Auth;

use App\Models\Icecream;
// use Illuminate\Routing\Controller;

use Modules\Icecream\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */


    // use ResetsPasswords;

    public function index()
    {
        return view('icecream::auth.passwords.email');
    }

    public function validatePasswordRequest(HttpRequest $request)
    {
        $user = Icecream::where('email', '=', $request->email)
            ->first();
        //Check if the user exists
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }
    }
    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('icecreams')->where('email', $email)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = env('APP_URL') . '/icecream/password/reset/' . $token . '?email=' . urlencode($user->email);

        // dd($link);
        try {
            Mail::send('icecream::mails.reset_password_mail', ['user' => $user, 'token' => $token, 'link' => $link], function ($m) use ($user) {
                $m->from('amelipaapp@gmail.com', 'Morning Sky General');

                $m->to($user->email, $user->name)->subject('Password Reset Link');
            });
            return true;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }
    public function reset($token)
    {
        return view('icecream::auth.passwords.reset', compact('token'));
    }

    public function resetPassword(HttpRequest $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:icecreams,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('icecream::auth.passwords.email');

        $user = Icecream::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
        //Hash and update the new password
        $user->password = Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
            ->delete();
        notify()->success('You have successful reset your password');

        return view('icecream::index');
    }
    /**
     * Where to redirect icecreams after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/icecream';
}
