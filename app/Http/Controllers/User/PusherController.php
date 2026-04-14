<?php

namespace App\Http\Controllers\User;

use App\Models\Chat;
use App\Models\UserConfig;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\AiInstruction;
use App\Events\PusherBroadcast;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class PusherController extends Controller
{
  public function index()
  {
    return view('index');
  }

  public function broadcast(Request $request)
  {
    $chat_id = Chat::find($request->chatid);

    $traina              = new Conversation();
    $traina->role        = 'admin';
    $traina->content     = $request->message;
    $traina->chat_id     = $chat_id->id;
    $traina->save();

    broadcast(new PusherBroadcast($request->get('message'), $chat_id->id, 'admin'))->toOthers();

    //return view('broadcast', ['message' => $request->get('message')]);
    return response()->json(['message' => $request->get('message')], 200);
  }

  public function receive(Request $request)
  {

    //return view('receive', ['message' => $request->get('message')]);

    return response()->json(['message' => $request->get('message')], 200);
  }

  public function broadcasto(Request $request)
  {
    //header('Access-Control-Allow-Origin: *');
    //$chat_id = Chat::where('identifier', $request->session_id)->first();
    $uid = "";
    if ($request->session()->has('ChatSession')) {
      $uid = $request->session()->get('ChatSession');
    } else {
      $uid = $request->uid;
    }

    $chat_id = Chat::where('identifier', $uid)->first();

    // dd($chat_id);

    $traina              = new Conversation();
    $traina->role        = 'user';
    $traina->content     = $request->message;
    $traina->chat_id     = $chat_id->id;
    $traina->save();

    broadcast(new PusherBroadcast($request->get('message'), $chat_id->id, 'user'))->toOthers();

    $prompt_token = mb_strlen($request->message);

    if ($chat_id->ai_reply == 1 && $prompt_token < $chat_id->user->credit_balance) {
      $prompt = $request->message;

      $trainDatas = AiInstruction::where('chat_assistant_id', $chat_id->chat_assistant_id)->where('status', 1)->get();

      $datas = "";
      $olds = "";

      foreach ($trainDatas as $trainData) {
        $datas .= '{"role": "system", "content": "' . str_replace('"', '\'', str_replace(array("\n", "\r", "\t"), '', $trainData->content)) . '"},';
      }


      $ai_model = "gpt-3.5-turbo-16k";
      $api_key = env("OPENAI_API_KEY");

      if ($chat_id->user->subscription->plan->api_type == "user") {
        $config = UserConfig::where('user_id', $chat_id->user_id)->first();
        $ai_model = $config->ai_model;
        $api_key = $config->api_key;
      } else {
        $ai_model = get_settings('system_ai_model');
        $api_key = get_settings('system_api_key');
      }

      // return $ai_model;
      //return view('broadcasto', ['message' => $ai_model, 'status' => 1, 'thumb' => $chat_id->assistant->avatar, 'type_effect' => $chat_id->assistant->type_effect]);
      //return $ai_model;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 60,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
                              "model": "' . $ai_model . '",
                              "messages": [
                                  ' . $datas . '
                                  {"role": "user", "content": "' . $prompt . '"}
                                ]
                          }',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer ' . $api_key,
          'Content-Type: application/json'
        ),
      ));
      $responses = curl_exec($curl);

      //dd($response);
      // return $responses;

      $err = curl_errno($curl);

      //dd($err);

      curl_close($curl);

      //file_put_contents(time().'.txt', $response);
      $response = json_decode($responses, true);



      if (isset($response['choices'][0]['message']['content']) && $err != 28) {

        $resp1 = $response['choices'][0]['message']['content'];

        $resp1 = markDownContent($resp1);

        $resp2 = str_replace("\n", "<br>", $response['choices'][0]['message']['content']);
        //   $resp2 = substr($resp1, 0, 8);
        //   if($resp2 == "<br><br>"){
        //       $resp1 = substr($resp1, 8);
        //   }


        $train              = new Conversation();
        $train->role        = 'assistant';
        $train->content     = $resp1;
        $train->chat_id     = $chat_id->id;
        $train->answer_for  = $traina->id;
        $train->api_response  = json_encode($response['usage']);
        $train->save();


        if ($chat_id->user->subscription->plan->api_type != "user") {
          //Update Balance
          $token_used = $response['usage']['total_tokens'];
          $balance_used = round(convertTokens($token_used));
          cutBalance($chat_id->user_id, $balance_used, $chat_id->assistant->name);
        }

        //sleep(rand(1, 5));

        broadcast(new PusherBroadcast($resp1, $chat_id->id, 'ai'))->toOthers();
        return view('broadcasto', ['message' => $resp1, 'status' => 1, 'thumb' => $chat_id->assistant->avatar, 'type_effect' => $chat_id->assistant->type_effect]);
      } else if (isset($response['error'])) {

        return view('broadcasto', ['message' => "Provide me some time please. I am checking.", 'status' => 1, 'thumb' => $chat_id->assistant->avatar, 'type_effect' => $chat_id->assistant->type_effect]);
      } else if ($err == 28) {

        return view('broadcasto', ['message' => "Give me some moments please. I am checking.", 'status' => 1, 'thumb' => $chat_id->assistant->avatar, 'type_effect' => $chat_id->assistant->type_effect]);
      }
    }

    return view('broadcasto', ['message' => $request->get('message'), 'status' => 0]);
  }

  public function receiveo(Request $request)
  {
    //header('Access-Control-Allow-Origin: *');
    // $chat = Chat::where('identifier', $request->session_id)->first();
    $uid = "";
    if ($request->session()->has('ChatSession')) {
      $uid = $request->session()->get('ChatSession');
    } else {
      $uid = $request->uid;
    }

    $chat = Chat::where('identifier', $uid)->first();
    return view('receiveo', ['message' => $request->get('message'), 'thumb' => $chat->assistant->avatar]);
  }


  public function urlChat(Request $request)
  {
    $userIP = $this->get_client_ip();
    $oldchats = "";
    if (Conversation::where('ip', $userIP)->exists()) {

      $oldchats = Conversation::where('ip', $userIP)->get();
    }
    dd($oldchats);


    return view('public-index', compact('oldchats'));
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
