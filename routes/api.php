<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1', 'middleware' => 'api'], function () 
{
    
    Route::get('/settings','v1\UserController@settings');
    
    Route::post('/login','v1\UserController@login');
    
    Route::post('/register','v1\UserController@signupSubmit');
    
    Route::post('/send-reset-password-link','v1\UserController@forget_mail');
    
    Route::post('/update-password', 'v1\UserController@updatePassword');
    
    Route::post('/resend-code', 'v1\UserController@resendCode');
    
    Route::get('/email/verify', 'v1\UserController@confirm_email');
    
    Route::get('auth/google', 'v1\UserController@redirectToGoogle');
    
    Route::get('auth/google/callback', 'v1\UserController@handleGoogleCallback');
    
    Route::post('/logout','v1\UserController@logout')->middleware('auth:sanctum');
    
    Route::get('ad-status', 'v1\PaypalController@adStatus');
    
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) 
    {
        return $request->user();
    });
    
    Route::middleware('auth:sanctum')->group(function () 
    {
        Route::get('/recently/view/ads', 'v1\UserController@recentViewAds');
        
        Route::get('/country/city', 'v1\UserController@countryCity');
        
        Route::get('/get/user', 'v1\UserController@getUser');
        
        Route::post('/save/search', 'v1\UserController@saveSearches');
        
        Route::post('/profile/update', 'v1\UserController@profileUpdate');
        
        Route::post('/notification/preferences', 'v1\UserController@notificationPreferences');
        
        Route::get('/save/searches', 'v1\UserController@saveSearch');
        
        Route::get('/save/searches/delete', 'v1\UserController@saveSearchDelete');
        
        Route::get('top-four-category', 'v1\HomeController@topFourCategories');
        
        Route::get('all-category', 'v1\HomeController@allCategory');
        
        Route::get('sub-category', 'v1\HomeController@subCategory');
        
        Route::get('category-ads', 'v1\HomeController@categoryAds');
        
        Route::get('ad-detail', 'v1\HomeController@adDetail');
        
        Route::post('wishlist-add-or-remove', 'v1\HomeController@wishlistAddOrRemove');
        
        Route::post('show-phone-number', 'v1\HomeController@showPhoneNumber');
        
        Route::post('report-ad', 'v1\HomeController@reportAd');
        
        Route::post('send-message', 'v1\HomeController@sendMessage');
        
        Route::get('vendor-detail', 'v1\HomeController@vendorDetail');
        
        Route::get('get-filter-data', 'v1\HomeController@getFilterData');
        
        Route::get('load-sub-category/{id}', 'v1\HomeController@laodSubCategory');
        
        Route::get('load-models/{id}', 'v1\HomeController@loadModels');
        
        Route::get('load-body-type/{id}', 'v1\HomeController@loadBodyTypes');
        
        Route::get('get-saved-ads', 'v1\SaveAdController@index');
        
        Route::get('get-filter-value', 'v1\SaveAdController@getFilterValue');
        
        Route::get('delete-save-ad/{id}', 'v1\SaveAdController@deleteSaveAd');
        
        Route::get('delete-multi-save-ad', 'v1\SaveAdController@deleteMultipleSaveAd');
        
        Route::get('compare-saved-ads', 'v1\SaveAdController@compareSavedAds');
        
        Route::get('load-filter-data-for-ad', 'v1\SaveAdController@loadFilterDataForAd');
        
        Route::get('check-fuel-type', 'v1\SaveAdController@checkFuelType');
        
        Route::get('payment-option', 'v1\SaveAdController@paymentOption');
        
        Route::post('store-ad', 'v1\SaveAdController@storeAd');
        
        Route::get('my-ads', 'v1\SaveAdController@myAds');
        
        Route::post('delete-ad', 'v1\SaveAdController@deleteAd');
        
        Route::get('edit/{id}', 'v1\SaveAdController@edit');
        
        Route::post('sold-ad', 'v1\SaveAdController@deleteAd');
        
        Route::get('change-status', 'v1\SaveAdController@changeAdStatus');
        
        Route::get('boost-ad', 'v1\PaypalController@boostAd');
        
        Route::post('update-ad', 'v1\SaveAdController@updateAd');
        
        Route::post('/img-remove', 'v1\SaveAdController@imagermv');
        
        Route::post('get-ads-after-filter', 'v1\SaveAdController@getAdsAfterFilter');
        
        Route::get('chats', 'v1\ChatController@index');
        
        Route::get('chat/{id}', 'v1\ChatController@show');
        
        Route::get('get-chat-by-ad/{id}', 'v1\ChatController@getChatByAd');
        
        Route::post('/reply/ticket', 'v1\ChatController@ticketreply');
        
        Route::get('chat/delete/{id}', 'v1\ChatController@delete');
        
        Route::get('chat/status/change', 'v1\ChatController@block');
    });
});

