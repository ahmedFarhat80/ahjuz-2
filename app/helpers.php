<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

function img_upload($image, $path, $resize = false) {

  $image_name = $path . hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
  
  $checkPath = Storage::disk('public')->path($path);
  $storage_path = Storage::disk('public')->path($image_name);

  if(!File::exists($checkPath)){
    File::makeDirectory($checkPath, 0775, true);
  }

  if ($resize) {
      Image::make($image)->resize(150,150)->save($storage_path);
  } else {
      Image::make($image)->save($storage_path);
  }

  return $image_name;
}

if (! function_exists('dayDiff')) {
  function dayDiff($starts_at, $ends_at) {
    $starts_at = Carbon::parse($starts_at);
    $ends_at = Carbon::parse($ends_at);
    return $starts_at->diffInDays($ends_at);
  }
}

if (! function_exists('fileIsImg')) {
  function fileIsImg($path)  {
    return in_array(pathinfo($path, PATHINFO_EXTENSION), ['jpeg','png','jpg']);
  }
}

if (! function_exists('checkArrayElementsAreUnique')) {
  function checkArrayElementsAreUnique($array)  {
    return count($array) === count(array_flip($array));
  }
}

if (! function_exists('date_hour_ar')) {
  function date_hour_ar($date) {
    return Carbon::parse($date)->locale('ar')->isoFormat('dddd, Do MMMM YYYY, H:mm');
  }
}

if (! function_exists('date_ar')) {
  function date_ar($date) {
    return Carbon::parse($date)->locale('ar')->isoFormat('dddd, Do MMMM YYYY');
  }
}

if (! function_exists('move_tmp')) {
  function move_tmp($img, $to) {
    rename(Storage::disk('public')->path($img), Storage::disk('public')->path($to . basename($img)));
    return $to . basename($img);
  }
}

if (! function_exists('auth_customer')) {
  function auth_customer() {
      return auth()->guard('customer')->user();
  }
}

if (! function_exists('auth_owner')) {
  function auth_owner() {
      return auth()->guard('owner')->user();
  }
}

if (! function_exists('auth_admin')) {
  function auth_admin() {
      return auth()->guard('admin')->user();
  }
}

if (! function_exists('country_code')) {
  function country_code($v) {
      return '+965' . $v;
  }
}

if (! function_exists('without_country_code')) {
  function without_country_code($v) {
      return substr($v, 4);
  }
}

if (! function_exists('generate_code')) {
  function generate_code($digits = 6) {
      return Faker\Factory::create()->randomNumber($digits, true);
  }
}

if (! function_exists('get_guard')) {
  function get_guard() {
    if(Auth::guard('admin')->check())
        {return "admin";}
    elseif(Auth::guard('owner')->check())
        {return "owner";}
    elseif(Auth::guard()->check())
        {return "customer";}
}}

if (! function_exists('get_segment')) {
  function get_segment($path, $segment = 1)
  {
    return $path ? explode("/", parse_url($path, PHP_URL_PATH))[$segment] : null;  
  }
}

if (! function_exists('toastNotification')) {
  function toastNotification($message, $type = 'success') {

    $notifications = [
        'not_found' => [
            'message'=>"لم يتم العثور على $message",
            'alert-type'=>'error'
        ],
  
        'created' => [
            'message'=>"تم إنشاء $message بنجاح",
            'alert-type'=>'success'
        ],
  
        'updated' => [            
            'message'=>"تم تحديث $message بنجاح",
            'alert-type'=>'success'
        ],
        
        'deleted' => [            
          'message'=>"تم الحذف $message بنجاح",
          'alert-type'=>'success'
        ],
        'success' => [            
            'message'=>"$message",
            'alert-type'=>'success'
        ],
        'error' => [            
            'message'=>"$message",
            'alert-type'=>'error'
        ],
    ];
  
    return $notifications[$type];
  }
}

