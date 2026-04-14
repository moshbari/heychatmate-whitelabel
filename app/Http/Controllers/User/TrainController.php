<?php

namespace App\Http\Controllers\User;

use App\Models\TrainData;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\AiInstruction;
use App\Models\ChatAssistant;
use App\Http\Controllers\Controller;

class TrainController extends Controller
{


  public function index($id)
  {
    $assistant  = ChatAssistant::findOrFail($id);
    $this->authorize('update', $assistant);
    $trainDatas = AiInstruction::where('chat_assistant_id', $id)->where('user_id',auth()->user()->id)->orderBy('id','ASC')->get();
    return view('user.train.index', ['trainDatas' => $trainDatas, 'assistant' => $assistant]);
  }


  public function submit(Request $request, $id)
  {

    $request->validate([
      'content' => 'required|max:60000|min:15',
    ]);

    $train                      = new AiInstruction();
    $train->content             = $request->content;
    $train->chat_assistant_id   = $id;
    $train->user_id             = auth()->user()->id;
    $train->character_count     = strlen($request->content);
    $train->save();

    return redirect()->back()->with('success', 'Training Data Added Successfully.');
  }


  public function update(Request $request,$id)
  {

    $request->validate([
      'content' => 'required|max:60000|min:15',
    ]);

    $train                    = AiInstruction::findOrFail($request->train_id);
    $this->authorize('update', $train);
    $train->content           = $request->content;
    $train->chat_assistant_id = $id;
    $train->user_id           = auth()->user()->id;
    $train->character_count   = strlen($request->content);
    $train->save();

    return redirect()->back()->with('success', 'Training Data Updated Successfully.');
  }


  public function delete($id)
  {

    $train = AiInstruction::findOrFail($id);

    $this->authorize('update', $train);
    $train->delete();

    return redirect()->back();
  }




  public function chatSubmit(Request $request)
  {

    $userIP = $this->get_client_ip();

    $prompt = $request->content;

    $trainDatas = AiInstruction::all();

    $datas = "";
    $olds = "";

    foreach ($trainDatas as $trainData) {
      $datas .= '{"role": "system", "content": "' . str_replace('"', '\'', str_replace(array("\n", "\r", "\t"), '', $trainData->content)) . '"},';
    }

    // if(Conversation::where('ip',$userIP)->exists()){

    //   $oldchats = Conversation::where('ip',$userIP)->get();
    //   foreach ($oldchats as $oldchat) {
    //     $datas.= '{"role": "'.$oldchat->role.'", "content": "'.$oldchat->content.'"},';
    //   }
    // }

    // '.$olds.'


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
                            "model": "gpt-3.5-turbo",
                            "messages": [
                                ' . $datas . '
                                {"role": "user", "content": "' . $prompt . '"}
                              ]
                        }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer " . env("OPENAI_API_KEY") . "',
        'Content-Type: application/json'
      ),
    ));
    $response = curl_exec($curl);

    //dd($response);

    $err = curl_errno($curl);

    //dd($err);

    curl_close($curl);

    file_put_contents(time() . '.txt', $response);
    $response = json_decode($response, true);



    if (isset($response['choices'][0]['message']['content']) && $err != 28) {

      $resp1 = str_replace("\n", "<br>", $response['choices'][0]['message']['content']);
      $resp2 = substr($resp1, 0, 8);
      if ($resp2 == "<br><br>") {
        $resp1 = substr($resp1, 8);
      }


      $traina              = new Conversation();
      $traina->role        = 'user';
      $traina->content     = $request->content;
      $traina->ip          = $userIP;
      $traina->save();

      $train              = new Conversation();
      $train->role        = 'assistant';
      $train->content     = $resp1;
      $train->ip          = $userIP;
      $train->answer_for  = $traina->id;
      $train->save();


      return $resp1;
    } else if (isset($response['error'])) {

      return "Error1: " . $response['error']['message'];
    } else if ($err == 28) {

      return "Kindly Give me some moments, I am checking the issue. Curl Timeout!";
    }


    return $request->content;
  }

  //


  public function trainIndex()
  {
    $trainDatas = TrainData::all();
    return view('train.index', ['trainDatas' => $trainDatas]);
  }


  public function trainSubmit(Request $request)
  {

    $train              = new TrainData();
    $train->prompt      = $request->prompt;
    $train->completation = $request->comp;
    $train->save();

    return redirect()->back();
  }

  public function traindelete($id)
  {

    $train = TrainData::findOrFail($id);
    $train->delete();

    return redirect()->back();
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
