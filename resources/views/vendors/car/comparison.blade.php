@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup') }}
  @else
    {{ __('Signup') }}
  @endif
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_signup }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_signup }}
  @endif
@endsection

@section('content')

    <div class="user-dashboard pt-20 pb-60">
        <div class="container " style="margin-top:80px !important">
          
          <div class="row">
              <div class="col-md-12">
                 <h3> Compare Your Saved Ads</h3>
              </div>
          </div>
          <input type="hidden" id="car_ids" value="@foreach($cars as $list){{$list->id.','}}@endforeach" />
          
          <div class=" mt-20" style="display:flex;justify-content: center;" id="append">
              
                @foreach($cars as $key => $car_content)
                  
                @php
                
                $image_path = $car_content->feature_image;
                
                $rotation = 0;
                
                if($car_content->rotation_point > 0 )
                {
                     $rotation =    $car_content->rotation_point;
                }
                
                if(!empty($image_path) && $car_content->rotation_point == 0 )
                {   
                   $rotation = $car_content->galleries->where('image' , $image_path)->first();
                   
                   if($rotation == true)
                   {
                        $rotation = $rotation->rotation_point;  
                   }
                   else
                   {
                        $rotation = 0;   
                   }
                }
                
                if(empty($car_content->feature_image))
                {
                    $imng = $car_content->galleries->sortBy('priority')->first();
                    $image_path = $imng->image;
                    $rotation = $imng->rotation_point;
                }
                
                if($key == 2)
                {
                    break;
                }
                @endphp
               
                <div @if($key == 1) class="us_card_margin" id="second_card" @else  id="first_card"  @endif>
                  
                    <div style="background: #ececec;
                    padding: 0.5rem;
                    border-radius: 5px;
                    color: #878787;text-align:center;"> 
                    
                    <span style="float: left;">
                        @if($key == 0)
                            <i class="fa fa-angle-left" aria-hidden="true" style="cursor:pointer;" onclick="gotothe('f_previous' , {{$car_content->id}})"></i>
                        @else
                            <i class="fa fa-angle-left" aria-hidden="true" style="cursor:pointer;" onclick="gotothe('s_previous' , {{$car_content->id}})"></i>
                        @endif
                    </span>
                    
                    <span>
                         {{$key+1}} of {{count($cars)}}
                    </span>
                    
                    <span style="float: right;">
                        @if($key == 0)
                            <i class="fa fa-angle-right" aria-hidden="true" style="cursor:pointer;" onclick="gotothe('f_next'  , {{$car_content->id}})" ></i>
                        @else
                            <i class="fa fa-angle-right" aria-hidden="true" style="cursor:pointer;" onclick="gotothe('s_next'  , {{$car_content->id}})" ></i>
                        @endif
                        
                    </span>
                    
                </div>
                
                <div class="card us-card-width" style="">
                    
                    <div class="image-container">
                        
                   
                <img class="card-img-top us_card_img" src=" {{  $car_content->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$image_path) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $image_path }}  " alt="Product" style="transform: rotate({{$rotation}}deg);height: 250px;" onerror="this.onerror=null;this.src='{{ asset('assets/img/noimage.jpg') }}';" alt="Card image cap">
                 </div>
                <div class="card-body us_card_body">
                <h5 class="card-title"><b class="us_card_title">{{$car_content->car_content->title}}</b></h5>
                </div>
                <ul class="list-group list-group-flush">
                
                
                <li class="list-group-item us_card_body"><div>
                <b>Price</b>
                <span style="float: right;    display: flex;">
                @if($car_content->previous_price && $car_content->previous_price < $car_content->price)
                <strike style="font-weight: 300;color: red;font-size: 12px;float: left;margin-right: 5px;margin-top: 4px;">{{ symbolPrice($car_content->price) }}</strike> 
                <br> 
                <div style="color:black;"> {{ symbolPrice($car_content->previous_price) }}</div>
                @else
                {{ symbolPrice($car_content->price) }}   
                @endif
                
                </span>
                </div>
                </li>
                
                @if ($car_content->what_type != null)
                <li class="list-group-item us_card_body"><div>
                <b>Condition</b>
                <span style="float: right;">{{ str_replace('_' , ' ' , $car_content->what_type ) }}</span>
                </div>
                </li>
                @endif
                
                @if ($car_content->year != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Model Year') }}</b>
                <span style="float: right;">{{ $car_content->year }}</span>
                </div>
                </li>
                @endif
                
                @if ($car_content->mileage != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Mileage') }}</b>
                <span style="float: right;">{{ number_format($car_content->mileage) }}</span>
                </div>
                </li>
                @endif
                
                
                @if ($car_content->speed != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Top Speed') }}</b>
                <span style="float: right;">{{ $car_content->speed }}({{ __('KMH') }})</span>
                </div>
                </li>
                @endif
                
                @if ($car_content->car_content->brand != null)
                <li class="list-group-item us_card_body"><div>
                <b>Make</b>
                <span style="float: right;">{{ optional($car_content->car_content->brand)->name }}</span>
                </div>
                </li>
                @endif		
                
                @if ($car_content->car_content->model != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Model') }}</b>
                <span style="float: right;">{{ optional($car_content->car_content->model)->name }}</span>
                </div>
                </li>
                @endif
                
                @if ($car_content->car_content->fuel_type != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Fuel Type') }}</b>
                <span style="float: right;">{{ optional($car_content->car_content->fuel_type)->name }}</span>
                </div>
                </li>
                @endif	
                
                @if ($car_content->car_content->transmission_type != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Transmission') }}</b>
                <span style="float: right;">{{ optional($car_content->car_content->transmission_type)->name }}</span>
                </div>
                </li>
                @endif	
                
                
                @if ($car_content->engineCapacity != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Engine') }}</b>
                <span style="float: right;">{{ roundEngineDisplacement($car_content) }}</span>
                </div>
                </li>
                @endif		
                
                @if ($car_content->bettery_range != null || $car_content->battery != null  && in_array(optional($car_content->car_content->fuel_type)->name , ['Electric' , 'Hybrid']) )
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Bettery ') }}</b>
                <span style="float: right;">{{ (!empty($car_content->bettery_range)) ? $car_content->bettery_range : $car_content->battery. '+ M' }}</span>
                </div>
                </li>
                @endif	
                
                
                @if ($car_content->current_area_regis != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __(' Area') }}</b>
                <span style="float: right;">{{ ucfirst($car_content->current_area_regis) }}</span>
                </div>
                </li>
                @endif
                
                
                @if ($car_content->history_checked != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('History ') }}</b>
                <span style="float: right;">Yes</span>
                </div>
                </li>
                @endif	
                
                @if ($car_content->delivery_available != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Delivery ') }}</b>
                <span style="float: right;">Yes</span>
                </div>
                </li>
                @endif	
                
                @if ($car_content->warranty_type != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Warranty ') }}</b>
                <span style="float: right;">{{ $car_content->warranty_type }}</span>
                </div>
                </li>
                @endif	
                
                
                @if ($car_content->warranty_duration != null || $car_content->warranty != null )
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Warranty duration') }}</b>
                <span style="float: right;">{{ (!empty($car_content->warranty_duration)) ? $car_content->warranty_duration : $car_content->warranty }}</span>
                </div>
                </li>
                @endif			
                
                
                @if ($car_content->power != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Power') }}</b>
                <span style="float: right;">{{ $car_content->power }}</span>
                </div>
                </li>
                @endif	
                
                
                @if ($car_content->road_tax != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __(' Tax') }}</b>
                <span style="float: right;">{{ $car_content->road_tax }}</span>
                </div>
                </li>
                @endif	
                
                
                @if ($car_content->number_of_owners != null || $car_content->owners != null )
                <li class="list-group-item us_card_body"><div>
                <b>{{ __(' owners') }}</b>
                <span style="float: right;">{{ (!empty($car_content->number_of_owners)) ? $car_content->number_of_owners : $car_content->owners }}</span>
                </div>
                </li>
                @endif
                
                @if ($car_content->doors != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Doors') }}</b>
                <span style="float: right;">{{ $car_content->doors }}</span>
                </div>
                </li>
                @endif		
                
                @if ($car_content->seats != null)
                <li class="list-group-item us_card_body"><div>
                <b>{{ __('Seats') }}</b>
                <span style="float: right;">{{ $car_content->seats }}</span>
                </div>
                </li>
                @endif
                
                </ul>
                
                <div class="card-body">
                    
                    @if($car_content->vendor->id != Auth::guard('vendor')->user()->id)
                    
                    <a href="{{ route('frontend.car.details', ['cattitle' => catslug($car_content->car_content->category_id), 'slug' => $car_content->car_content->slug, 'id' => $car_content->id , 'compare_from' => 'compare']) }}"
                     class="btn btn-md  w-100 " style="color:white;background-color: #007BFF;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;">
                        Contact Now
                    </a>
                    @else
                     <a href="javascript:void(0);"
                     class="btn btn-md  w-100 " style="color:white;background-color: gray;padding-top: 0.8rem;padding-bottom: 0.8rem;margin-bottom: 0px !important;">
                        You
                    </a>
                    @endif
                    
                </div>
                
                </div>
                </div>
              
             @endforeach
          </div>
          
        </div>
    </div>

@endsection
@section('script')
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<script>

  $(".nav-link").click(function(){
    // Remove active class from all items
    $(".nav-link").removeClass("active");
    // Add active class to the clicked item
    $(this).addClass("active");
    var url = '/customer/ad-management/ajaxsaveads?status='+$(this).data("id");
    $.ajax({
      type: 'GET',
      url: url,
      
      success: function (response) {
       
       
          $('#fillwithAjax').html(response.data);
         
       
      }
    });
  });
  </script>
  @endsection
