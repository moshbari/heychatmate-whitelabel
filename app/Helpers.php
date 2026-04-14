<?php

use App\Models\Page;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\AutoResponder;

use App\Models\PaymentGateway;
use App\Helpers\AutoResponders;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use League\CommonMark\CommonMarkConverter;

if (!function_exists('get_settings')) {
  function get_settings($key)
  {
    $data = Setting::where('key', $key);
    if ($data->exists()) {

      return $data->first()->value;
    } else {

      return "";
    }
  }
}

if (!function_exists('update_settings')) {
  function update_settings($key, $value)
  {
    $data = Setting::where('key', $key)->first();
    $data->value = $value;
    $data->save();
    return "ok";
  }
}

// ── Tenant-Aware Helper Functions (NEW) ──

if (!function_exists('current_tenant')) {
  /**
   * Get the currently resolved tenant, or null if not in tenant context.
   */
  function current_tenant(): ?Tenant
  {
    return app()->bound('current_tenant') ? app('current_tenant') : null;
  }
}

if (!function_exists('tenant_setting')) {
  /**
   * Get a tenant-specific setting with fallback to global settings.
   * Used in Blade views for branding.
   */
  function tenant_setting(string $key, $default = '')
  {
    $tenant = current_tenant();

    if ($tenant) {
      // Check tenant model attributes first (branding fields)
      $tenantFields = [
        'app_name', 'logo', 'favicon', 'primary_color',
        'secondary_color', 'footer_text', 'login_bg_image',
      ];

      if (in_array($key, $tenantFields) && !empty($tenant->$key)) {
        return $tenant->$key;
      }

      // Then check tenant-scoped settings table
      $setting = Setting::withoutGlobalScope('tenant')
        ->where('tenant_id', $tenant->id)
        ->where('key', $key)
        ->first();

      if ($setting) {
        return $setting->value;
      }
    }

    // Fall back to global settings (tenant_id = null)
    $global = Setting::withoutGlobalScope('tenant')
      ->whereNull('tenant_id')
      ->where('key', $key)
      ->first();

    return $global ? $global->value : $default;
  }
}

if (!function_exists('tenant_asset')) {
  /**
   * Get a tenant asset URL (logo, favicon, etc.) with fallback to global.
   */
  function tenant_asset(string $type): string
  {
    $tenant = current_tenant();

    if ($tenant && !empty($tenant->$type)) {
      return asset('storage/tenants/' . $tenant->id . '/branding/' . $tenant->$type);
    }

    // Fallback to global settings
    $settingKey = 'system_' . $type;
    $value = get_settings($settingKey);

    if ($value) {
      return asset($value);
    }

    return asset('assets/img/default-logo.png');
  }
}

if (!function_exists('is_platform_domain')) {
  /**
   * Check if the current request is on the main platform domain (not a tenant).
   */
  function is_platform_domain(): bool
  {
    return current_tenant() === null;
  }
}

if (!function_exists('markDownContent')) {
  function markDownContent($markdown)
  {
    $converter = new CommonMarkConverter();
    return $converter->convert($markdown);
  }
}

function isValidDomain($domain)
{
  // Remove any leading or trailing whitespace
  $domain = trim($domain);

  // Define the regular expression pattern for domain validation
  $pattern = '/^(?!:\/\/)(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/';

  // Perform the regular expression match
  return preg_match($pattern, $domain) === 1;
}

if (!function_exists('jsonConvert')) {
  function jsonConvert($value)
  {
    $data = json_decode($value, true);
    return $data;
  }
}

function refferDomain($url)
{
  $parsedUrl = parse_url($url);
  $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
  $hostParts = explode('.', $host);

  // Extract domain name
  if (count($hostParts) > 2) {
    $domain = $hostParts[count($hostParts) - 2] . '.' . $hostParts[count($hostParts) - 1];
  } else {
    $domain = $host;
  }

  return $domain; // Outputs: example.com
}

if (!function_exists('allCountries')) {
  function allCountries()
  {
    $data = Country::orderBy('name', 'ASC')->get();
    return $data;
  }
}

function ipDetails($ip)
{
  try {
    //$ip = $_SERVER['REMOTE_ADDR'];
    $url = 'http://ip-api.com/json/' . $ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
  } catch (\Throwable $th) {
    return null;
  }
}


if (!function_exists('systemPages')) {
  function systemPages($type)
  {
    $data = Page::where($type, 1)->orderBy('menu_order', 'ASC')->get();
    return $data;
  }
}


if (!function_exists('str_rand')) {
  function str_rand($length = 12, $up = false)
  {
    if ($up) return Str::random($length);
    else return strtoupper(Str::random($length));
  }
}


if (!function_exists('gatewayID')) {
  function gatewayID($keyword)
  {
    $data = PaymentGateway::where('keyword', $keyword)->first();
    //dd($data);
    return $data->id;
  }
}


if (!function_exists('convertTokens')) {
  function convertTokens($token_used)
  {
    return $token_used * get_settings('token_rate');
  }
}


if (!function_exists('cutBalance')) {
  function cutBalance($user_id, $amount, $assistant)
  {
    $user = User::findOrFail($user_id);
    if ($user->credit_balance < $amount) {
      $user->credit_balance = 0;
    } else {
      $user->credit_balance -= $amount;
    }
    $user->update();

    //dd($deposit_data);

    $trnx              = new Transaction();
    $trnx->trx_id      = str_rand();
    $trnx->user_id     = $user->id;
    $trnx->amount      = $amount;
    $trnx->remark      = 'debit';
    $trnx->type        = '-';
    $trnx->status      = 1;
    $trnx->details     = trans('Used By ' . $assistant);
    $trnx->save();
  }
}

if (!function_exists('responders')) {
  function responders($email, $user_id)
  {
    $resp = AutoResponder::where('user_id', $user_id)->first();

    if ($resp) {
      if ($resp->getresponse_status == 1) {
        # code...
        AutoResponders::setGetResp($email, $user_id);
      }
      if ($resp->sendlane_status == 1) {
        # code...
        AutoResponders::sendlaneCall($email, $user_id);
      }
      if ($resp->systemio_status == 1) {
        # code...
        AutoResponders::systemIoCall($email, $user_id);
      }
    }


  }
}




function randNum($digits = 6)
{
  return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}

function email($data)
{
  if (get_settings('global_email')) {
    if (get_settings('email_type') == 'php') {
      $headers = "From: " . get_settings('name_from') . " <" . get_settings('email_from') . "> \r\n";
      $headers .= "Reply-To: get_settings('name_from') <" . get_settings('email_from') . "> \r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=utf-8\r\n";
      @mail($data['email'], $data['subject'], $data['message'], $headers);
    } else {
      $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();
        $mail->Host       = get_settings('smtp_host');
        $mail->SMTPAuth   = true;
        $mail->Username   = get_settings('smtp_user');
        $mail->Password   = get_settings('smtp_pass');
        if (get_settings('smtp_encryption') == 'ssl') {
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port    = get_settings('smtp_port');
        $mail->CharSet = 'UTF-8';
        $mail->setFrom(get_settings('email_from'), get_settings('name_from'));
        $mail->addAddress($data['email'], $data['name']);
        $mail->addReplyTo(get_settings('email_from'), get_settings('name_from'));
        $mail->isHTML(true);
        $mail->Subject = $data['subject'];
        $mail->Body    = $data['message'];
        $mail->send();
      } catch (Exception $e) {
        throw new Exception($e);
      }
    }
  }
}
function contactEmail($data)
{
  if (get_settings('email_type') == 'php') {
    $headers = "From: " . get_settings('name_from') . " <" . get_settings('email_from') . "> \r\n";
    $headers .= "Reply-To: get_settings('name_from') <" . get_settings('email_from') . "> \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    @mail(get_settings('contact_email'), $data['subject'], $data['message'], $headers);
  } else {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host       = get_settings('smtp_host');
      $mail->SMTPAuth   = true;
      $mail->Username   = get_settings('smtp_user');
      $mail->Password   = get_settings('smtp_pass');
      if (get_settings('smtp_encryption') == 'ssl') {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      }
      $mail->Port    = get_settings('smtp_port');
      $mail->CharSet = 'UTF-8';
      $mail->setFrom(get_settings('email_from'), get_settings('name_from'));
      $mail->addAddress(get_settings('contact_email'), $data['name']);
      $mail->addReplyTo(get_settings('email_from'), get_settings('name_from'));
      $mail->isHTML(true);
      $mail->Subject = $data['subject'];
      $mail->Body    = $data['message'];
      $mail->send();
    } catch (Exception $e) {
      throw new Exception($e);
    }
  }
}
