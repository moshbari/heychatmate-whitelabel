<?php

namespace App\Helpers;

use Exception;
use App\Models\AutoResponder;

class AutoResponders
{

  public static function setSendioResp($resData, $user_id)
  {
    $setup = AutoResponder::where('user_id', $user_id)->first();

    try {
      $curlSend = curl_init();

      curl_setopt_array($curlSend, array(
        CURLOPT_URL => "https://sendiio.com/api/v1/lists/subscribe/json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"email\":\"" . $resData . "\",\"email_list_id\":" . $setup->sendiio_email_list_id . "}",
        CURLOPT_HTTPHEADER => array(
          "accept: application/json",
          "" . $setup->sendiio_api_token . ": " . $setup->sendiio_api_secret . "",
          "content-type: application/json"
        ),
      ));

      $response = curl_exec($curlSend);
      $err = curl_error($curlSend);

      curl_close($curlSend);
    } catch (\Exception $e) {
    }
  }


  public static function setGetResp($resData, $user_id)
  {
    $setup = AutoResponder::where('user_id', $user_id)->first();

    try {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.getresponse.com/v3/contacts',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
            "name": "John Doe",
            "campaign": {
            "campaignId": "' . $setup->getresponse_campaign_id . '"
            },
            "email": "' . $resData . '"
            }',
        CURLOPT_HTTPHEADER => array(
          'X-Auth-Token: api-key ' . $setup->getresponse_token,
          'Content-Type: application/json'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      echo $response;
    } catch (\Exception $e) {
    }
  }

  public static function sendlaneCall($email, $user_id)
  {
    $setup = AutoResponder::where('user_id', $user_id)->first();
    try {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sendlane.com/api/v1/list-subscriber-add',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('api' => $setup->sendlane_apiKey, 'hash' => $setup->sendlane_apiHash, 'email' => $email, 'list_id' => $setup->list_id),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
    } catch (Exception $e) {
    }
  }

  public static function systemIoCall($email, $user_id)
  {
    $setup = AutoResponder::where('user_id', $user_id)->first();
    try {
      $client = new \GuzzleHttp\Client();

      $client->request('POST', 'https://api.systeme.io/api/contacts', [
        'body' => '{"email":"'.$email.'"}',
        'headers' => [
          'X-API-Key' => $setup->systemio_apikey,
          'accept' => 'application/json',
          'content-type' => 'application/json',
        ],
      ]);

      //$response->getBody();
    } catch (Exception $e) {
    }
  }
}
