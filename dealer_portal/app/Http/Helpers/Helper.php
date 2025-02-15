<?php

use App\Models\Advertisement;
use App\Models\BasicSettings\Basic;
use App\Models\Car;
use App\Models\Car\Brand;
use App\Models\Car\CarModel;
use App\Models\Car\Category;
use App\Models\Car\CarContent;
use App\Models\Language;
use App\Models\Conversation;
use App\Models\PrivatePackage;
use Carbon\Carbon;
// use DateTime;

if (!function_exists('createSlug')) {
  function createSlug($string)
  {
    $slug = preg_replace('/\s+/u', '-', trim($string));
    $slug = str_replace('/', '', $slug);
    $slug = str_replace('?', '', $slug);
    $slug = str_replace(',', '', $slug);

    return mb_strtolower($slug);
  }
}
if (!function_exists('contactNotification')) {
  function contactNotification($id)
  {

    $messages  = Conversation::where([['message_to', $id],['message_seen', 0]])->get();

    return  count($messages);
  }
}

if (!function_exists('calculate_datetime')) {
  function calculate_datetime($date)
  {
    $created_at = new DateTime($date);
    $now = new DateTime();

    $interval = $created_at->diff($now);

    if ($interval->days == 0) {
    if ($interval->h == 0) {
        $time_diff = $interval->i . ' min';
    } else {
        $time_diff = $interval->h . ' hrs ';
    }
    } elseif ($interval->days == 1) {
    $time_diff = 'Yesterday';
    } else {
    $time_diff = $interval->days . ' dys';
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



if (!function_exists('countAds')) {
  function countAds($vendor_id,$status = "")
  {

    if($status == ""){
      $count = Car::where('vendor_id', $vendor_id)->count();
      } else{
      $count = Car::where('status', $status)->where('vendor_id', $vendor_id)->count();
    }

    return  $count;
  }
}
if (!function_exists('countSaveAds')) {
  function countSaveAds($vendor_id,$status = "")
  {

    if($status == ""){
      $count = Car::join('wishlists', 'cars.id', '=', 'wishlists.car_id')->where('wishlists.user_id', '=', $vendor_id)
      ->select('cars.*')->get();
      } else{
      $count = Car::join('wishlists', 'cars.id', '=', 'wishlists.car_id')->where('cars.status', $status)
      ->where('wishlists.user_id', '=', $vendor_id)->select('cars.*')->get();

    }

    return  count($count);
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
if (!function_exists('noDaysLeftByAd')) {
  function noDaysLeftByAd($id,$created_at)
  {
    $adPackage = PrivatePackage::where('id', $id)->first();
    $createdAt = Carbon::parse($created_at);
    $currentDate = Carbon::now();

    $adDuration = $adPackage->days_listing; // Duration of the ad in days

    // Calculate the number of days since the ad was posted
    $daysSincePosted  = $createdAt->diffInDays($currentDate);
    // Calculate the number of days left for the ad to be live
    $daysLeft = $adDuration - $daysSincePosted;
      if($daysLeft < 1){
        return 'Expired';
      }elseif($daysLeft > 1){

        return 'Listed ('. $daysLeft.' days left)';
      }
      elseif($daysLeft == 1){

        return 'Listed ('. $daysLeft.' day left)';
      }

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

      if ($ad->ad_type == 'banner') {
        $markUp = '<a href="' . url($ad->url) . '" target="_blank" onclick="adView(' . $ad->id . ')" class="ad-banner">
          <img data-src="' . asset('assets/img/advertisements/' . $ad->image) . '" alt="advertisement" style="width: ' . $maxWidth . '; height: ' . $maxHeight . ';" class="lazyload blur-up">
        </a>';

        return $markUp;
      } else {
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

if (!function_exists('getSetVal'))
{
  function getSetVal($key)
  {
    $basic = Basic::where('uniqid', 12345)->select($key)->first();

    return $basic->$key;
  }
}

if (!function_exists('checkWishList')) {
  function checkWishList($car_id, $user_id)
  {
    $check = App\Models\Car\Wishlist::where('car_id', $car_id)
      ->where('user_id', $user_id)
      ->first();
    if ($check) {
      return true;
    } else {
      return false;
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