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


  <div class="row">

    <div class="col-md-12">
    
    @if (count($enquiry_preferences) == 0)

              <div class="card">
                <div class="card-body">

            <div class="row">
                <div class="col-lg-12">
                <h3 class="">{{ __('You have not added any user yet') }}</h3>
                <a href="javascript:void(0);" onclick="addnewuser()" class="btn btn-primary btn-sm float-right"><i
                class="fas fa-plus"></i> {{ __('Add New User') }}</a>

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
                <a href="javascript:void(0);" style="float: right;margin-left: 1rem;" onclick="addnewuser()" class="btn btn-primary btn-sm float-right"><i
                class="fas fa-plus"></i> {{ __('Add New User') }}</a>
                  <table class="table table-bordered mt-3" id="myTable2">
                    <thead>
                      <tr>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Email') }}</th>
                        <th scope="col">{{ __('Phone') }}</th>
                        <th scope="col">{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>


                    @foreach ($enquiry_preferences as $enquiry_preference)
                        <tr>
                         <td>{{$enquiry_preference->name}}</td>
                         <td>{{$enquiry_preference->email}}</td>
                         <td>{{$enquiry_preference->phone_no}}</td>
                         <td>

                         <a style="    padding: 0.8rem;" class="btn btn-secondary btn-sm mr-1 mt-1"
                              href="javascript:void(0);"
                              onclick="addnewuser({{$enquiry_preference->id}} , this)" data-phone_no="{{$enquiry_preference->phone_no}}"  data-email="{{$enquiry_preference->email}}" data-name="{{$enquiry_preference->name}}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>


                         <form class="deleteForm d-inline-block"
                              action="{{ route('vendor.cars_management.deleteuser') }}" method="get">
                          
                              <input type="hidden" name="user_id" value="{{ $enquiry_preference->id }}">

                              <button style="padding: 0.8rem;" type="submit" class="btn btn-danger mt-1 btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                              </button>
                            </form>
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


input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}

  </style>

