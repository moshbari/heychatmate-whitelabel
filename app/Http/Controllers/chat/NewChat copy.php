<?php

namespace App\Http\Controllers\chat;

use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ChatAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class NewChat extends Controller
{
  public function index()
  {
    $userIP = $this->get_client_ip();
    $oldchats = [];
    if (Conversation::where('ip', $userIP)->exists()) {

      $oldchats = Conversation::where('ip', $userIP)->get();
    }

    //dd($oldchats);

    return view('content.chat.live-chat', compact('oldchats'));
  }

  public function chatIndex()
  {

    $assistants = ChatAssistant::where('user_id', auth()->user()->id)->latest()->get();

    return view('user.chats.index', compact('assistants'));
  }


  public function supportchats($ass_id)
  {
    //$userIP = $this->get_client_ip();

    $assistant = ChatAssistant::findOrFail($ass_id);
    $chats = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('status', 1)->orderBy('id', 'desc')->get();
    $oldchats = [];
    $chatData = [];
    if ($chats->count() > 0) {
      $chatData = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('status', 1)->orderBy('id', 'desc')->first();
      $oldchats = [];
      if (Conversation::where('chat_id', $chatData->id)->exists()) {

        $oldchats = Conversation::where('chat_id', $chatData->id)->get();
      }
    }

    //dd($oldchats);

    return view('content.chat.support-chats', compact('oldchats', 'chats', 'chatData','assistant'));
  }



  public function info(Request $request)
  {

    //return json_encode(['status' => 1, 'url' => route('chat.integrated', ["2" => "2", "chat_id" => "3"])]);
    //dd(json_encode($request->except(['_token'])));
    header('Access-Control-Allow-Origin: *');

    //dd($request->all());

    if ($request->session_id) {

      $chat = new Chat();

      $chat->user_id = $assistant->user_id;
      $chat->chat_assistant_id = $request->chat_assistant_id;
      $chat->identifier = $request->session_id;
      $chat->customer_data = json_encode($request->except(['_token']));

      // $chat->customer_name = $request->name;
      $chat->customer_email = $request->customer_email;
      $chat->status = 1;

      $userIP = $this->get_client_ip();

      $chat->user_ip = $userIP;
      $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
      $chat->reff_site = $request->header('HTTP_REFERRER');
      $chat->save();
      $request->session()->put('ChatSession', $request->session_id);
      $request->session()->put('InfoStatus', 1);

      //responders($request->customer_email, $chat->user_id);

      return json_encode(['status' => 1]);

    }
    return json_encode(['status' => 0]);
  }


  public function chat($id,$ass_id)
  {

    $assistant = ChatAssistant::findOrFail($ass_id);
    $chats = Chat::where('user_id', auth()->user()->id)->where('status', 1)->where('chat_assistant_id', $ass_id)->orderBy('id', 'desc')->get();
    $chatData = Chat::find($id);

    $this->authorize('update', $chatData->assistant);
    $oldchats = [];
    if (Conversation::where('chat_id', $id)->exists()) {

      $oldchats = Conversation::where('chat_id', $id)->get();
    }

    //dd($oldchats);

    return view('content.chat.support-chats', compact('oldchats', 'chats','chatData', 'assistant'));
  }

  public function embedLink(Request $request, $slug)
  {
    //$http_origin = $request->header('host');
    //dd($http_origin);
    $assistant = ChatAssistant::where('slug', $slug)->first();
    if ($assistant) {
      //$computerId = $_SERVER['HTTP_USER_AGENT'].'--'.$_SERVER['REMOTE_PORT'].'--'.$_SERVER['REMOTE_ADDR'];

      //dd($computerId);

      header('Access-Control-Allow-Origin: *');

      //echo $_SERVER['HTTP_USER_AGENT'];
      //dd($request->session()->get('ChatSession'));

      $oldchats = [];
      if ($request->session()->has('ChatSession')) {

        $chat = Chat::where('identifier', $request->session()->get('ChatSession'))->first();


        if ($chat) {

          if (Conversation::where('chat_id', $chat->id)->exists()) {

            $oldchats = Conversation::where('chat_id', $chat->id)->get();
          }

          //dd($oldchats);

          return view('content.chat.embed-chat', compact('oldchats', 'chat', 'assistant'));
        } else {

          $userIP = $this->get_client_ip();

          $uid = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 34);

          $chat = new Chat();
          $chat->user_id = $assistant->user_id;
          $chat->chat_assistant_id = $assistant->id;
          $chat->customer_data = "";
          $chat->identifier = $uid;
          $chat->user_ip = $userIP;
          $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
          $chat->reff_site = $request->header('HTTP_REFERRER');
          $chat->status = 0;
          $chat->save();
          $request->session()->put('ChatSession', $uid);
          $request->session()->put('InfoStatus', 0);

          return view('content.chat.embed-chat', compact('oldchats', 'chat', 'uid', 'assistant'));
        }
      } else {

        $userIP = $this->get_client_ip();

        $uid = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 34);

        $chat = new Chat();
        $chat->user_id = $assistant->user_id;
        $chat->chat_assistant_id = $assistant->id;
        $chat->customer_data = "";
        $chat->identifier = $uid;
        $chat->user_ip = $userIP;
        $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $chat->reff_site = $request->header('HTTP_REFERRER');
        $chat->status = 0;
        $chat->save();
        $request->session()->put('ChatSession', $uid);
        $request->session()->put('InfoStatus', 0);



        return view('content.chat.embed-chat', compact('oldchats', 'chat', 'uid', 'assistant'));
      }
      //dd($oldchats);
    } else {
      abort(403);
    }
  }

  public function widgets()
  {
    return view('content.chat.widgets');
  }


  public function chatButton($slug)
  {
    $assistant = ChatAssistant::where('slug', $slug)->first();
    return view('content.chat.button', ['assistant' => $assistant]);
  }


  public function chatIntegrated(Request $request, $slug)
  {

    //dd($request->all());
    $assistant = ChatAssistant::where('slug', $slug)->first();

    //$http_origin = $request->header('host');
    //dd($http_origin);
    $assistant = ChatAssistant::where('slug', $slug)->first();
    if ($assistant) {
      //$computerId = $_SERVER['HTTP_USER_AGENT'].'--'.$_SERVER['REMOTE_PORT'].'--'.$_SERVER['REMOTE_ADDR'];

      //dd($computerId);

      header('Access-Control-Allow-Origin: *');

      //echo $_SERVER['HTTP_USER_AGENT'];
      //dd($request->session()->get('ChatSession'));

      $oldchats = [];
      if ($request->session_id) {

        $chat = Chat::where('identifier', $request->session_id)->first();

        //dd($chat);


        if ($chat) {

          if (Conversation::where('chat_id', $chat->id)->exists()) {

            $oldchats = Conversation::where('chat_id', $chat->id)->get();
          }

          //dd($oldchats);

          return view('content.chat.integrated', compact('oldchats', 'chat', 'assistant'));
        } else {

          $userIP = $this->get_client_ip();

          $uid = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 34);

          $chat = new Chat();
          $chat->user_id = $assistant->user_id;
          $chat->chat_assistant_id = $assistant->id;
          $chat->customer_data = "";
          $chat->identifier = $uid;
          $chat->user_ip = $userIP;
          $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
          $chat->reff_site = $request->header('HTTP_REFERRER');
          $chat->status = 0;
          $chat->save();
          $request->session()->put('ChatSession', $uid);
          $request->session()->put('InfoStatus', 0);

          return view('content.chat.integrated', compact('oldchats', 'chat', 'uid', 'assistant'));
        }
      } else {

        $userIP = $this->get_client_ip();

        $uid = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 34);

        $chat = new Chat();
        $chat->user_id = $assistant->user_id;
        $chat->chat_assistant_id = $assistant->id;
        $chat->customer_data = "";
        $chat->identifier = $uid;
        $chat->user_ip = $userIP;
        $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $chat->reff_site = $request->header('HTTP_REFERRER');
        $chat->status = 0;
        $chat->save();
        $request->session()->put('ChatSession', $uid);
        $request->session()->put('InfoStatus', 0);



        return view('content.chat.integrated', compact('oldchats', 'chat', 'uid', 'assistant'));
      }
      //dd($oldchats);
    } else {
      abort(403);
    }
  }


  public function embedCode(Request $request, $slug)
  {
    // $http_origin = $_SERVER['HTTP_ORIGIN'];
    // dd($http_origin);
    //header('X-Frame-Options', 'ALLOW-FROM http://localhost');
    header('Access-Control-Allow-Origin: *');
    $assistant = ChatAssistant::where('slug', $slug)->first();

    $contents = View::make('content.chat.code')->with('assistant', $assistant);
    $response = Response::make($contents, 200);
    $response->header('Content-Type', 'application/javascript');
    return $response;


    return view('content.chat.code');
  }


  public function aistatus($id, $status)
  {

    $chat = Chat::where('id', $id)->first();



    if ($chat) {

      $chat->ai_reply = $status;
      $chat->save();
    }
    return redirect()->back()->with('success', 'Chat Reply Status changed successfully.');
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
