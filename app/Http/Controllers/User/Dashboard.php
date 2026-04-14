<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\AutoResponders;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
  public function index()
  {
    AutoResponders::systemIoCall('shaoneel@gmail.com', 1);
    $todays = Chat::where('user_id',auth()->user()->id)->whereDay('created_at', now()->day)->count();
    $todayscredit = Transaction::where('user_id', auth()->user()->id)->whereDay('created_at', now()->day)->sum('amount');
    $dateFrom = Carbon::now()->subDays(30);
    $dateTo = Carbon::now();

    $last30 = Transaction::where('user_id', auth()->user()->id)->whereBetween('created_at', [$dateFrom, $dateTo])
      ->sum('amount');
    $alls = Chat::where('user_id', auth()->user()->id)->count();

    return view('user.dashboard',compact('alls','todays','todayscredit','last30'));
  }
}
