<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index()
  {

    $todays = Chat::whereDay('created_at', now()->day)->count();
    $alls = Chat::count();

    return view('content.dashboard.dashboards-analytics',compact('alls','todays'));
  }
}
