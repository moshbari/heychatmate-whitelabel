<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AiModel;
use App\Models\AutoResponder;
use App\Models\UserConfig;

class Settings extends Controller
{
  public function index()
  {
    $user = auth()->user();
    $data['models'] = AiModel::all();
    if (!UserConfig::where('user_id', $user->id)->exists()) {
      $config = new UserConfig();
      $config->user_id = $user->id;
      $config->api_key = '';
      $config->save();
    }

    $data['config'] = UserConfig::where('user_id', $user->id)->first();

    return view('user.settings.apiconfig', $data);
  }

  public function configUpdate(Request $request, $id)
  {
    $user = auth()->user();

    $config = UserConfig::where('user_id', $user->id)->where('id', $id)->first();

    $config->api_key = $request->api_key;
    $config->ai_model = $request->ai_model;
    $config->save();


    return redirect()->back()->with('success', 'Config updated');
  }

  public function responder()
  {
    $user = auth()->user();
    $data['models'] = AiModel::all();
    if (!AutoResponder::where('user_id', $user->id)->exists()) {
      $config = new AutoResponder();
      $config->user_id = $user->id;
      $config->save();
    }

    $data['responder'] = AutoResponder::where('user_id', $user->id)->first();

    return view('user.settings.responders', $data);
  }

  public function responderUpdate(Request $request, $id)
  {
    $user = auth()->user();

    $config = AutoResponder::where('user_id', $user->id)->where('id', $id)->first();

    $config->fill($request->except(['_token','responder']))->save();

    return redirect()->back()->with('success', $request->responder.' Config updated');
  }

}
