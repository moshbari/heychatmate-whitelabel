<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\User;
use App\Classes\GeniusMailer;
use App\Models\BankPlan;
use App\Models\Currency;
use App\Models\Notification;
use App\Models\ReferralBonus;
use App\Models\Transaction;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use Validator;
use Session;

class RegisterController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function showRegisterForm()
  {
    return view('front.register');
  }
  public function showForgotForm()
  {
    return view('front.forgot');
  }

  public function register(Request $request)
  {
    // $value = session('captcha_string');
    if (get_settings('user_registration') == 0) {
      return redirect()->back()->with('error', 'User registration is temporary closed!');
    }

    $rules = [
      'name' => 'required|string|max:160',
      'email'   => 'required|email|unique:users',
      'password' => 'required|min:6',
      'confirm_password' => 'required|min:6|same:password'
    ];
    $messages = [
      'confirm_password.same' => 'Password Confirmation should match the Password',
    ];
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return redirect()->back()->with('errors',$validator->getMessageBag());
    }

    $user = new User;
    $input = $request->all();

    $input['password'] = bcrypt($request['password']);

    $user->fill($input)->save();

    if (get_settings('global_email') == 1 && get_settings('email_verification') == 1) {
      $user->verify_token = md5($user->email.time());
      $user->save();

      @email([
        'email'   => $user->email,
        'name'    => $user->name,
        'subject' => __('Email Verification Code'),
        'message' => __('Your Email Verification Link is : ') . "<a href='" . route('verify.register', $user->verify_token) . "' target='_blank'>" . route('verify.register', $user->verify_token) . "</a><br><a style='padding:10px;color:white;background:green;text-decoration:none;' href='" . route('verify.register', $user->verify_token)."' target='_blank'>Click Here to Verity</a>",
      ]);
    }

    Auth::guard('web')->login($user);

    return redirect()->route('user.dashboard');

  }

  public function token($token)
  {

    if (get_settings('global_email') == 1 && get_settings('email_verification') == 1) {
      $user = User::where('verify_token', '=', $token)->first();
      if (isset($user)) {
        $user->email_verified = 1;
        $user->email_verified_at = now();
        $user->update();

        @email([
          'email'   => $user->email,
          'name'    => $user->name,
          'subject' => __('Email Verification Completed'),
          'message' => __('Your Email Verification Completed Successfully'),
        ]);

        Auth::guard('web')->login($user);
        return redirect()->route('user.dashboard')->with('success', 'Email Verified Successfully');
      }
    } else {
      return redirect()->back();
    }
  }
}
