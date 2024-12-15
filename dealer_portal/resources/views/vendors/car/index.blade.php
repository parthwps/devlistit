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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])
  <div class="user-dashboard pt-20 pb-60">
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

  <div class="row" style='-webkit-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;-moz-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;padding: 1rem;background: #ffffff;color: #000000;text-align: center;margin-bottom: 1rem;border-radius: 4px;'>
  <div class="col-md-12" style="text-align: right;margin-bottom: 1rem;">
  <a style="color: #ee2c7b;" href="javascript:void(0);" onclick="openInfoModal()">Whats this?</a>
  </div>

<div class="col-md-3 dsds" style="    text-align: left;">
<h5>Your Ad  Performance</h5>
<!--<h6 class="fw-normal mb-0">Till yet</h6>-->
</div>


<div class="col-md-9">
  

<div class="row">

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
  <h6 class="fw-normal">Active Ads</h6>
  <h5 class="mb-0">{{$totalPublish}}</h5>
</div>

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
<h6 class="fw-normal">Impressions</h6>
<h5 class="mb-0">{{$impressions}}</h5>
</div>

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
<h6 class="fw-normal">Views</h6>
<h5 class="mb-0">{{$visitors}}</h5>
</div>

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
<h6 class="fw-normal">Click% (CTR)</h6>
<h5 class="mb-0">{{($visitors > 0 && $impressions > 0 ) ? round(($visitors/$impressions) * 100 , 2 ) : 0}}</h5>
</div>

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
<h6 class="fw-normal">Saves</h6>
<h5 class="mb-0">{{$saves}}</h5>
</div>

<div class="col-md-2 text-start col-sm-6 col-6 mob_mt_1rem">
<h6 class="fw-normal">Leads</h6>
<h5 class="mb-0">{{$leads}}</h5>
</div>

</div>

</div>
</div>


  <div class="row" style='padding: 1rem;text-align: center;margin-bottom: 1rem;'>
	
	<div class="col-md-9 col-lg-7">
		<div class="row">
			<div class="col-4 @if(request()->tab == 'publish') us_active_style @else us_inactive_style  @endif">
				<a href="{{ route('vendor.car_management.car', ['language' => 'en' , 'tab' => 'publish']) }}" class="h5">Published ({{$totalPublish}})</a>
			</div>

			<div class="col-4 @if(request()->tab == 'withdrawn') us_active_style @else us_inactive_style  @endif">
				<a href="{{ route('vendor.car_management.car', ['language' => 'en' , 'tab' => 'withdrawn']) }}" class="h5">Withdrawn ({{$totalWithDrawn}})</a>
			</div>

			<div class="col-4 @if(request()->tab == 'draft') us_active_style @else us_inactive_style  @endif">
				<a href="{{ route('vendor.car_management.car', ['language' => 'en' , 'tab' => 'draft']) }}" class="h5">Draft ({{$totalDraft}})</a>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-lg-5 us_inactive_style  ">
		<a href="javascript:void(0);" onclick="loadAndPrint()" style="float: right;color: #953fff;">Print stock report</a>
	</div>


	  <div id="printArea">
			<!-- Content loaded from AJAX will be placed here -->
	  </div>

  </div>

  <div class="row">

 



    <div class="col-md-12">
    
      <div class="card">
        
      

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($cars) == 0)
                <h4 class="">{{ __('You have not placed any Ads yet') }}</h4>
                <div class="mb-2"><small class="text-center">What are you waiting for? Start selling today</small></div>
                <a href="{{ route('vendor.cars_management.create_car') }}" class="btn btn-primary btn-sm float-right"><i
                  class="fas fa-plus"></i> {{ __('Place an Ad') }}</a>
              @else
                <div class="table-responsive">
                    
                    <a href="{{ route('vendor.cars_management.create_car') }}" class="btn btn-primary btn-sm" style="float: right;margin-left: 1rem;"><i class="fas fa-plus"></i> {{ __('Place an Ad') }}</a>
                    
                  <table class="table mt-3" id="myTable3">
                      
                    <thead class="table_header_small">
                      <tr>
                  
                        <th scope="col" class="no-export">{{ __('Image') }}</th>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                        <th scope="col">{{ __('Brand') }}</th>
                        <th scope="col">{{ __('Model') }}</th>
                        <th scope="col">Views</th>
                        <th scope="col" style="width: 90.2375px;">{{ __('Last Bump') }}</th>
                        <th scope="col" style="width: 100.3px;" class="no-export"> {{ __('Quick Action') }}</th>
                        <th scope="col" class="no-export">{{ __('Spotlight') }}</th>
                        <th scope="col" style="width: 70px;min-width: 70px;" class="no-export">{{ __('Status') }}</th>
                        <th scope="col" style="width: 80px;min-width: 80px;" class="no-export">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($cars as $car)
                        <tr>
                          <td>

                          @php 
                           
                            $car_content = $car->car_content;
                              if (is_null($car_content)) {
                                  $car_content = $car->car_content()->first();
                              }
                         
                    
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
                            $imng = $car->galleries->sortBy('priority')->first();
                            
                            $image_path = $imng->image;
                            $rotation = $imng->rotation_point;
                        } 
                    
                    @endphp
                    
                    

							<a href="javascript:void(0);"  class="d-inline-block">
								<img src="{{asset('assets/admin/img/car-gallery/'.$image_path )}}"  style="width: 67px;min-width: 67px;height: 50px;object-fit: cover;border-radius: 4px;"/>
							</a>
						  </td>
                          <td>
                            @php
                              $car_content = $car->car_content;
                              if (is_null($car_content)) 
                              {
                                  $car_content = $car->car_content()->first();
                              }
                            @endphp
                            <a href="{{ env("HOME_URL").$car_content->sub_category->slug.'/'.$car_content->slug.'/'.$car->id }}"
                              target="_blank" class="listit-table-title text-truncate">
                              {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                            </a>
							<p class="listit-table-titlesub" title="">--</p>
                          </td>

                          <td>
                              <span class="listit-table-price">{{number_format($car->price , 2)}}</span>
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


                          <td>
                                <strong>
                                    {{$car->visitors()->get()->count()}} 
                                    
                                    @if($car->visitors()->get()->count() > 0 )
                                        <i class="fa fa-angle-double-up" style="font-weight: normal;color: #19d919;margin-left: 10px;"></i>
                                    @else
                                        <i class="fa fa-minus" style="font-weight: normal;color: red;margin-left: 10px;" ></i>
                                    @endif
                                    
                                </strong>
                          </td>
                          
                          <td>
                          <?= (new DateTime($car->created_at))->diff(new DateTime())->format('%a') ?>  days 
                          <br>
                          <small><?= (new DateTime($car->bump_date))->diff(new DateTime())->format('%a') ?>  days live</small>
                          </td>

                          <td>
                            @if(Auth::guard('vendor')->user()->bump == 0)
                            <a href="javascript:void(0);" onclick="validateCarBump({{ $car->id }})" style="@if(!empty($car->bump_date)) color:#ee2c7b; @else color:#6e6e6e; @endif text-align: center;display: inline-block;white-space: nowrap;">
								<i class="fa fa-arrow-circle-up"></i>
								Quick Bump
							</a>
                            @else
							<a href="{{route('vendor.car_management.addbump' , ['car' => $car])}}" style="@if(!empty($car->bump_date)) color:#ee2c7b; @else color:#6e6e6e; @endif text-align: center;display: inline-block;white-space: nowrap;">
								<i class="fa fa-arrow-circle-up"></i>
								Quick Bump
							</a>
							@endif
                         </td>


                          <td>
                            <form id="featureForm{{ $car->id }}" class="d-inline-block mb-0"  action="{{ route('vendor.cars_management.update_featured_car') }}"  method="post">
                            @csrf
                            <input type="hidden" name="carId" value="{{ $car->id }}">
                            <input type="hidden" name="car_featured" value="{{ $car_featured }}">
                            <select
                            class="form-control {{ $car->is_featured == 1 ? 'bg-success' : 'bg-danger' }} form-control-sm"
                            name="is_featured"
                            id="fearured_select_box"
                            @if(Auth::guard('vendor')->user()->spotlight == 0 && $car->is_featured == 0)
                            onchange="validateCarFeatured({{ $car->id }})" 
                            @else
                            onchange="document.getElementById('featureForm{{ $car->id }}').submit();"
                            @endif >
                            <option value="1" {{ $car->is_featured == 1 ? 'selected' : '' }}>
                            {{ __('Yes') }}
                            </option>
                            <option value="0" {{ $car->is_featured == 0 ? 'selected' : '' }}>
                            {{ __('No') }}
                            </option>
                            </select>
                            </form>
                          </td>

                          <td style="padding-left: 0px !important;padding-right: 0px !important;">
                            <form id="statusForm{{ $car->id }}" class="d-inline-block mb-0"
                              action="{{ $car_add != 'over' ? route('vendor.cars_management.update_car_status') : '#' }} "
                              method="post">
                              @csrf
                              <input type="hidden" name="carId" value="{{ $car->id }}">

                              <select
                                class="form-control {{ $car->status == 1 ? 'bg-success' : 'bg-danger' }} form-control-sm"
                                name="status"
                                onchange="document.getElementById('statusForm{{ $car->id }}').submit();"
                                {{ $car_add == 'over' ? 'disabled' : '#' }}>
                                <option value="1" {{ $car->status == 1 ? 'selected' : '' }}>
                                  {{ __('Published') }}
                                </option>
                                <option value="0" {{ $car->status == 0 ? 'selected' : '' }}>
                                  {{ __('Draft') }}
                                </option>
                                <option value="2" {{ $car->status == 2 ? 'selected' : '' }}>
                                  {{ __('Withdrawn') }}
                                </option>
                              </select>
                            </form>
                          </td>

                          <td>
                            <a style="padding: 0;margin: 5px;" class="d-inline-block"
                              href="{{ $car_add != 'over' ? route('vendor.cars_management.edit_car', $car->id) : '#' }}"
                              disabled>
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.6836 5.88852L2.7819 16.9287L2 22L7.16665 21.4567L18.1115 10.3729L13.6836 5.88852Z" fill="currentColor"></path><path d="M16.8893 2.47038L14.7784 4.58124L19.4196 9.22238L21.5304 7.11152C21.7902 6.85174 21.7902 6.43055 21.5304 6.17076L17.8301 2.47038C17.5703 2.2106 17.1491 2.2106 16.8893 2.47038Z" fill="currentColor"></path></svg>
                            </a>

                            <form class="deleteForm d-inline-block mb-0"
                              action="{{ route('vendor.cars_management.delete_car') }}" method="post">
                              @csrf
                              <input type="hidden" name="car_id" value="{{ $car->id }}">

                              <button style="padding: 0;margin: 5px;" type="submit" class="deleteBtn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.4948 12L21.478 5.01684C21.8094 4.68601 21.9958 4.23707 21.9962 3.76879C21.9966 3.3005 21.811 2.85123 21.4802 2.51981C21.1494 2.18839 20.7004 2.00197 20.2321 2.00156C19.7638 2.00115 19.3146 2.18677 18.9832 2.51761L12 9.50077L5.01684 2.51761C4.68542 2.18619 4.23592 2 3.76723 2C3.29853 2 2.84903 2.18619 2.51761 2.51761C2.18619 2.84903 2 3.29853 2 3.76723C2 4.23592 2.18619 4.68542 2.51761 5.01684L9.50077 12L2.51761 18.9832C2.18619 19.3146 2 19.7641 2 20.2328C2 20.7015 2.18619 21.151 2.51761 21.4824C2.84903 21.8138 3.29853 22 3.76723 22C4.23592 22 4.68542 21.8138 5.01684 21.4824L12 14.4992L18.9832 21.4824C19.3146 21.8138 19.7641 22 20.2328 22C20.7015 22 21.151 21.8138 21.4824 21.4824C21.8138 21.151 22 20.7015 22 20.2328C22 19.7641 21.8138 19.3146 21.4824 18.9832L14.4948 12Z" fill="currentColor"></path></svg>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div></div>
</div>
@endsection

<style>

.dt-buttons
{
    float: right;
    margin-left: 1rem;
}

div.dataTables_wrapper div.dataTables_filter input 
{
    height: 33px;
    border-radius: 3px;
}

.dt-button
{
    border: 1px solid #bbbbbb;
    font-size: 14px;
    color: #9c9c9c;
    border-radius: 3px;
    height: 33px;
}

.us_active_style {
    padding: 0.5rem;
    border-bottom: 2px solid rgb(51, 51, 51);
}
.us_inactive_style {
    padding: 0.5rem;
}
.us_inactive_style a{
    color: rgb(102, 102, 102);
	font-weight: 400;
}
.card, .card-light {
    border-radius: 4px;
    -webkit-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1) !important;
    -moz-box-shadow: 2px 6px 15px 0px rgba(69, 65, 78, 0.1) !important;
    box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px !important;
}
.listit-table-title{
    font-size: 14px;
    line-height: 24px;
    font-weight: 700;
    max-width: 200px;
    display: block;
}
.listit-table-titlesub{
    display: block;
    color: rgb(102, 102, 102);
    font-weight: 400;
    font-size: 12px;
    line-height: 16px;
	margin: 0;
}
</style>