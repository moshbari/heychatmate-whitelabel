<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\AiInstruction;
use App\Models\PaymentGateway;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
  //
  public function index()
  {
    $mplans = Plan::where('type', 'month')->get();
    $yplans = Plan::where('type', 'year')->get();
    $cplans = Plan::where('type', 'credit')->get();
    return view('user.plan.index', ['mplans' => $mplans, 'yplans' => $yplans, 'cplans' => $cplans]);
  }

  public function plancheckout($id)
  {
    $plan = Plan::findOrFail($id);
    return view('user.plan.checkout', ['plan' => $plan]);
  }

  public function submitcheckout(Request $request)
  {

    $plan = Plan::findOrFail($request->planid);
    $input = $request->merge(['amount' => $plan->price])->except('_token');

    // dd($input);

    if ($plan->price == 0) {

      $user = User::findOrFail(auth()->user()->id);

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

      $this->balanceUpdate($user->id, ['planid' => $plan->id, 'balance' => $plan->credits]);


      return redirect()->route('user.dashboard')->with('success', 'Subscription Completed successfully!');
    }

    Session::put('deposit_data', $input);

    $deposit_data = Session::get('deposit_data');
    // $gateway = PaymentGateway::findOrFail($deposit_data['gateway']);

    $service =  str_replace('User', '', __NAMESPACE__) . 'Gateway' . '\\' . ucwords($deposit_data['keyword']);

    $deposit = $service::initiate($request, $deposit_data, 'deposit');

    if ($deposit['status'] == 1 && isset($deposit['url'])) {
      return redirect($deposit['url']);
    }

    return redirect()->route('user.dashboard')->with('success', 'Subscription Completed successfully!');
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
    $trnx->amount      = $data['balance'];
    $trnx->remark      = 'credit';
    $trnx->type        = '+';
    $trnx->status      = 1;
    $trnx->details     = trans('Purchased Plan Credits');
    $trnx->save();
  }

  public function plandelete($id)
  {

    $plan = Plan::findOrFail($id);
    $plan->delete();

    return redirect()->back();
  }


  public function chatSubmit(Request $request)
  {
    return $request->content;
  }


  function get_client_ip()
  {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
}
