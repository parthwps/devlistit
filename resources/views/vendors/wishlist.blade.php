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
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads Management'),
  ])
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
    @includeIf('vendors.partials.side-custom')
   
    <div class="col-md-9">
        
  @php
    $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
  @endphp
  @if ($current_package != '[]')
    @if (vendorTotalAddedCar() > $current_package->number_of_car_add)
      @php
        $car_add = 'over';
      @endphp
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li>{{ __('You have added total ') . vendorTotalAddedCar() }} {{ __(' cars.') }}</li>
            <li>{{ __('Your current package supports') . ' ' . $current_package->number_of_car_add . ' cars.' }} </li>
            <li>{{ __('You have to remove ') }}
              {{ vendorTotalAddedCar() - $current_package->number_of_car_add . __(' cars  to enable car editing.') }}</li>
          </ul>
        </div>
      </div>
    @else
      @php
        $car_add = '';
      @endphp
    @endif
    @if (vendorTotalFeaturedCar() > $current_package->number_of_car_featured)
      @php
        $car_featured = 'over';
      @endphp
      <div class="mt-2 mb-4">
        <div class="alert alert-danger text-dark">
          <ul>
            <li>{{ __('You have total  ') . vendorTotalFeaturedCar() . ' featured cars.' }}</li>
            <li>
              {{ __('With your current package you can feature ') . $current_package->number_of_car_featured . __(' cars.') }}
            </li>
            <li>{{ __('Your cars has been removed from featured cars section of our website.') }}
            </li>
            <li>{{ __('You have to unfeature ') }}
              {{ vendorTotalFeaturedCar() - $current_package->number_of_car_featured . __(' cars  to show your cars in featured cars section of our website.') }}
            </li>
          </ul>

        </div>
      </div>
    @else
      @php
        $car_featured = '';
      @endphp
    @endif
  @else
    @php
      $can_car_add = 0;
      $car_add = '';
      $car_featured = 'over';
      
      $pendingMemb = \App\Models\Membership::query()
          ->where([['vendor_id', '=', Auth::id()], ['status', 0]])
          ->whereYear('start_date', '<>', '9999')
          ->orderBy('id', 'DESC')
          ->first();
      $pendingPackage = isset($pendingMemb) ? \App\Models\Package::query()->findOrFail($pendingMemb->package_id) : null;
    @endphp
    @if ($pendingPackage)
      <div class="alert alert-warning text-dark">
        {{ __('You have requested a package which needs an action (Approval / Rejection) by Admin. You will be notified via mail once an action is taken.') }}
      </div>
      <div class="alert alert-warning text-dark">
        <strong>{{ __('Pending Package') . ':' }} </strong> {{ $pendingPackage->title }}
        <span class="badge badge-secondary">{{ $pendingPackage->term }}</span>
        <span class="badge badge-warning">{{ __('Decision Pending') }}</span>
      </div>
    @else
      <!-- <div class="alert alert-warning text-dark">
        {{ __('Your membership is expired. Please purchase a new package / extend the current package.') }}
      </div> -->
    @endif
    @includeIf('vendors.verify')
  @endif

  <div class="row">
    <div class="col-md-12">
    <div class="m-4">
    <ul class="nav nav-tabs nav-fill" style="justify-content:left !important;">
        <li class="nav-item">
            <a data-id="all" href="#" class="nav-link active">All Ads ({{count($cars)}})</a>
        </li>
        <li class="nav-item">
            <a data-id="1" href="#" class="nav-link">Listed ({{countSaveAds(Auth::id(),1)}})</a>
        </li>
        <li class="nav-item">
            <a data-id="2" href="#" class="nav-link"> Sold ({{count($cars) - countSaveAds(Auth::id(),1) }})</a>
        </li>
    </ul>
    
    <div class="us_com_heading">
        
        {{count($cars)}} vehicles saved
        
        <small style="display:block" class="us_com_subheading">
            Compare upto 5 cars now
        </small>
        
    </div>
    
    <div class="d-flex us_com_flex" style="    margin-top: 1rem;">
        
        <select class="form-control" name="categories" id="categorires" style="height: 45px;margin-top: 5px;" onchange="applyfilter(this , 'categories')">
            <option value="">All Vehicles</option>
            @foreach($categories as $category)
                <option value="{{$category->id}}" <?= (request()->category_id == $category->id  )  ? 'selected' : '' ?> >{{$category->name}}</option>
            @endforeach
        </select>
        
         <select class="form-control" name="filter_type" id="filter_type" style="height: 45px;margin-left: 1rem;margin-top: 5px;" onchange="applyfilter(this , 'filter_type')" >
                <option value="recent" <?= (request()->filter_type == 'recent' )  ? 'selected' : '' ?> >Most Recent</option>
                <option value="lowest_price" <?= (request()->filter_type == 'lowest_price' )  ? 'selected' : '' ?>>Price (Lowest)</option>
                <option value="highest_price" <?= (request()->filter_type == 'highest_price' )  ? 'selected' : '' ?>>Price (Highest)</option>
        </select>
        
        <button type="button" class="btn btn-info btn-sm us_com_btun" id="comparebtn" onclick="getComparison('compareall')" style="min-width:150px;margin-left: 1rem;float: right;margin-top: 5px;display:none;">
            Compare 
                <span id="com_cal">
                    2
                </span> 
            ads now
        </button>
        
        <button type="button" class="btn btn-danger btn-outline btn-sm " id="removeBTN" onclick="getComparison('removeall')" style="background: transparent !important;
        margin-left: 1rem;
        float: right;
        margin-top: 5px;
        width: 315px;
        color: red;display:none;">
        <i class="fa fa-trash" aria-hidden="true" style="font-size: 13px;margin-right: 5px;"></i>   Delete all 
        </button>
    </div>
    </div>
  </div>
  </div>
  
  
<form method="get" action="{{route('get_compare_car_data')}}" id="comparsim_form">
  <div class="row">
   <input type="hidden" name="request_type" id="request_type" value="compare" />
    <div class="col-md-12">
    
    <div class="container mt-2" id="fillwithAjax">
    @foreach ($cars as $car)
    @php
   
      $car_content = $car->car_content;
      
      if (is_null($car_content)) 
      {
          $car_content = $car->car_content()->first();
      }
      
    @endphp
      @if($car_content)  
      
  <div class="card ">
      <div class="card-header">
      <div class="d-flex justify-content-between">
          
          
        <div class=" d-inline-block text-left">
            @php
                $forExpired ="";
                $forExpired = noDaysLeftByAd($car->package_id,$car->created_at);
            @endphp
            
            @if($car->is_sold == 1 || $car->status == 2 )
                <span class="text-warning">
                    {{'Sold'}}
                </span>
            @else
            
                @if($car->status==2)
                    {{ 'Withdrawn' }} 
                @endif
                
                @if($car->status==0)
                    Needs Payment (Not Listed)
                @elseif($car->status==1 || $car->status==4 )
                    {{ noDaysLeftByAd($car->package_id,$car->created_at) }}
                @endif
            
            @endif
        </div>
    
        <h5 class="text-right">
            <a style="color:#1572E8; font-weight:100; font-size:15px;position: relative;z-index: 10;" href = "{{ route('remove.wishlist', $car->wishlist_id) }}">
                Remove
            </a>
        </h5>
    
      </div>
      </div>
      
      
      <div class="card-body" style="padding:0px;">  
      
      @if($car->is_sold == 1)
       <div class="overlay"></div>
      @endif
      
    <div class="row no-gutters">
      <div class="col-md-4 col-sm-*"> 
     <div class="image-container">
      <img class="  us_design"  src="{{  $car->vendor->vendor_type == 'normal' ? asset('assets/admin/img/car-gallery/' .$car->feature_image) :  env('SUBDOMAIN_APP_URL').'assets/admin/img/car-gallery/' . $car->feature_image }}" alt="Ad Image">
      </div>
       </div>
        <div class="col-md-8 col-sm-*">
        
        <label class="card-title us_mrg ">
        
        <a href="{{ route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id]) }}"
          target="_blank">
          {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
        </a></label>
        
        <div style="" class="us_absolut_position us_pro_mrg"> 
            <strong  class="us_mrg" style="color: black;font-size: 20px;">
                @if($car->previous_price && $car->previous_price < $car->price )
                    <strike style="font-weight: 300;color: gray;font-size: 14px;">{{ symbolPrice($car->price) }}</strike> . {{ symbolPrice($car->previous_price) }}
                @else
                    {{ symbolPrice($car->price) }}
                @endif
            </strong>
        </div>
        
        <div style="right: 0%;" class="us_absolut_position us_footer_div">
             <span style="float:right;margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Compare Ad" >
                <i class="fa fa-compress" aria-hidden="true" style="font-size: 20px;"></i>  
                <input type="checkbox" style="zoom: 1.4;position: relative;top: 1.7px;margin-left: 1px;" class="compare_checkbox" onclick="compareCheckbox(this)" name="comparison[]" value="{{$car->id}}" /> 
            </span>
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="How many times Ad saved" >
                <i class="fa fa-heart" aria-hidden="true" style="font-size: 20px;"></i>  {{ ($car->wishlists()->get()->count() > 0 ) ? $car->wishlists()->get()->count() : 'No' }} saves
            </span>
            
            <span style="float:right;    margin-right: 15px;font-size: 16px;color: #a7a7a7;" data-tooltip="tooltip" data-bs-placement="top" title="Total Views"  >
                <i class="fa fa-eye" aria-hidden="true" style="font-size: 20px;"></i>  {{ ($car->visitors()->get()->count() > 0 ) ? $car->visitors()->get()->count() : 'No' }} views
            </span>
        </div>
                
        
        </div>
      </div>
    </div>
    
  
  </div>
  @endif
@endforeach
</div>
  

      </div>
    </div>
</form>
    
  </div>
</div>
</div></div>
</div>




@endsection
@section('script')
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
<script>

  $(".nav-link").click(function(){
      
      var category_id = "<?= request()->category_id ?>";
      var filter_type = "<?= request()->filter_type ?>";
      
    // Remove active class from all items
    $(".nav-link").removeClass("active");
    // Add active class to the clicked item
    $(this).addClass("active");
    var url = '/customer/ad-management/ajaxsaveads?status='+$(this).data("id");
    $.ajax({
      type: 'GET',
      url: url,
      data:{category_id:  category_id , filter_type:filter_type},
      success: function (response) {
       
       
          $('#fillwithAjax').html(response.data);
         
       
      }
    });
  });
  </script>
  @endsection
