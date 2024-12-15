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
 
  <div class="user-dashboard pt-20 pb-60 margin-top-us" >
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  @if(Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->vendor_type == 'normal')
       @includeIf('vendors.partials.side-custom')
    <div class="col-md-9">

    @else
    <div class="col-md-12">

    @endif

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
    
  @endif
  <form method="GET" action="" id="filter_form">
  <div class="row" style='-webkit-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;-moz-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;padding: 1rem;background: #ffffff;color: #000000;margin-bottom: 1rem;border-radius: 4px;'>
<div class="col-md-12" style="    text-align: left;">
<b>Detailed Report</b>

<a href="javascript:void(0);"  style="color: #ee2c7b;float: right;" onclick="getSubMails()">Email report Subscription</a>
<br>
    Filters
    <br>
   
    <hr>

</div>

<div class="col-md-3 ">
<div style="margin-bottom: 0.5rem;">Date Presets</div>
<input type="text" id="daterange" value="{{!empty(request()->daterange) ? request()->daterange : '' }}" class="form-control onchngesubmit" name="daterange" value="" />
</div>

<div class="col-md-2 ">
<div style="margin-bottom: 0.5rem;">Make</div>
<select class="form-control js-example-basic-single1 onchngesubmit" name="make">
<option value="">Select Make</option>
    @foreach($brands as $brand)
    <option value="{{$brand->id}}" {{ (request()->make == $brand->id ) ? 'selected' : '' }}>{{$brand->name}}</option>
    @endforeach
</select>
</div>

<div class="col-md-2 ">
<div style="margin-bottom: 0.5rem;">Model</div>
<select class="form-control js-example-basic-single1 onchngesubmit" name="model">
<option value="">Select Model</option>
    @foreach($models as $model)
    <option value="{{$model->id}}" {{ (request()->model ==$model->id ) ? 'selected' : '' }}>{{$model->name}}</option>
    @endforeach
</select>
</div>

<div class="col-md-3 ">
<div style="margin-bottom: 0.5rem;">Registration Number</div>
<select class="form-control js-example-basic-single1 onchngesubmit" name="reg_no"> 
<option value="">Select Registration No</option>
    @foreach($registration_no as $regis_no)
    <option value="{{$regis_no->vregNo}}" {{ (request()->reg_no ==$regis_no->vregNo ) ? 'selected' : '' }} >{{$regis_no->vregNo}}</option>
    @endforeach
</select>
</div>


<div class="col-md-2 ">
  <div style="margin-bottom: 0.5rem;">Ad Status</div>

  <select class="form-control js-example-basic-single1 onchngesubmit" name="status">
    <option value="">Select Status</option>

    <option value="1" {{ (request()->status ==  1 ) ? 'selected' : '' }} >Published</option>
    <option value="2" {{ (request()->status ==  2 ) ? 'selected' : '' }}>Sold</option>
    <option value="3" {{ (request()->status ==  3 ) ? 'selected' : '' }}>Withdrawn</option>
 
</select>
</div>



</div>

</form>

  <div class="row">

    <div class="col-md-12">
    
    @if (count($cars) == 0)

              <div class="card">
                <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                <h3 class="">{{ __('You have not placed any Ads yet') }}</h3>
                <small class="text-center">What are you waiting for? Start selling today</small><br>
                <a href="{{ route('vendor.cars_management.create_car') }}" class="btn btn-primary btn-sm float-right"><i
                class="fas fa-plus"></i> {{ __('Place an Ad') }}</a>

                </div>
            </div>

            </div>
            </div>

              @else

           

              
              <div class="card">
                <div class="card-body">
              <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
      
                  <table class="table table-striped mt-3" id="myTable2">
                    <thead>
                      <tr>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Day Live') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('Impression') }}</th>
                        <th scope="col">{{ __('Views') }}</th>
                        <th scope="col">{{ __('Saves') }}</th>
                        <th scope="col">{{ __('CTR') }}</th>
                        <th scope="col">{{ __('Leads') }}</th>
                        <th scope="col">{{ __('Bump') }}</th>
                        <th scope="col">{{ __('Spotlight') }}</th>
                      </tr>
                    </thead>
                    <tbody>


                    <tr>
                         
                         <td><b>Total</b> </td>

                         <td> </td>

                         <td></td>

                         <td>
                               {{$impressions}}
                         </td>

                         <td>
                                {{$visitors}}
                         </td>

                         <td>
                                {{$saves}}
                         </td>

                         <td>
                                {{($visitors > 0 && $impressions > 0 ) ? round(($visitors/$impressions) * 100 , 2 ) : 0}}
                         </td>

                         <td>
                                {{$leads}}
                         </td>

                         <td></td>

                         <td></td>
                   </tr>


                    @foreach ($cars as $car)
                        <tr>
                         
                          <td>
                            @php
                              $car_content = $car->car_content;
                              if (is_null($car_content)) {
                                  $car_content = $car->car_content()->first();
                              }
                             
                            $ad_stats = \App\Http\Controllers\Vendor\CarController::getAdStats($car->id);

                            @endphp

                            <a href="{{ route('frontend.car.details', ['slug' => $car_content->slug, 'id' => $car->id]) }}"
                              target="_blank">
                              {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                            </a>
                          </td>

                          <td>
                            
                              <?= (new DateTime($car->bump_date))->diff(new DateTime())->format('%a') ?> 
                          </td>


                          <td>
                              {{number_format($car->price , 2)}}
                          </td>


                          <td>
                                {{$ad_stats['impressions']}}
                          </td>


                          <td>
                          {{$ad_stats['visitors']}}
                          </td>

                          <td>
                          {{$ad_stats['saves']}}
                          </td>


                          <td>
                          {{($ad_stats['visitors'] > 0 && $ad_stats['impressions'] > 0 ) ? round(($ad_stats['visitors']/$ad_stats['impressions']) * 100 , 2 ) : 0}}
                          </td>

                          <td>
                          {{$ad_stats['leads']}}
                          </td>

                          <td>
                          {{$car->bump}}
                          </td>

                          <td>
                             {{($car->is_featured == 1) ? 'yes' : 'no'}}
                          </td>
                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                    </div>

    </div>
    </div>

    </div>
    </div>


@endif

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />



<style>

  .us_active_style
  {
    background: #ececec;
    padding: 0.5rem;
    border-radius: 10px;
  }

  .us_inactive_style
  {
    padding: 0.5rem;
    border-radius: 10px;
  }
  .margin-top-us
  {
    margin-top:5%;
  }

  @media screen and (max-width: 580px) {
 .margin-top-us
  {
    margin-top:10%;
  }
}
  </style>

