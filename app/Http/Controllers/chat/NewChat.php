<?php

namespace App\Http\Controllers\chat;

use Carbon\Carbon;
use Pusher\Pusher;
use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\ChatAssistant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use MatthiasMullie\Minify;

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
    if (request('country')) {
      $cntry = request('country');
      //dd(request('country'));
      $chats = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('ip_details', 'LIKE', "%{$cntry}%")->where('status', 1)->orderBy('id', 'desc')->get();
    } else {

      $chats = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('status', 1)->orderBy('id', 'desc')->get();
    }

    if (request('date')) {
      $date = request('date');
      //dd(request('country'));
      $chats = $chats->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->created_at)->format('Y-m-d');
        if ($itemDate == $date) {

          return $item;
        }
      })->values();
    }

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

    return view('content.chat.support-chats', compact('oldchats', 'chats', 'chatData', 'assistant'));
  }

  //Populate a function which will fetch oldchats using uid



  public function info(Request $request)
  {

    //return json_encode(['status' => 1, 'url' => route('chat.integrated', ["2" => "2", "chat_id" => "3"])]);
    //dd(json_encode($request->except(['_token'])));
    header('Access-Control-Allow-Origin: *');


    if ($request->session()->has('ChatSession')) {

      $chat = Chat::where('identifier', $request->session()->get('ChatSession'))->first();


      if ($chat) {

        $chat->customer_data = json_encode($request->except(['_token']));

        // $chat->customer_name = $request->name;
        $chat->customer_email = $request->customer_email;
        $chat->status = 1;

        $chat->save();

        $request->session()->put('InfoStatus', 1);

        responders($request->customer_email, $chat->user_id);

        return json_encode(['status' => 1]);
      }
    }
    return json_encode(['status' => 0]);
  }

  public function widgetinfo(Request $request)
  {
    if ($request->uid) {

      $chat = Chat::where('identifier', $request->uid)->first();


      if ($chat) {

        $chat->customer_data = json_encode($request->except(['_token']));

        $chat->customer_name = $request->name;
        $chat->customer_email = $request->customer_email;
        $chat->customer_phone = $request->customer_phone;
        $chat->status = 1;

        $chat->save();

        $request->session()->put('InfoStatus', 1);

        responders($request->customer_email, $chat->user_id);

        return json_encode(['status' => 1]);
      }
    }
    return json_encode(['status' => 0]);
  }


  public function createChat(Request $request, $slug)
  {
    $assistant = ChatAssistant::where('slug', $slug)->first();


    //$http_origin = $request->header('host');
    //dd($http_origin);
    if ($assistant) {
      $userIP = $this->get_client_ip();

      $uid = substr(
        base_convert(sha1(uniqid(mt_rand())), 16, 36),
        0,
        34
      );

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

      $data['key_id'] = $uid;
      $data['qq_data'] = $chat->id;

      return response()->json($data, 200);
    } else {

      return response()->json('err', 401);
    }
  }

  public function widgetdCode(Request $request, $slug)
  {

    // $http_origin = $_SERVER['HTTP_ORIGIN'];
    // dd($http_origin);
    //header('X-Frame-Options', 'ALLOW-FROM http://localhost');
    header('Access-Control-Allow-Origin: *');
    $assistant = ChatAssistant::where('slug', $slug)->first();


    //$http_origin = $request->header('host');
    //dd($http_origin);
    if ($assistant) {

      $contents = View::make('content.chat.chatwidget', compact('assistant'))->render();
      $minifier = new Minify\JS();
      $minifier->add($contents);
      $minifiedJs = $minifier->minify();

      // Create the response with the minified CSS
      $response = Response::make($minifiedJs, 200);
      $response->header('Content-Type', 'application/javascript');

      return $response;

      //dd($oldchats);
    } else {
      abort(403);
    }
  }
  public function getOldChats(Request $request)
  {

    $chat = Chat::where('identifier', $request->uid)->first();

    $oldchats = [];
    if ($chat) {
      if (Conversation::where('chat_id', $chat->id)->exists()) {
        $oldchats = Conversation::where('chat_id', $chat->id)->get();
      }
      return view('content.chat.oldchats', compact('oldchats', 'chat'));
    }
  }

  public function widgetStyles($slug)
  {
    header('Access-Control-Allow-Origin: *');
    $assistant = ChatAssistant::where('slug', $slug)->first();

    if ($assistant) {

      $contents = View::make('content.chat.widgetstyles', compact('assistant'))->render();

      // Minify the CSS content
      $minifier = new Minify\CSS();
      $minifier->add($contents);
      $minifiedCss = $minifier->minify();

      // Create the response with the minified CSS
      $response = Response::make($minifiedCss, 200);
      $response->header('Content-Type', 'text/css');

      return $response;

    } else {
      abort(403);
    }
  }

  public function chat($id, $ass_id)
  {

    if (request('country')) {
      $cntry = request('country');
      //dd(request('country'));
      $chats = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('ip_details', 'LIKE', "%{$cntry}%")->where('status', 1)->orderBy('id', 'desc')->get();
    } else {

      $chats = Chat::where('user_id', auth()->user()->id)->where('chat_assistant_id', $ass_id)->where('status', 1)->orderBy('id', 'desc')->get();
    }

    if (request('date')) {
      $date = request('date');
      //dd(request('country'));
      $chats = $chats->filter(function ($item) use ($date) {
        $itemDate = Carbon::parse($item->created_at)->format('Y-m-d');
        if ($itemDate == $date) {

          return $item;
        }
      })->values();
    }

    $assistant = ChatAssistant::findOrFail($ass_id);
    //$chats = Chat::where('user_id', auth()->user()->id)->where('status', 1)->where('chat_assistant_id', $ass_id)->orderBy('id', 'desc')->get();
    $chatData = Chat::find($id);

    $this->authorize('update', $chatData->assistant);
    $oldchats = [];
    if (Conversation::where('chat_id', $id)->exists()) {

      $oldchats = Conversation::where('chat_id', $id)->get();
    }

    //dd($oldchats);

    return view('content.chat.support-chats', compact('oldchats', 'chats', 'chatData', 'assistant'));
  }

  public function embedLink(Request $request, $slug)
  {

    $assistant = ChatAssistant::where('slug', $slug)->first();
    if ($assistant) {

      $oldchats = [];
      if ($request->session()->has('ChatSession')) {

        $chat = Chat::where('identifier', $request->session()->get('ChatSession'))->first();


        if ($chat) {

          if (Conversation::where('chat_id', $chat->id)->exists()) {

            $oldchats = Conversation::where('chat_id', $chat->id)->get();
          }

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
          $chat->ip_details = ipDetails($userIP);
          $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
          $chat->reff_site = $request->heydata ? base64_decode($request->heydata) : "";
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
        $chat->ip_details = ipDetails($userIP);
        $chat->user_agent = $_SERVER['HTTP_USER_AGENT'];
        $chat->reff_site = $request->heydata ? base64_decode($request->heydata) : "";
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
    $hostDomain = refferDomain(request()->domain);
    $assistant = ChatAssistant::where('slug', $slug)->first();
    if ($assistant->allowed_domain != '') {
      if ($assistant->allowed_domain != $hostDomain) {
        return "This Assistant is not allowed in this Domain. Kindly congire your domain from Configurations.";
      }
    }

    return view('content.chat.button', ['assistant' => $assistant, 'hostDomain' => base64_encode($hostDomain)]);
  }


  public function chatIntegrated(Request $request, $slug)
  {
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
      if ($request->session()->has('ChatSession')) {

        $chat = Chat::where('identifier', $request->session()->get('ChatSession'))->first();



        if ($chat) {
          $uid = $request->session()->get('ChatSession');
          if (Conversation::where('chat_id', $chat->id)->exists()) {

            $oldchats = Conversation::where('chat_id', $chat->id)->get();
          }

          //dd($oldchats);

          return view('content.chat.integrated', compact('oldchats', 'chat', 'uid', 'assistant'));
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
