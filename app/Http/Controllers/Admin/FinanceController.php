<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
  public function subscriptions(Request $request)
  {
    if ($request->search) {
      $search = $request->search;


      // $subscriptions = UserSubscription::where('email', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(15)->withQueryString();
      $subscriptions = UserSubscription::whereHas('user', function ($query) use ($search) {
        $query->where('email', 'like', '%' . $search . '%');
      })->orderBy('id', 'desc')->paginate(15)->withQueryString();

    } else {

      $subscriptions = UserSubscription::all();
    }
    return view('admin.finance.subscriptions',['subscriptions'=>$subscriptions]);
  }


  public function payments(Request $request)
  {
    if ($request->search) {
      $search = $request->search;


      // $subscriptions = UserSubscription::where('email', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->paginate(15)->withQueryString();
      $payments = UserPayment::whereHas('user', function ($query) use ($search) {
        $query->where('email', 'like', '%' . $search . '%');
      })->orderBy('id', 'desc')->paginate(15)->withQueryString();
    } else {

      $payments = UserPayment::all();
    }
    return view('admin.finance.payments', ['payments' => $payments]);
  }


}
