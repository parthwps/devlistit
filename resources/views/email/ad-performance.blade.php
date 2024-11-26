<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

    <link href="https://fonts.googleapis.com/css?family=Work+Sans:200,300,400,500,600,700" rel="stylesheet">

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}

/* What it does: Stops email clients resizing small text. */
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

/* What it does: Centers email on Android 4.4 */
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}

/* What it does: Stops Outlook from adding extra spacing to tables. */
table,
td {
    mso-table-lspace: 0pt !important;
    mso-table-rspace: 0pt !important;
}

/* What it does: Fixes webkit padding issue. */
table {
    border-spacing: 0 !important;
    border-collapse: collapse !important;
    table-layout: fixed !important;
    margin: 0 auto !important;
}

/* What it does: Uses a better rendering method when resizing images in IE. */
img {
    -ms-interpolation-mode:bicubic;
}

/* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
a {
    text-decoration: none;
}

/* What it does: A work-around for email clients meddling in triggered links. */
*[x-apple-data-detectors],  /* iOS */
.unstyle-auto-detected-links *,
.aBn {
    border-bottom: 0 !important;
    cursor: default !important;
    color: inherit !important;
    text-decoration: none !important;
    font-size: inherit !important;
    font-family: inherit !important;
    font-weight: inherit !important;
    line-height: inherit !important;
}

/* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
.a6S {
    display: none !important;
    opacity: 0.01 !important;
}

/* What it does: Prevents Gmail from changing the text color in conversation threads. */
.im {
    color: inherit !important;
}

/* If the above doesn't work, add a .g-img class to any image in question. */
img.g-img + div {
    display: none !important;
}

/* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
/* Create one of these media queries for each additional viewport size you'd like to fix */

/* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
@media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
    u ~ div .email-container {
        min-width: 320px !important;
    }
}
/* iPhone 6, 6S, 7, 8, and X */
@media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
    u ~ div .email-container {
        min-width: 375px !important;
    }
}
/* iPhone 6+, 7+, and 8+ */
@media only screen and (min-device-width: 414px) {
    u ~ div .email-container {
        min-width: 414px !important;
    }
}
    </style>

    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

	    .primary{
	background: #17bebb;
}
.bg_white{
	background: #ffffff;
}
.bg_grey{
	background: #f1f1f1;
}
.bg_light{
	background: #f7fafa;
}
.bg_black{
	background: #000000;
}
.bg_dark{
	background: rgba(0,0,0,.8);
}
.email-section{
	padding:2.5em;
}

/*BUTTON*/
.btn{
	padding: 10px 15px;
	display: inline-block;
}
.btn.btn-primary{
	border-radius: 5px;
	background: #17bebb;
	color: #ffffff;
}
.btn.btn-white{
	border-radius: 5px;
	background: #ffffff;
	color: #000000;
}
.btn.btn-white-outline{
	border-radius: 5px;
	background: transparent;
	border: 1px solid #fff;
	color: #fff;
}
.btn.btn-black-outline{
	border-radius: 0px;
	background: transparent;
	border: 2px solid #000;
	color: #000;
	font-weight: 700;
}
.btn-custom{
	color: rgba(0,0,0,.3);
	text-decoration: underline;
}

h1,h2,h3,h4,h5,h6{
	font-family: 'Work Sans', sans-serif;
	color: #000000;
	margin-top: 0;
	font-weight: 400;
}

body{
	font-family: 'Work Sans', sans-serif;
	font-weight: 400;
	font-size: 15px;
	line-height: 1.8;
	color: rgba(0,0,0,.4);
}

a{
	color: #17bebb;
}

table{
}
/*LOGO*/

.logo h1{
	margin: 0;
}
.logo h1 a{
	color: #17bebb;
	font-size: 24px;
	font-weight: 700;
	font-family: 'Work Sans', sans-serif;
}

/*HERO*/
.hero{
	position: relative;
	z-index: 0;
}

.hero .text{
	color: rgba(0,0,0,.3);
}
.hero .text h2{
	color: #000;
	font-size: 22px;
	margin-bottom: 15px;
	font-weight: 600;
	line-height: 1.2;
}
.hero .text h3{
	font-size: 16px;
	font-weight: 500;
}
.hero .text h2 span{
	font-weight: 600;
	color: #000;
}


/*PRODUCT*/
.product-entry{
	display: block;
	position: relative;
	float: left;
	padding-top: 20px;
}
.product-entry .text{
	width: calc(100% - 125px);
	padding-left: 20px;
}
.product-entry .text h3{
	margin-bottom: 0;
	padding-bottom: 0;
}
.product-entry .text p{
	margin-top: 0;
}
.product-entry img, .product-entry .text{
	float: left;
}

ul.social{
	padding: 0;
}
ul.social li{
	display: inline-block;
	margin-right: 10px;
}

/*FOOTER*/

.footer{
	border-top: 1px solid rgba(0,0,0,.05);
	color: rgba(0,0,0,.5);
}
.footer .heading{
	color: #000;
	font-size: 20px;
}
.footer ul{
	margin: 0;
	padding: 0;
}
.footer ul li{
	list-style: none;
	margin-bottom: 10px;
}
.footer ul li a{
	color: rgba(0,0,0,1);
}


@media screen and (max-width: 500px) {


}


    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;">
	<center style="width: 100%; background-color: #f1f1f1;">
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
    </div>
    <div style="max-width: 800px; margin: 0 auto; padding: 1rem;" class="email-container">
    	<!-- BEGIN BODY -->
      <table align="center" class="bg_white" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
      <tr style="border-bottom: 3px solid rgba(0,0,0,.05);">
          <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
              	<table role="presentation"  border="0" cellpadding="0" cellspacing="0" width="100%">
              		<tr>
                        <td class="logo" style="text-align: left;">
                            <a href="https://listit.im" title="logo" target="_blank">
                                <img width="170" src="https://listit.im/assets/img/653158b8b36c4.png?v=0.1" title="logo" alt="logo">
                            </a> 
                        </td>
              		</tr>
              	</table>
          </td>
	      </tr><!-- end tr -->
				<tr>
          <td valign="middle" class="hero bg_white" style="padding: 2em 0 .7em 0;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" >
            	<tr>
            		<td style="padding: 0 2.5em; text-align: left;">
            			<div class="text">
            				<h2><center>Your Ads Performance</center></h2>
            				<h3 style="margin-bottom: 0px;text-align: center;">A cumulative  break down  of your ad performance.</h3>
            			</div>
            		</td>
            	</tr>
            </table>
          </td>
	      </tr>
	      <tr> 
	      <td style="padding: 20px 24px">
	          
	       @foreach ($cars as $car)
           
            <table class="table" id="">
            <thead class="table_header_small">
            <tr>
                <th scope="col" style="text-align: left;">{{ __('Image') }}</th>						
                <th scope="col" style="text-align: left;" colspan="2">{{ __('Title') }}</th>
                <th scope="col" style="text-align: left;">{{ __('Price') }}</th>
                <th scope="col" style="text-align: left;">{{ __('Brand') }}</th>
                <th scope="col" style="text-align: left;">{{ __('Model') }}</th>
                
            </tr>
            </thead>
            <tbody>
            
            <tr>
              <td>
                @php 
                 $image_path = $car->feature_image;
                        
                        $rotation = 0;
                        
                        if($car->rotation_point > 0 )
                        {
                            $rotation =    $car->rotation_point;
                        }
                        
                        if(!empty($image_path) && $car->rotation_point == 0 )
                        {   
                            $rotation = $car->galleries->where('image' , $image_path)->first();
                        
                            if($rotation == true)
                            {
                                $rotation = $rotation->rotation_point;  
                            }
                            else
                            {
                                $rotation = 0;   
                            }
                        }
                        
                        if(empty($car->feature_image))
                        {
                            $image_path = $car->galleries[0]->image;
                            $rotation = $car->galleries[0]->rotation_point;
                        }
                @endphp
               <img src="{{$car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' . $image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}"  style="width: 67px;min-width: 67px;height: 50px;object-fit: cover;border-radius: 4px;"/>
              </td>
              
              <td colspan="2">
                @php
                  $car_content = $car->car_content;
                  if (is_null($car_content)) {
                      $car_content = $car->car_content()->first();
                  }
                 
                @endphp
               
                  {{ strlen(@$car_content->title) > 25 ? mb_substr(@$car_content->title, 0, 25, 'utf-8') . '...' : @$car_content->title }}
               
              </td>
            
              <td>
                  {{number_format($car->price , 2)}}
              </td>
            
            
              <td>
                @php
                  if ($car->car_content) {
                      $brand = $car->car_content->brand()->first();
                  } else {
                      $brand = null;
                  }
                @endphp
                {{ $brand != null ? $brand['name'] : '-' }}
              </td>
              <td>
                @php
                  if ($car->car_content) {
                      $model = $car->car_content->model()->first();
                  } else {
                      $model = null;
                  }
                @endphp
                {{ $model != null ? $model['name'] : '-' }}
              </td>
              <td> </td>
            
            </tr>
            
                @php
                    $ad_stats = \App\Http\Controllers\Vendor\CarController::getAdStats($car->id);
                @endphp
        
                <tr>
                      
                    <td style="border-bottom: 1px solid #e0e0e0;width: 130px;">
                    <b style="    font-size: 13px;">Ad Impressions</b>
                    <div>{{$ad_stats['impressions']}}</div>
                    </td>
                    
                    <td style="border-bottom: 1px solid #e0e0e0;width: 100px;">
                    <b style="font-size: 13px;">Ad Views</b>
                    <div>{{$ad_stats['visitors']}}</div>
                    </td>
                    
                    <td style="border-bottom: 1px solid #e0e0e0;width: 130px;">
                    <b style="font-size: 13px;">Ad Click% (CTR)</b>
                    <div>{{($ad_stats['visitors'] > 0 && $ad_stats['impressions'] > 0 ) ? round(($ad_stats['visitors']/$ad_stats['impressions']) * 100 , 2 ) : 0}}</div>
                    </td>
                    
                    <td style="border-bottom: 1px solid #e0e0e0;width: 100px;">
                    <b style="font-size: 13px;">Ad Saves</b>
                    <div>{{$ad_stats['saves']}}</div>
                    </td>
                    
                    <td style="border-bottom: 1px solid #e0e0e0;width: 150px;">
                      <b style="font-size: 13px;">Phone Reveals</b>
                      <div>{{$ad_stats['phone_no_revel']}}</div>
                    </td>
                    
                    <td style="border-bottom: 1px solid #e0e0e0;width: 130px;">
                    <b style="font-size: 13px;">Ad Conversation</b>
                    <div>{{$ad_stats['leads']}}</div>
                    </td>
                
                </tr>
            
            </tbody>
            </table>
          




@endforeach



            <table class="" role="presentation" border="0" cellpadding="2" cellspacing="0" width="100%">
            <tr>
            <td valign="middle" style="text-align:center;">
            If you have received this email in error, or if you have any questions, please contact our customer support team
            </td>
            </tr>
            </table>
          
	      </tr>
        <tr>
            <td>
                <table class ="bg_white" cellpadding="0" cellspacing="0" width="100%">
                <tr>  
                <td style="text-align:center;">	
                        <a href="mailto:support@listit.im" title="logo" >
                            support@listit.im
                        </a>
                  </td>
                </tr>
                <tr>  
                  <td style="text-align:center;">
                        <p style="color:#455056; font-size:16px;line-height:20px; margin:0; font-family:'Rubik',sans-serif; ">
                             Simple, Safe, Secure 
                        </p>
                  </td>
                </tr> 
                <tr><td style="text-align:center;">
                <p style="color:#455056; font-size:13px;line-height:24px; margin:0; font-family:'Rubik',sans-serif; font-weight: 500; padding-bottom: 10px">
                   Copyright ©2024. List It Ltd. - All Rights Reserved.
                </p>
                </tr>  
              </td></table></td></tr>
        <!-- end tr -->
      <!-- 1 Column Text + Button : END -->
      </table>
      
    </div>
  </center>
</body>
</html>