<?php

namespace App\Http\Controllers\User;

use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use App\Models\Transaction;

class ReportController extends Controller
{
  public function creditHistory()
  {
    $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
    return view('user.reports.history',['transactions'=> $transactions]);
  }


  public function payments()
  {
    $payments = UserPayment::where('user_id',auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
    return view('user.reports.payments', ['payments' => $payments]);
  }


}
