<?php

namespace  App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{

  public function balanceUpdate($user, $deposit_data)
  {
    $user = User::findOrFail(auth()->user()->id);
    $user->credit_balance += $deposit_data['credit_balance'];
    $user->update();

    //dd($deposit_data);

    $trnx              = new Transaction();
    $trnx->trx_id      = str_rand();
    $trnx->plan_id     = $deposit_data['planid'];
    $trnx->user_id     = $user->id;
    $trnx->amount      = $deposit_data['credit_balance'];
    $trnx->remark      = 'credit';
    $trnx->type        = '+';
    $trnx->status      = 1;
    $trnx->details     = trans('Purchased Plan Credits');
    $trnx->save();
  }



  public function createPayment($data)
  {
    //dd($data);
    $user = auth()->user();
    $payment = new UserPayment();
    $payment->plan_id = $data['planid'];
    $payment->user_id  = $user->id;
    $payment->amount   = $data['amount'];
    $payment->gateway_id   = gatewayID($data['keyword']);
    $payment->payment_id   = $data['checkout_session_id'];
    $payment->currency_code = get_settings('currency_code');
    $payment->save();
  }

  public function notifyOperation($deposit)
  {
    $deposit_data = Session::get('deposit_data');

    //dd($deposit_data);

    //try {
      if ($deposit['status'] == 1 && $deposit['txn_id']) {
        $user = auth()->user();

        $payment = UserPayment::where('payment_id', $deposit['session_id']);

        if ($payment->exists()) {
          $payment = $payment->first();

          if($payment->status == 1){

            return redirect(route('subscription.index'))->with('success', 'Already Completed this Payment Once!');
          }

          $payment->status  = 1;
          $payment->gateway_data  = $deposit['txn_id'];
          $payment->save();


          if ($payment->plan->type != 'credit') {

            //$existingsub = UserSubscription::where('user')
            if($user->subscription){

              $date = $user->subscription->due_date;
              $daysToAdd = $payment->plan->type == 'year'?365:30;
              $date = $date->addDays($daysToAdd);

              $subscription                  = UserSubscription::findOrFail($user->subscription->id);
              $subscription->user_id         = $user->id;
              $subscription->plan_id         = $payment->plan->id;
              $subscription->amount          = $payment->plan->price;
              $subscription->cycle           = $payment->plan->type;
              $subscription->due_date        = $date;
              $subscription->status          = 1;
              $subscription->payment_method  = $payment->gateway_id;
              $subscription->save();


            }else{
              $date = Carbon::now();
              $daysToAdd = $payment->plan->type == 'year' ? 365 : 30;
              $date = $date->addDays($daysToAdd);

              $subscription                  = new UserSubscription();
              $subscription->user_id         = $user->id;
              $subscription->plan_id         = $payment->plan->id;
              $subscription->amount          = $payment->plan->price;
              $subscription->cycle           = $payment->plan->type;
              $subscription->due_date        = $date;
              $subscription->status          = 1;
              $subscription->payment_method  = $payment->gateway_id;
              $subscription->save();
            }


          }
        } else {

          return redirect(route('subscription.index'))->with('error', __('Somthing want wront please try again'));
        }


        $deposit_data['credit_balance'] = $payment->plan->credits;

        $this->balanceUpdate($user, $deposit_data);
        $msg = __('Your Purchase Completed successfully');


        Session::forget('deposit_data');
        return redirect(route('subscription.index'))->with('success', $msg);
      }
    // } catch (\Throwable $th) {
    //   return redirect(route('subscription.index'))->with('error', __('Somthing want wront please try again'));
    // }
  }
}
