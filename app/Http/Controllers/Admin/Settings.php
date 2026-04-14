<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MediaHelper;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Http\Controllers\Controller;

class Settings extends Controller
{
  public function index()
  {
    return view('admin.settings.contents');
  }
  public function contact()
  {
    return view('admin.settings.contacts');
  }

  public function logo()
  {
    return view('admin.settings.logo');
  }

  public function smtp()
  {
    return view('admin.settings.smtp');
  }
  public function update(Request $request)
  {
    foreach ($request->except('_token') as $key => $value) {
      update_settings($key, $value);
    }

    return redirect()->back()->with('success', 'Settings Updated!');
  }



  public function updateImage(Request $request)
  {

    $request->validate([
      'logo' => 'mimes:png,jpg,jpeg',
      'favicon' => 'mimes:png,jpg,jpeg,ico',
    ]);
    if ($request->logo) {
      $logo = MediaHelper::handleSettingsImage($request->logo, get_settings('system_logo'));
      //dd($logo);
      update_settings('system_logo', $logo);
    }

    if ($request->favicon) {
      $logo = MediaHelper::handleSettingsImage($request->favicon, get_settings('system_favicon'));
      update_settings('system_favicon', $logo);
    }

    return redirect()->back()->with('success', 'Settings Updated!');
  }



  public function gateway()
  {
    $gateways = PaymentGateway::all();
    return view('admin.gateway.index',['gateways'=> $gateways]);
  }

  public function gatewayUpdate(Request $request,PaymentGateway $gateway)
  {
    //--- Validation Section
    $request->validate(['name' => 'unique:payment_gateways,name,' . $gateway->id]);

    $input = $request->except('_token');
    $info_data = $input['pkey'];

    if (array_key_exists("sandbox_check", $info_data)) {
      $info_data['sandbox_check'] = 1;
    } else {
      if (strpos($gateway->information, 'sandbox_check') !== false) {
        $info_data['sandbox_check'] = 0;
        $text = $info_data['text'];
        unset($info_data['text']);
        $info_data['text'] = $text;
      }
    }
    $input['information'] = json_encode($info_data);
    $input['status'] = $request->status;
    $gateway->update($input);


    return redirect()->back()->with('success', $gateway->name.' Gateway Information Updated!');
  }



}
