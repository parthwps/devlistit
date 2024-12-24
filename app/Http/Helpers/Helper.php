<?php

use App\Models\Advertisement;
use App\Models\BasicSettings\Basic;
use App\Models\Car;
use App\Models\PrivatePackage;
use App\Models\Car\Brand;
use App\Models\Car\CarContent;
use App\Models\Car\CarModel;
use App\Models\Vendor;
use App\Models\Car\Category;
use App\Models\Conversation;
use App\Models\SupportTicket;
use App\Models\Language;
use Carbon\Carbon;

    if (!function_exists('createSlug'))
    {
      function createSlug($string)
      {
        $slug = preg_replace('/\s+/u', '-', trim($string));
        $slug = str_replace('/', '', $slug);
        $slug = str_replace('?', '', $slug);
        $slug = str_replace(',', '', $slug);

        return mb_strtolower($slug);
      }
    }


    if (!function_exists('api_resource_user'))
    {
      function api_resource_user($user)
      {
          if(!$user)
          {
              return false;
          }

          $user_photo = !empty($user->photo) ? url('assets/admin/img/vendor-photo/').'/'.$user->photo : asset('assets/img/blank-user.jpg');

         return [
                'id' => $user->id,
                'photo' => $user_photo,
                'username' => $user->username,
                'name' => $user->vendor_info->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'balance' => $user->amount,
                'country' => $user->vendor_info->country,
                'city' => $user->vendor_info->city,
                'user_type' => $user->vendor_info->type == 'dealer' ? 'dealer' : 'private',
                'is_trader' => $user->trader == 1 ? 'yes' : 'no',
                'business_name' =>  $user->vendor_info->business_name,
                'business_address' =>  $user->vendor_info->business_address,
                'vat_number' =>  $user->vendor_info->vat_number,
                'is_vat_verified' =>  $user->vendor_info->vatVerified,
                'created_at' => $user->created_at->toDateTimeString(),
                'last_seen' => $user->last_activity,
                'notification_news_offer' =>  $user->notification_news_offer,
                'notification_tips' =>   $user->notification_tips,
                'notification_recommendations' =>   $user->notification_recommendations,
                'notification_saved_ads' =>  $user->notification_saved_ads,
                'notification_saved_search' =>  $user->notification_saved_search,
            ];
      }
    }

    if (!function_exists('calculate_response_time'))
    {
      function calculate_response_time($vendor_id)
      {
            $totl_per = 'N/A';

            $totalSupportTicket = \App\Models\SupportTicket::where('admin_id', $vendor_id)->count();

            if($totalSupportTicket > 0 )
            {
                 $totalSupportTicketWithMessages = \App\Models\SupportTicket::where('admin_id', $vendor_id )
                ->has('messages')
                ->count();
                $responseRate = ($totalSupportTicketWithMessages / $totalSupportTicket) * 100;

                $totl_per =  round($responseRate, 2) . "%";
            }

            return $totl_per;
      }
    }



if (!function_exists('get_vendor_review_from_google'))
{
  function get_vendor_review_from_google($cid , $need_review = false)
  {
          // The CID you want to see the reviews for
        $show_only_if_with_text = false; // true OR false
        $show_only_if_greater_x = 0;     // 0-4
        $show_rule_after_review = false; // true OR false
        $show_blank_star_till_5 = true;  // true OR false
        /* ------------------------------------------------------------------------- */

        $ch = curl_init('https://www.google.com/maps?cid='.$cid);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.8.1.6) Gecko / 20070725 Firefox / 2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        $result = curl_exec($ch);
        curl_close($ch);
        $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';

        $total_ratings = 0;
        $total_reviews = 0;
        $reviews_outout = '';
        $rating_stars = '';
        if ( preg_match($pattern, $result, $match) )
        {
        $match[1] = trim($match[1], ' =;'); // fix json
        $reviews = json_decode($match[1]);

        $reviews = ltrim($reviews[3][6], ")]}'"); // fix json

        $reviews = json_decode($reviews);

        //$customer = $reviews[0][1][0][14][18];
        $total_ratings = $reviews[6][4][7];
        $total_reviews = $reviews[6][4][8];

        $customer = $reviews[6][18]; // NEW IN 2020
        $reviews  = $reviews[6][52][0]; // NEW IN 2020
        }

        if (isset($reviews))
        {
           $user_img = '<img style="    height: 50px;" src="'.asset('/public/comment_user.png').'" />';
            foreach ($reviews as $review)
            {
                 $reviews_outout .= '<small>'.$user_img.'<b style="margin-left: 8px;">'.$review[0][1].'</b><span style="font-size: 30px;color: gray;"> . </span>' ; // AUTHOR
                if ($show_only_if_with_text == true and empty($review[3])) continue;
                if ($review[4] <= $show_only_if_greater_x) continue;
                for ($i=1; $i <= $review[4]; ++$i)  $reviews_outout .= '⭐'; // RATING
                if ($show_blank_star_till_5 == true)
                for ($i=1; $i <= 5-$review[4]; ++$i)  $reviews_outout .= '☆'; // RATING
                 $reviews_outout .= '<span style="font-size: 30px;color: gray;"> . </span>'. $review[1] .'<span style="margin-top: 10px;display: block;">'.$review[3].'</span> </small><br>'; // TEXT


                if ($show_rule_after_review == true)  $reviews_outout .= '<hr size="1">';
            }

        }

        if($total_ratings > 0 && $total_reviews > 0)
        {

                     // Output filled stars for the integer part of the rating
            for ($i = 1; $i <= floor($total_ratings); $i++) {
                $rating_stars .= '<span class="star on"></span>';
            }

            // Output a half-filled star if the decimal part is greater than 0
            if (($total_ratings - floor($total_ratings)) > 0) {
                 $rating_stars .=  '<span class="star half"></span>';
            }

            // Output unfilled stars for the remaining space up to 5
            for ($i = ceil($total_ratings); $i < 5; $i++) {
                 $rating_stars .=  '<span class="star"></span>';
            }


            if($need_review == true)
            {
              return ['total_reviews' => $total_reviews , 'total_ratings' => $total_ratings , 'rating_stars' => $rating_stars , 'reviews_outout' => $reviews_outout];
            }

            return ['total_reviews' => $total_reviews , 'total_ratings' => $total_ratings ,  'rating_stars' => $rating_stars];
        }

         return ['total_reviews' => $total_reviews , 'total_ratings' => $total_ratings];
  }
}


// if (!function_exists('youtube_embed_link'))
// {
//     function youtube_embed_link($youtube_url)
//     {
//         // Parse the URL to get query parameters
//         $url_data = parse_url($youtube_url);

//         // Get the query string from URL
//         parse_str($url_data['query'], $query_params);

//         // Extract the video ID
//         $video_id = $query_params['v'];

//         // Construct the embed URL
//         return "https://www.youtube.com/embed/" . $video_id;

//     }
// }
if (!function_exists('youtube_embed_link')) {
  function youtube_embed_link($youtube_url) {
      // Parse the URL to get query parameters
      $url_data = parse_url($youtube_url);

      // Check if 'query' key exists in the parsed URL
      if (isset($url_data['query'])) {
          // Get the query string from URL
          parse_str($url_data['query'], $query_params);

          // Check if 'v' parameter exists
          if (isset($query_params['v'])) {
              // Extract the video ID
              $video_id = $query_params['v'];

              // Construct the embed URL
              return "https://www.youtube.com/embed/" . $video_id;
          }
      }

      // Handle other YouTube URL formats (e.g., https://youtu.be/video_id)
      if (isset($url_data['path'])) {
          $video_id = ltrim($url_data['path'], '/');
          return "https://www.youtube.com/embed/" . $video_id;
      }

      // Return null or handle invalid URLs
      return null;
  }
}


if (!function_exists('addUserName'))
{
    function addUserName($user_id , $admin_id)
    {
        if(Auth::guard('vendor')->check())
        {
           $current_user = Auth::guard('vendor')->user()->id;
        }
        else
        {
            $current_user = request()->user()->id;
        }

        if($current_user == $user_id)
        {
           $vendor = Vendor::find($admin_id);
        }
        else
        {
            $vendor = Vendor::find($user_id);
        }

        return [$vendor->vendor_info->name , $vendor->id];
    }
}



if (!function_exists('isOnline'))
{
    function isOnline($user_id)
    {
         $vendor= Vendor::find($user_id);

         $checkStatus =  $vendor->last_activity !== null && $vendor->last_activity > now()->subMinutes(2);

         return [$checkStatus , date('d F y h:i a' , strtotime($vendor->last_activity))];
    }
}


if (!function_exists('roundEngineDisplacement'))
{
    function roundEngineDisplacement($car)
{
    $cc = $car->engineCapacity;
    // dd($car->car_content);
    if(isset($car->car_content->fuel_type->name ) && ($car->car_content->fuel_type->name == 'Diesel' || $car->car_content->fuel_type->name == 'Petrol') && ($car->car_content->category_id != '48' && $car->car_content->category_id != '62'))
    {
       $unit = ' L';
    }
    elseif($car->car_content->category_id == '48' || $car->car_content->category_id == '62')
    {
        return $cc.' cc';
    }
    else
    {
       return  $cc.' Kw';
    }

    // Validate the input to ensure it is a number and does not contain alphabetic characters
    if (!is_numeric($cc) || preg_match('/[a-zA-Z]/', $cc))
    {
        return $cc;
    }

    // If the input is already in a point value format (e.g., 2.0 or 3.7), return it as is with 'L'
    if (strpos($cc, '.') !== false && preg_match('/^\d+\.\d$/', $cc)) {
        return $cc . $unit;
    }

    if($cc > 10)
    {
        // Convert cc to liters
        $liters = $cc / 1000;

        // Round to one decimal place
        $roundedLiters = round($liters, 1);
    }
    else
    {
        $roundedLiters = $cc;
    }

    return $roundedLiters . $unit;
}

}

if (!function_exists('calulcateloanamount'))
{
  function calulcateloanamount($price)
  {

        $interest_rate = 4.9 / 100; // Convert percentage to decimal

        if ($price > 10000)
        {
         $duration_years = 5;
        }
        elseif ($price >= 5000 && $price <= 10000)
        {
          $duration_years = 3;
        }
        else
        {
          $duration_years = 1;
        }

        // Convert years to months
        $duration_months = $duration_years * 12;

        // Calculate monthly payment
        $monthly_interest_rate = $interest_rate / 12;
        $monthly_payment = ($price * $monthly_interest_rate) / (1 - pow(1 + $monthly_interest_rate, -$duration_months));
        $weekly_payment = $monthly_payment / 4;


        if($price < 5000)
        {
            $singleVal =round($weekly_payment). ' per week';
             $netpay = (round($weekly_payment* 4) * $duration_months) - $price;
            $val = round($weekly_payment). '<span style="font-size: 11px;    display: block;" class="us_loan"> p/w </span>';
        }
        else
        {
            $singleVal =round($monthly_payment). ' per month';
            $netpay = (round($monthly_payment) * $duration_months) - $price;
           $val =  round($monthly_payment) . '<span style="font-size: 11px;display: block;" class="us_loan" > p/m </span>';
        }

        $text = "This calculation is provided as a
        guideline only. The information on the
        quotation is indicative and does not
        constitute a loan offer. APR stands for
        Annual Percentage Rate. Rate offered
        depends on loan amount and may
        differ from advertised rate. Lending
        criteria, terms and conditions apply.
        Over 18s only and not suitable for
        students. <p style='margin-top: 15px;'> The repayments on a personal loan of
        £$price over $duration_years years with $duration_months monthly
        instalments are £$singleVal at
        4.9% variable (Annual Percentage Rate
        of Charge (APRC) 4.9%). The total
        cost of credit is £$netpay. Variable rates
        are correct as at 30th June 2020 and
        are subject to change. </p>";

        return [ $val , $text ];

  }
}

if (!function_exists('getSetVal'))
{
  function getSetVal($key)
  {
    $basic = Basic::where('uniqid', 12345)->select($key)->first();

    return $basic->$key;
  }
}

if (!function_exists('calculate_datetime')) {
  function calculate_datetime($date)
  {
    $created_at = new DateTime($date);
    $now = new DateTime();

    $interval = $created_at->diff($now);

    if ($interval->days == 0)
    {
        if ($interval->h == 0)
        {
            if($interval->i == 0 || $interval->i == 1)
            {
              $time_diff = $interval->i . ' min';
            }
            else
            {
              $time_diff = $interval->i . ' mins';
            }

        }
        else
        {
            if($interval->h == 0 || $interval->h == 1)
            {
                $time_diff = $interval->h . ' hour ';
            }
            else
            {
             $time_diff = $interval->h . ' hours ';
            }
        }
    }
    elseif ($interval->days == 1)
    {
        $time_diff = '1 day';
    }
    else
    {
        $time_diff = $interval->days . ' days';
    }

    return $time_diff;
  }
}


if (!function_exists('make_input_name')) {
  function make_input_name($string)
  {
    return preg_replace('/\s+/u', '_', trim($string));
  }
}

if (!function_exists('replaceBaseUrl')) {
  function replaceBaseUrl($html, $type)
  {
    $startDelimiter = 'src=""';
    if ($type == 'summernote') {
      $endDelimiter = '/assets/img/summernote';
    } elseif ($type == 'pagebuilder') {
      $endDelimiter = '/assets/img';
    }

    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;

    while (false !== ($contentStart = strpos($html, $startDelimiter, $startFrom))) {
      $contentStart += $startDelimiterLength;
      $contentEnd = strpos($html, $endDelimiter, $contentStart);

      if (false === $contentEnd) {
        break;
      }

      $html = substr_replace($html, url('/'), $contentStart, $contentEnd - $contentStart);
      $startFrom = $contentEnd + $endDelimiterLength;
    }

    return $html;
  }
}

if (!function_exists('setEnvironmentValue')) {
  function setEnvironmentValue(array $values)
  {
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if (count($values) > 0) {
      foreach ($values as $envKey => $envValue) {
        $str .= "\n"; // In case the searched variable is in the last line without \n
        $keyPosition = strpos($str, "{$envKey}=");
        $endOfLinePosition = strpos($str, "\n", $keyPosition);
        $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

        // If key does not exist, add it
        if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
          $str .= "{$envKey}={$envValue}\n";
        } else {
          $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
        }
      }
    }

    $str = substr($str, 0, -1);

    if (!file_put_contents($envFile, $str)) return false;

    return true;
  }
}

if (!function_exists('showAd')) {
  function showAd($resolutionType)
  {
    $ad = Advertisement::where('resolution_type', $resolutionType)->inRandomOrder()->first();
    $adsenseInfo = Basic::query()->select('google_adsense_publisher_id')->first();

    if (!is_null($ad)) {
      if ($resolutionType == 1) {
        $maxWidth = '300px';
        $maxHeight = '250px';
      } else if ($resolutionType == 2) {
        $maxWidth = '300px';
        $maxHeight = '600px';
      } else {
        $maxWidth = '728px';
        $maxHeight = '90px';
      }

        $expireAt = Carbon::parse($ad->expire_at);

        // Check if the current date is not past the expire date
        if ($ad->ad_type == 'banner' && $expireAt->gte(Carbon::now()))
      {
    $now = Carbon::now();



    $markUp = '<a href="' . url($ad->url) . '" target="_blank" onclick="adView(' . $ad->id . ')" class="ad-banner">
    <img data-src="' . asset('assets/img/advertisements/' . $ad->image) . '" alt="advertisement"  class="lazyload blur-up">
    </a>';



        return $markUp;
      }
      else
      {
        $markUp = '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . $adsenseInfo->google_adsense_publisher_id . '" crossorigin="anonymous"></script>
        <ins class="adsbygoogle" style="display: block;" data-ad-client="' . $adsenseInfo->google_adsense_publisher_id . '" data-ad-slot="' . $ad->slot . '" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
        </script>';

        return $markUp;
      }
    } else {
      return;
    }
  }
}

if (!function_exists('onlyDigitalItemsInCart')) {
  function onlyDigitalItemsInCart()
  {
    $cart = session()->get('productCart');
    if (!empty($cart)) {
      foreach ($cart as $key => $cartItem) {
        if ($cartItem['type'] != 'digital') {
          return false;
        }
      }
    }
    return true;
  }
}

if (!function_exists('onlyDigitalItems')) {
  function onlyDigitalItems($order)
  {

    $oitems = $order->orderitems;
    foreach ($oitems as $key => $oitem) {

      if ($oitem->item->type != 'digital') {
        return false;
      }
    }

    return true;
  }
}

if (!function_exists('get_href')) {
  function get_href($data)
  {
    $link_href = '';

    if ($data->type == 'home') {
      $link_href = route('index');
    } else if ($data->type == 'cars') {
      $link_href = route('frontend.cars');
    } else if ($data->type == 'cars list') {
      $link_href = route('frontend.car.view', ['type' => 'list']);
    } else if ($data->type == 'cars grid') {
      $link_href = route('frontend.car.view', ['type' => 'grid']);
    } else if ($data->type == 'vendors') {
      $link_href = route('frontend.vendors');
    } else if ($data->type == 'shop') {
      $link_href = route('shop.products');
    } else if ($data->type == 'cart') {
      $link_href = route('shop.cart');
    } else if ($data->type == 'checkout') {
      $link_href = route('shop.checkout');
    } else if ($data->type == 'blog') {
      $link_href = route('blog');
    } else if ($data->type == 'faq') {
      $link_href = route('faq');
    } else if ($data->type == 'contact') {
      $link_href = route('contact');
    } else if ($data->type == 'about-us') {
      $link_href = route('about_us');
    } else if ($data->type == 'custom') {
      /**
       * this menu has created using menu-builder from the admin panel.
       * this menu will be used as drop-down or to link any outside url to this system.
       */
      if ($data->href == '') {
        $link_href = '#';
      } else {
        $link_href = $data->href;
      }
    } else {
      // this menu is for the custom page which has been created from the admin panel.
      $link_href = route('dynamic_page', ['slug' => $data->type]);
    }

    return $link_href;
  }
}

if (!function_exists('format_price')) {
  function format_price($value): string
  {
    if (session()->has('lang')) {
      $currentLang = Language::where('code', session()
        ->get('lang'))
        ->first();
    } else {
      $currentLang = Language::where('is_default', 1)
        ->first();
    }
    $bs = Basic::first();
    if ($bs->base_currency_symbol_position == 'left') {
      return $bs->base_currency_symbol . $value;
    } else {
      return $value . $bs->base_currency_symbol;
    }
  }
}

if (!function_exists('symbolPrice')) {
  function symbolPrice($price)
  {
    $basic = Basic::where('uniqid', 12345)->select('base_currency_symbol_position', 'base_currency_symbol')->first();
    if ($basic->base_currency_symbol_position == 'left') {
      $data = $basic->base_currency_symbol . round($price, 2);
      return str_replace(' ', '', $data);
    } elseif ($basic->base_currency_symbol_position == 'right') {
      $data = round($price, 2) . $basic->base_currency_symbol;
      return str_replace(' ', '', $data);
    }
  }
}
if (!function_exists('checkWishList')) {
  function checkWishList($car_id, $user_id)
  {

    $check = App\Models\Car\Wishlist::where('car_id', $car_id)
      ->where('user_id', $user_id)
      ->first();
    if ($check) {
      return 1;
    } else {
      return 0;
    }
  }
}

if (!function_exists('vendorTotalAddedCar')) {
  function vendorTotalAddedCar()
  {
    $vendor_id = Auth::guard('vendor')->user()->id;
    $total = Car::where('vendor_id', $vendor_id)->get()->count();
    return $total;
  }
}
if (!function_exists('vendorTotalFeaturedCar')) {
  function vendorTotalFeaturedCar()
  {
    $vendor_id = Auth::guard('vendor')->user()->id;
    $total = Car::where([
      ['vendor_id', $vendor_id],
      ['is_featured', 1],
    ])->get()->count();
    return $total;
  }
}

if (!function_exists('vendorTotalFeaturedCarHome')) {
  function vendorTotalFeaturedCarHome($vendor_id)
  {
    $total = Car::where([
      ['vendor_id', $vendor_id],
      ['is_featured', 1],
    ])->get()->count();
    return $total;
  }
}


if (!function_exists('StoreTransaction')) {
  function StoreTransaction($data)
  {
    App\Models\Transcation::create($data);
  }
}

if (!function_exists('carModel')) {
  function carModel($id)
  {
    $model  = CarModel::where('id', $id)->where('status', 1)->first();
    return  $model ? $model->name : '';
  }
}
if (!function_exists('carBrand')) {
  function carBrand($id)
  {
    $brand  = Brand::where('id', $id)->first();
    return  $brand ? $brand->name : '';
  }
}
if (!function_exists('catslug')) {
  function catslug($id)
  {

    $catname  = Category::where('id', $id)->first();
    $findincar = CarContent::where('category_id', $id)->first();

    $in['category_slug'] =  createSlug($catname->name);
    //exit;
    //print_r($in); exit;
       $findincar->update($in);

    return  createSlug($catname->name);
  }
}

if (!function_exists('contactNotification'))
{
  function contactNotification($id)
  {
    $messages = Conversation::with(['support_ticket'])
    ->where([
        ['message_to', $id],
        ['message_seen', 0]
    ])
    ->whereHas('support_ticket', function ($query) {
        $query->whereColumn('user_id', '!=', 'admin_id');
    })
    ->get();

    return  count($messages);
  }
}

if (!function_exists('countAds')) {
  function countAds($vendor_id,$status = "")
  {

    if($status == "")
    {
      $count = Car::where('vendor_id', $vendor_id)->count();
      }
      else
      {
      $count = Car::where('status', $status);

      if($status == 1)
      {
         $count = $count->where('is_sold', 0);
      }


      $count = $count->where('vendor_id', $vendor_id)->count();
    }

    return  $count;
  }
}
if (!function_exists('countSaveAds')) {
  function countSaveAds($vendor_id,$status = "")
  {

   $category_id = !empty($_GET['category_id']) ? $_GET['category_id'] : '';

    if($status == "")
    {
      $count = Car::join('wishlists', 'cars.id', '=', 'wishlists.car_id')->where('wishlists.user_id', '=', $vendor_id);

        if (!empty($category_id))
        {
            $count->whereHas('car_content', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
            });
        }

      $count = $count->select('cars.*')->get();
      }
      else
      {
        $vendor_id =  Auth::guard('vendor')->user()->id;

        $count = Car::join('wishlists', 'cars.id', '=', 'wishlists.car_id');

        if($status == 1)
        {
            $count = $count->where('cars.status', $status)->where('cars.is_sold', 0);
        }

        if(!empty($vendor_id))
        {
           $count = $count->where('wishlists.user_id', $vendor_id);
        }
        else
        {
          $count = $count->where('wishlists.user_id', 1);
        }


        if (!empty($category_id))
        {
            $count->whereHas('car_content', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
            });
        }


        $count = $count->select('cars.*')->get();
    }

    return  count($count);
  }
}



if (!function_exists('noDaysLeftByAd'))
{
  function noDaysLeftByAd($id,$created_at)
  {

      if($id == 0)
      {
        return 'Listed';
      }

    $adPackage = PrivatePackage::where('id', $id)->first();

    $createdAt = Carbon::parse($created_at);
    $currentDate = Carbon::now();
    $adDuration = $adPackage->days_listing;

    $daysSincePosted  = $createdAt->diffInDays($currentDate);

    $daysLeft = $adDuration - $daysSincePosted;

      if($daysLeft < 1)
      {
        return 'Expired';
      }
      elseif($daysLeft > 1)
      {
        return 'Listed ('. $daysLeft.' days left)';
      }
      elseif($daysLeft == 1)
      {
        return 'Listed ('. $daysLeft.' day left)';
      }
  }
}