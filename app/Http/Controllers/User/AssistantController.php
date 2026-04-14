<?php

namespace App\Http\Controllers\User;

use App\Models\FormField;
use App\Models\TrainData;
use Illuminate\Support\Str;
use App\Helpers\MediaHelper;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\AiInstruction;
use App\Models\ChatAssistant;
use App\Http\Controllers\Controller;
use League\CommonMark\CommonMarkConverter;

class AssistantController extends Controller
{
  //
  public function index()
  {
    $assistants = ChatAssistant::where('user_id', auth()->user()->id)->latest()->get();
    return view('user.assistant.index', ['assistants' => $assistants]);
  }


  public function create()
  {
    if (auth()->user()->hasActiveSubscription()) {

      if (ChatAssistant::where('user_id', auth()->user()->id)->count() < auth()->user()->subscription->plan->max_bots) {

        return view('user.assistant.create');
      } else {
        return redirect()->back()->with('error', 'Your Maximum Assistant Create Limit Reached. <a href="' . route('subscription.index') . '" class="btn btn-primary me-2 my-2">Upgrade
                                    Subscription</a> To Add More assistants.');
      }
    } else {

      return redirect()->back()->with('error', 'You dont have any subscriptions. <a href="' . route('subscription.index') . '" class="btn btn-primary me-2 my-2">Add
                                    Subscription</a>');
    }
  }

  public function submit(Request $request)
  {

    $request->validate([
      'name' => 'required',
      'avatar' => 'required|mimes:png,jpg,jpeg',
      'page_title' => 'required',
      'chat_title' => 'required',
    ]);

    $assistant          = new ChatAssistant();
    $assistant->name    = $request->name;
    $assistant->user_id    = auth()->user()->id;
    $assistant->page_title   = $request->page_title;
    $assistant->slug   = sha1(time());
    $assistant->chat_title    = $request->chat_title;
    $assistant->form_title    = $request->form_title;
    $assistant->floating_text     = $request->floating_text;
    $assistant->first_reply = $request->first_reply;
    $assistant->chat_color = $request->chat_color;
    $assistant->type_effect = $request->type_effect;
    $assistant->phone_field = $request->phone_field;


    if($request->chat_icon == 'custom'){

      if ($request->cicon) {
        $assistant->chat_icon = MediaHelper::handleMakeImage($request->cicon, [250, 250],false,true);
      }

    }else{
      $assistant->chat_icon = $request->chat_icon;
    }


    if ($request->avatar) {
      $assistant->avatar = MediaHelper::handleMakeImage($request->avatar, [300, 300]);
    }


    $assistant->save();

    return redirect()->route('manage.assistant')->with('success', 'New Chat Assistant Created Successfully.');
  }


  public function edit($id)
  {

    $assistant  = ChatAssistant::findOrFail($id);
    $this->authorize('update', $assistant);
    return view('user.assistant.edit', ['assistant' => $assistant]);
  }

  public function update(Request $request, $id)
  {


    $request->validate([
      'name' => 'required',
      'avatar' => 'mimes:png,jpg,jpeg',
      'page_title' => 'required',
      'chat_title' => 'required',
    ]);

    $assistant          = ChatAssistant::findOrFail($id);


    $this->authorize('update', $assistant);

    $assistant->name    = $request->name;
    $assistant->user_id    = auth()->user()->id;
    $assistant->page_title   = $request->page_title;
    $assistant->chat_title    = $request->chat_title;
    $assistant->form_title    = $request->form_title;
    $assistant->floating_text     = $request->floating_text;
    $assistant->first_reply = $request->first_reply;
    $assistant->chat_color = $request->chat_color;
    $assistant->type_effect = $request->type_effect;
    $assistant->phone_field = $request->phone_field;

    if ($request->chat_icon == 'custom') {

      if ($request->cicon) {
        if (file_exists(asset('assets/img/icons/hey-icons/' . $assistant->chat_icon))) {
          unlink(asset('assets/img/icons/hey-icons/' . $assistant->chat_icon));
        }
        $assistant->chat_icon = MediaHelper::handleMakeImage($request->cicon, [250, 250],false,true);
      }
    } else {
      $assistant->chat_icon = $request->chat_icon;
    }

    if ($request->avatar) {
      $assistant->avatar = MediaHelper::handleMakeImage($request->avatar, [300, 300]);
    }
    $assistant->save();

    return redirect()->route('manage.assistant')->with('success', 'Chat Assistant Updated Successfully.');
  }

  public function delete($id)
  {
    $assistant = ChatAssistant::findOrFail($id);
    $this->authorize('update', $assistant);
    $assistant->traindata()->delete();
    $assistant->delete();

    return redirect()->back()->with('success', 'Chat Assistant Deleted Successfully.');
  }

  public function domain(Request $request, $id)
  {

    if(!isValidDomain($request->allowed_domain) && $request->allowed_domain != null){

      return redirect()->back()->with('error', 'Domain is not valid! You can add one domain only. Ex. example.com');
    }

    $assistant          = ChatAssistant::findOrFail($id);

    $this->authorize('update', $assistant);
    $assistant->allowed_domain    = $request->allowed_domain;

    $assistant->save();

    return redirect()->back()->with('success', 'Domain Configuration Updated.');
  }

  public function fieldsubmit(Request $request)
  {

    $request->validate([
      'type' => 'required',
      'label' => 'required',
      'required' => 'required',
    ]);

    $assistant          = new FormField();
    $assistant->type    = $request->type;
    $assistant->user_id    = auth()->user()->id;
    $assistant->chat_assistant_id    = $request->ass_id;
    $assistant->label   = $request->label;
    $assistant->name   = Str::slug($request->label, '_');
    $assistant->required  = $request->required;

    $assistant->save();

    return back()->with('success', 'Form field added successfully');
  }

  public function fieldupdate(Request $request)
  {


    $assistant          = FormField::findOrFail($request->field_id);

    $this->authorize('update', $assistant->assistant);
    $request->validate([
      'type' => 'required',
      'label' => 'required',
      'required' => 'required',
    ]);

    $assistant->type    = $request->type;
    $assistant->user_id    = auth()->user()->id;
    $assistant->label   = $request->label;
    $assistant->name   = Str::slug($request->label, '_');
    $assistant->required  = $request->required;

    $assistant->save();

    return back()->with('success', 'Form field Updated Successfully.');
  }

  public function fielddelete($id)
  {
    $assistant = FormField::findOrFail($id);
    $this->authorize('update', $assistant->assistant);
    $assistant->delete();
    return redirect()->back()->with('success', 'Form field Deleted Successfully.');;
  }


  public function config($id)
  {

    $assistant = ChatAssistant::findOrFail($id);
    $this->authorize('update', $assistant);
    return view('user.assistant.config', ['assistant' => $assistant]);
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
