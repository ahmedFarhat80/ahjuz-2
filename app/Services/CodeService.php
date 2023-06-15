<?php

namespace App\Services;

use App\Models\UserApiCode;
use Illuminate\Support\Facades\Session;
use MessageBird\Client;
use MessageBird\Common\HttpClient;
use MessageBird\Objects\Message;

class CodeService
{
  public static function sendTo($user, $api = false)
  {
    // $code = generate_code();
    $code = 111;

    if (!$user || !$code) {
      return false;
    }

    // send sms 

    // $MessageBird = new Client(config('services.messagebird.key'));
    // $Message = new Message();
    // $Message->originator = 'Ehjiz';
    // $Message->recipients = array(+972597344722); // country_code($user->phone)
    // $Message->body = "$code is your Ehjiz verification code";

    // $MessageBird->messages->create($Message);

    $api ? UserApiCode::updateOrCreate(['customer_id' => $user->id], ['code' => $code]) : Session::put('login_code', ['user' => $user, 'code' => $code]);

    return $code;
  }

}
