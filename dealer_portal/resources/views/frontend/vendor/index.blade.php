@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")

@section('pageHeading')
  Find A Dealer
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_page }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_page }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => 'Find A Dealer',
  ])

  <!-- Vendor-area start -->
  <div class="vendor-area pt-20 pb-15" style="background: #eaeaea;">
    <div class="container">
      <div class="product-sort-area pb-20" data-aos="fade-up">
        <div class="row align-items-center" style="background: white;border-radius: 10px;box-shadow: 0px 0px 10px gray;">
          <div class="col-lg-4" style="margin-top: 0.5rem;padding-left: 2rem;">
            <h4 class="">{{ count($vendors) }}
               Dealers {{ __('Found') }}</h4>
          </div>
          <div class="col-lg-8" style="margin-top: 1rem;">
                <form action="{{ route('frontend.vendors') }}" method="GET">
              <div class="row">
                <div class="col-lg-3 col-12">
                  <div class="form-group icon-start ">

                    <input type="text" name="name" style="height: 40px;" value="{{ request()->input('name') }}"
                      class="form-control" placeholder="Search Dealer">
                  </div>
                </div>

                <div class="col-lg-4 col-12">
                  <div class="form-group icon-start ">
                    <select class="form-control" name="dealer_type" style="    height: 40px;">
                        <option value="">All dealers</option>
                        <option value="1" <?= (request()->input('dealer_type') == 1) ? 'selected' : '' ?> >Franchise dealers</option>
                        <option value="2" <?= (request()->input('dealer_type') ==2) ? 'selected' : '' ?> >Independent dealers</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-3 col-12">
                  <div class="form-group icon-start ">

                    <input type="text" style="height: 40px;" name="location" class="form-control"
                      value="{{ request()->input('location') }}" placeholder="Search by location">
                  </div>
                </div>

                <div class="col-md-2 col-12">
                  <div class="form-group icon-start">
                    <button type="submit" style="height: 40px;" class="btn btn-icon bg-primary color-white btn-sm w-100">
                      <i class="fal fa-search"></i>
                      <span class="d-inline-block d-md-none">&nbsp;{{ __('Search') }}</span>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Products -->
      <div class="row" >
        @foreach ($vendors as $vendor)

            <div class="col-md-4  col-12" style="margin: 2rem 0rem;">
            <div class="card" style="background: #07072e; border-radius: 10px; display: flex; flex-direction: column; justify-content: space-between; height: 100%;   min-height: 450px; /* Adjust this height as needed */
            max-height: 600px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;">
        <div class="author us_parent_cls" style="padding: 1rem;">
            <a style="display: flex;" class="color-medium" href="{{ route('frontend.vendor.details', ['username' => $vendor->username]) }}" target="_self" title="{{ $vendor->username }}">

            @php
            // Define the image path based on whether the vendor has a photo or not
            $imagePath = $vendor->photo ? public_path('assets/admin/img/vendor-photo/' . $vendor->photo) : public_path('assets/img/default.png');

            // Get the image dimensions using getimagesize()
            if (file_exists($imagePath)) {
            $imageSize = getimagesize($imagePath);
            $imageHeight = $imageSize[1]; // The height of the image
            } else {
            $imageHeight = 0; // Default height if the image file doesn't exist
            }

            // Set the max-width based on the height
            $maxWidth = $imageHeight < 100 ? '80px' : '60px';
            @endphp

            @if ($vendor->photo)
            <img style="border-radius: 10%; max-width: {{ $maxWidth }};" class="lazyload blur-up"
            data-src="{{ asset('assets/admin/img/vendor-photo/' . $vendor->photo) }}"
            onerror="this.onerror=null;this.src='{{ asset('assets/img/default.png') }}';" alt="Image">
            @else
            <img style="border-radius: 10%; max-width: {{ $maxWidth }};" class="lazyload blur-up"
            data-src="{{ asset('assets/img/default.png') }}"
            alt="Image">
            @endif



                <span style="margin-left: 1rem;">
                    <strong class="us_font_15" style="color: white; font-size: 20px;">
                        {{ !empty($vendor->vendor_info) ? $vendor->vendor_info->name : 'deleted' }}
                        @if(!empty($vendor->est_year)) <b>.</b>
                        <span style="font-size: 15px; font-weight: normal; color: #e5e5e5;">Est {{date('Y' , strtotime($vendor->est_year))}}</span> @endif
                    </strong>
                    @if(!empty($vendor->is_franchise_dealer) && $vendor->is_franchise_dealer == 1)
                    @php
                    $review_data = null;
                    @endphp
                    @if($vendor->google_review_id > 0 )
                    @php
                    $review_data = get_vendor_review_from_google($vendor->google_review_id , true);
                    @endphp
                    @endif
                    <div style="display: flex; color:white;">Franchise Dealer
                        @if(!empty($review_data) && $review_data['total_reviews'] > 0 && $review_data['total_ratings'] > 0)
                        . <span>
                            <div class="rating-container" style="font-size: 15px; margin-top: -0.4rem; color:white;">
                                <span class="star on"></span>  {{$review_data['total_ratings']}}/5
                            </div>
                        </span>
                        @endif
                    </div>
                    @else
                    <div style="color:white;">Independent Dealer</div>
                    @endif
                </span>
            </a>
        </div>
        @if (!empty($vendor->banner_image))
        <img src="{{ asset('public/uploads/' . $vendor->banner_image) }}" style="width: 100%; object-fit: cover; height: 300px;" alt="banner">
        @else
         <img src="{{ asset('assets/img/noimage.jpg') }}" style="width: 100%; object-fit: cover; height: 300px;" alt="banner">
        @endif

        <div class="container" style="border: 1px solid #bcbcbc; border-radius: 10px; box-shadow: 0px 0px 10px gray; background: white;">
            <div class="row" style="margin-top: 1rem; padding: 1rem;">
                <div class="col-md-12">
                    <div class="flex" style="margin-bottom: 1rem;">
                        <label style="font-weight: 800; font-size: 19px; color: #5b5b5b;">Location</label>
                        <div>{{ !empty($vendor->vendor_info) ? $vendor->vendor_info->address : '' }}</div>
                    </div>
                    <div class="flex">
                        <label style="font-weight: 800; font-size: 19px; color: #5b5b5b;">Website</label>
                        <div><a style="color: #ee2c7b;" href="">{{ !empty($vendor->website_link) ? $vendor->website_link : '' }}</a></div>
                    </div>
                </div>
                <div class="col-md-12" style="display: flex; margin-top: 1rem;">
                    <button id="userphonebutton" onclick="savePhoneView(this)" style="margin-right: 5px" data-phone-number="{{$vendor->phone}}" class="btn btn-md btn-outline w-100 showLoader mb-3">{{ __('Show Phone ') }}</button>
                    <a class="btn btn-md btn-outline w-100 showLoader mb-3" style="margin-left: 5px" href="{{ route('frontend.vendor.details', [$vendor->username]) }}">Visit Showroom</a>
                </div>
            </div>
        </div>
    </div>
</div>







        @endforeach
      </div>
      <div class="pagination mt-20 mb-25 justify-content-center" data-aos="fade-up">
        {{ $vendors->links() }}
      </div>

      @if (!empty(showAd(3)))
        <div class="text-center mt-4">
          {!! showAd(3) !!}
        </div>
      @endif
    </div>
  </div>
  <!-- Vendor-area end -->
@endsection


<script>
    function savePhoneView(self)
    {

        var phoneNumber = document.getElementById('userphonebutton').getAttribute('data-phone-number');
$(self).html(phoneNumber)

    }
</script>
