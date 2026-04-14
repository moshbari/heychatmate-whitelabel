<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Transaction;
use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  //
  public function index(Request $request)
  {
    if ($request->search) {
      $search = $request->search;
      $users = User::where('email', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(15)->withQueryString();
    }else {

      $users = User::orderBy('id', 'desc')->paginate(15)->withQueryString();
    }
    return view('admin.user.index', ['users' => $users]);
  }


  public function submit(Request $request)
  {

    $request->validate([
      'email' => 'unique:users,email|required',
      'name' => 'required',
      'phone' => 'required',
      'country' => 'required',
      'password' => 'required',
    ]);

    $user               = new User();
    $user->name         = $request->name;
    $user->email         = $request->email;
    $user->phone         = $request->phone;
    $user->country         = $request->country;
    $user->password      = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'New User Created Successfully!');
  }


  public function billingUpdate(Request $request, $id)
  {

    $user = User::findOrFail($id);
    $plan = Plan::findOrFail($request->choosePlan);

    if ($user->subscription) {

      $date = $user->subscription->due_date;
      $daysToAdd = $plan->type == 'year' ? 365 : 30;
      $date = $date->addDays($daysToAdd);

      $subscription                  = UserSubscription::findOrFail($user->subscription->id);
      $subscription->user_id         = $user->id;
      $subscription->plan_id         = $plan->id;
      $subscription->amount          = $plan->price;
      $subscription->cycle           = $plan->type;
      $subscription->due_date        = $date;
      $subscription->status          = 1;
      $subscription->payment_method  = 0;
      $subscription->save();
    } else {
      $date = Carbon::now();
      $daysToAdd = $plan->type == 'year' ? 365 : 30;
      $date = $date->addDays($daysToAdd);

      $subscription                  = new UserSubscription();
      $subscription->user_id         = $user->id;
      $subscription->plan_id         = $plan->id;
      $subscription->amount          = $plan->price;
      $subscription->cycle           = $plan->type;
      $subscription->due_date        = $date;
      $subscription->status          = 1;
      $subscription->payment_method  = 0;
      $subscription->save();
    }


    $this->balanceUpdate($user->id, ['planid'=> $plan->id, 'balance' => $plan->credits]);

    return redirect()->back()->with('success', 'User Subscription Updated Successfully!');
  }


  public function update(Request $request, $id)
  {

    $request->validate([
      'email' => 'required|unique:users,email,' . $id,
      'photo' => 'mimes:png,jpg,jpeg',
      'name' => 'required',
    ]);

    $user               = User::findOrFail($id);
    $user->name         = $request->name;
    $user->email         = $request->email;
    $user->phone         = $request->phone;
    $user->country       = $request->country;
    $user->type         = $request->role;
    $user->status         = $request->status;

    if ($request->photo) {
      $user->photo = MediaHelper::handleProfileImage($request->photo, [400, 400]);
    }
    $user->save();

    return redirect()->back()->with('success', 'User Information Updated Successfully!');
  }


  public function balanceUpdate($userid, $data)
  {
    $user = User::findOrFail($userid);
    $user->credit_balance += $data['balance'];
    $user->update();

    $trnx              = new Transaction();
    $trnx->trx_id      = str_rand();
    $trnx->plan_id     = $data['planid'];
    $trnx->user_id     = $user->id;
    $trnx->amount      = $data['balance']??0;
    $trnx->remark      = 'credit';
    $trnx->type        = '+';
    $trnx->status      = 1;
    $trnx->details     = trans('Purchased Plan Credits');
    $trnx->save();
  }



  public function balance(Request $request, $id)
  {

    $request->validate([
      'operation' => 'required',
      'amount' => 'required|min:1',
    ]);

    $user               = User::findOrFail($id);

    if ($request->operation == "add") {

      $user->credit_balance         += $request->amount;
    }

    if ($request->operation == "subtract") {

      $user->credit_balance         -= $request->amount;
    }
    $user->save();

    $trnx              = new Transaction();
    $trnx->trx_id      = str_rand();
    $trnx->user_id     = $user->id;
    $trnx->amount      = $request->amount;
    $trnx->remark      = $request->operation == "add"?'credit':'debit';
    $trnx->type        = $request->operation == "add" ? '+' : '-';
    $trnx->status      = 1;
    $trnx->details     = trans('Modified By Admin');
    $trnx->save();

    return redirect()->back()->with('success', 'User Balance Updated Successfully!');
  }


  public function passwords(Request $request, $id)
  {

    $request->validate([
      'pass' => 'required',
      'repass' => 'required',
    ]);
    $user               = User::findOrFail($id);

    if ($request->pass == $request->repass) {
      $input['password'] = Hash::make($request->pass);
    } else {
      return redirect()->back()->with('error', 'Confirm new password does not match.');
    }


    $user->update($input);


    $msg = 'Successfully Changed your password!';
    return redirect()->back()->with('success', $msg);

    $user               = User::findOrFail($id);
    $user->name         = $request->name;
    $user->email         = $request->email;
    $user->phone         = $request->phone;
    $user->country       = $request->country;
    $user->type         = $request->role;
    $user->status         = $request->status;
    $user->password      = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'User Information Updated Successfully!');
  }

  public function cancelSub($id)
  {
    $user = User::findOrFail($id);

    if ($user->subscription) {

      $date = now();

      $subscription                  = UserSubscription::findOrFail($user->subscription->id);
      $subscription->due_date        = $date;
      $subscription->status          = 0;
      $subscription->save();
    }

    return redirect()->back()->with('success', 'User Subscription Cancelled Successfully!');
  }
  public function view($id)
  {

    $user = User::findOrFail($id);

    return view('admin.user.details', ['user' => $user]);
  }


  public function security($id)
  {

    $user = User::findOrFail($id);

    return view('admin.user.security', ['user' => $user]);
  }


  public function billing($id)
  {

    $user = User::findOrFail($id);
    $plans = Plan::where('type', '!=', 'credit')->where('status', 1)->get();

    return view('admin.user.billing', ['user' => $user, 'plans' => $plans]);
  }


  public function plandelete($id)
  {

    $plan = User::findOrFail($id);
    $plan->delete();

    return redirect()->back();
  }
}
