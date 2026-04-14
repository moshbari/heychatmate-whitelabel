<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chat;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\UserSubscription;
use App\Http\Controllers\Controller;
use App\Models\ChatAssistant;
use App\Models\User;

class DashboardController extends Controller
{
  public function index()
  {

    $todays = Chat::whereDay('created_at', now()->day)->count();
    $allchats = Chat::count();
    $allassistants = ChatAssistant::count();
    $allusers = User::where('type', 'user')->count();
    $allcredits = User::where('type', 'user')->where('status', 1)->sum('credit_balance');
    $allsubs = UserSubscription::where('status', 1)->count();
    $allpayments = UserPayment::where('status', 1)->sum('amount');

    return view('admin.dashboard', compact('allchats', 'todays', 'allassistants', 'allusers', 'allsubs', 'allpayments','allcredits'));

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
