@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
    @if (!empty($pageHeading))
        {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Place Ad') }}
    @else
        {{ __('Place Ad') }}
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
         'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Place Ad'),
     ])
    <div class="user-dashboard pt-20 pb-60">

        <div class="container">

            <div class="row gx-xl-5">

                @includeIf('vendors.partials.side-custom')
                <div class="col-md-9">

                    @php
                        $current_package = App\Http\Helpers\VendorPermissionHelper::packagePermission(Auth::guard('vendor')->user()->id);
                    @endphp

                    <div class="row">
                        <div class="col-md-12">
                            @if ($current_package != '[]')
                                @if (vendorTotalAddedCar() >= $current_package->number_of_car_add)
                                    <div class="alert alert-danger">
                                        {{ __("You can't add more car. Please buy/extend a plan to add car") }}
                                    </div>
                                    @php
                                        $can_car_add = 2;
                                    @endphp
                                @else
                                    @php
                                        $can_car_add = 1;
                                    @endphp
                                @endif
                            @else
                                @php
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
                                @php
                                    $can_car_add = 0;
                                @endphp
                            @endif

                            <div class="card">

                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-lg-12 mb-2">
                                            <div class="form-group">
                                                {{-- <h4 style="color:gray">Ad Details </h4> --}}
                                            </div>
                                        </div>
                                    </div> <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                                      <button type="button" class="close" data-dismiss="alert">×</button>
                                      <ul></ul>
                                  </div>
                                    <div class="col-lg-12">
                                        <label for="" class="mb-2"><strong>{{ __('Gallery Images') }}
                                                **</strong> <br> <small class="text-danger"> load up to <span
                                                        id="change_text_photo_allow">15</span> images .jpg,
                                                .png, & .gif </small></label>

                                        @if($draft_ad == true && !empty($draft_ad->images))
                                            @php
                                                $images = json_decode($draft_ad->images, true);
                                                $items = [];
                                            @endphp

                                            @if(count($images) > 0)
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table table-striped" id="imgtable">
                                                            @foreach($images as $image)
                                                                @php
                                                                    $item = \App\Models\Car\CarImage::where('image', $image)->first();
                                                                @endphp

                                                                @if($item)
                                                                    @php
                                                                        $items[] = [
                                                                            'id' => $item->id,
                                                                            'image' => $item->image,
                                                                            'rotation_point' => $item->rotation_point,
                                                                            'priority' => $item->priority,
                                                                        ];
                                                                    @endphp
                                                                @endif
                                                            @endforeach

                                                            @php
                                                                // Sort items by priority
                                                                usort($items, function($a, $b) {
                                                                    return $a['priority'] <=> $b['priority'];
                                                                });
                                                            @endphp

                                                            @foreach($items as $item)
                                                                <tr class="trdb table-row"
                                                                    id="trdb{{ $item['id'] }}" draggable="true"
                                                                    ondragstart="dragStart(event)"
                                                                    ondrop="drop(event)"
                                                                    ondragover="allowDrop(event)">
                                                                    <td>
                                                                        <div class="">
                                                                            <img class="thumb-preview wf-150"
                                                                                 src="{{ asset('assets/admin/img/car-gallery/' . $item['image']) }}"
                                                                                 id="img_{{$item['id']}}"
                                                                                 alt="Ad Image"
                                                                                 style="height:120px; width:120px; object-fit: cover;transform: rotate({{$item['rotation_point']}}deg);">
                                                                        </div>

                                                                        <div style="text-align: center;margin-bottom: 5px;color: gray;">
                                                                            Set Cover <input
                                                                                    class='form-check-input'
                                                                                    value="{{ $item['id'] }}"
                                                                                    onclick="setCoverPhoto({{ $item['id'] }})"
                                                                                    type='radio'
                                                                                    name='flexRadioDefault'>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <i class="fa fa-times"
                                                                           onclick="removethis({{ $item['id'] }})"></i>
                                                                        <i class="fa fa-undo rotatebtndb"
                                                                           onclick="rotatePhoto({{ $item['id'] }})"></i>
                                                                    </td>

                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif


                                        <form action="{{ route('car.imagesstore') }}" id="my-dropzone"
                                              enctype="multipart/formdata"
                                              class="dropzone create us_dropzone ad-creation">
                                            @csrf
                                            <div class="fallback">
                                                <input name="file" type="file" multiple/>
                                            </div>
                                        </form>
                                        <p class="em text-danger mb-0" id="errslider_images"></p>
                                    </div>
                                    <div class="row">

                                        <div class="col-lg-12 ">


                                            <form class="myajaxform" id="carForm"
                                                  action="{{ route('vendor.car_management.store_car') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <div id="sliders">
                                                    @if(!empty($items) && count($items) > 0 )
                                                        @foreach($items as $itm)
                                                            <input type="hidden" name="slider_images[]"
                                                                   id="slider{{$itm['id']}}" value="{{$itm['id']}}">
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <input type="hidden" name="can_car_add" value="1">
                                                <input type="hidden" id="defaultImg" name="car_cover_image" value="">
                                                <div class="row" id="addTYAP">

                                                </div>
                                                <div id="accordion">
                                                    @foreach ($languages as $language)
                                                        <div class="">
                                                            <div id="collapse{{ $language->id }}"
                                                                 class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                                                                 aria-labelledby="heading{{ $language->id }}"
                                                                 data-parent="#accordion">
                                                                <div class="version-body">
                                                                      {{-- <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                          <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                                                              @php
                                                                                  $placeholder = 'What you are selling?';
                                                                                  if ($draft_ad && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Wanted') {
                                                                                      $placeholder = 'What you are looking for?';
                                                                                  }
                                                                              @endphp
                                                                              <label>{{ __('Ad Title') }} *</label>
                                                                              <input type="text" id="input-title" class="form-control"
                                                                                    onfocusout="saveDraftData(this , 'ad_title')"
                                                                                    value="@if($draft_ad == true && !empty($draft_ad->ad_title)) {{$draft_ad->ad_title}} @endif"
                                                                                    name="{{ $language->code }}_title"
                                                                                    placeholder="{{ $placeholder  }}">
                                                                              <span class="form-text">
                                                                              {{ __('Your ad title will be shown in search results') }}
                                                                          </span>
                                                                          </div>
                                                                      </div> --}}


                                                                    </div>
                                                                    {{-- <div class="row">
                                                                      <div class="col-md-6 mb-3">
                                                                          <div class="form-group">
                                                                              @php
                                                                                  $categories = App\Models\Car\Category::where('parent_id', 0)->where('status', 1)->get();
                                                                              @endphp
                                                                              <label>{{ __('Category') }} *</label>
                                                                              <select name="en_main_category_id"
                                                                                      class="form-control select2"
                                                                                      id="adsMaincat"
                                                                                      onchange="fetchSubCategories(this)">
                                                                                  <option selected disabled>{{ __('Select a Category') }}</option>
                                                                                  @foreach ($categories as $category)
                                                                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                  @endforeach
                                                                              </select>
                                                                          </div>
                                                                      </div>

                                                                      <div class="col-md-6 sub_sub_sub_category mb-3" id="sub_catgry" style="display: none;">
                                                                          <div class="form-group">
                                                                              <label>{{ __('Select a Sub Category') }} *</label>
                                                                              <select disabled name="en_category_id" class="form-control subhidden" id="adsSubcat">
                                                                                  <option selected disabled>{{ __('Select Sub Category') }}</option>
                                                                              </select>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                    <script>
                                                                      function fetchSubCategories(selectElement) {
                                                                            var categoryId = selectElement.value;

                                                                            // Check if a category is selected
                                                                            if (categoryId) {
                                                                                // Show the subcategory dropdown
                                                                                $('#sub_catgry').show();

                                                                                // Disable the subcategory dropdown initially
                                                                                $('#adsSubcat').prop('disabled', false);

                                                                                // Make an AJAX request to fetch subcategories
                                                                                $.ajax({
                                                                                    url: '/get-subcategories/' + categoryId,
                                                                                    type: 'GET',
                                                                                    dataType: 'json',
                                                                                    success: function(response) {
                                                                                        // Clear previous options
                                                                                        $('#adsSubcat').empty();
                                                                                        $('#adsSubcat').append('<option selected disabled>{{ __("Select Sub Category") }}</option>');

                                                                                        // Add the new subcategories
                                                                                        $.each(response, function(index, subcategory) {
                                                                                            $('#adsSubcat').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                                                                                        });
                                                                                    },

                                                                                });
                                                                            } else {
                                                                                // If no category is selected, hide subcategory dropdown
                                                                                $('#sub_catgry').hide();
                                                                                $('#adsSubcat').prop('disabled', true);
                                                                            }
                                                                        }

                                                                        $(document).ready(function() {
                                                                            $('#adsMaincat').select2({
                                                                                placeholder: "Search and select a category",
                                                                                allowClear: true
                                                                            });
                                                                        });

                                                                    </script> --}}
                                                                    <div class="row">
                                                                        <div class="col-md-6 mb-3">
                                                                            <div class="form-group ">
                                                                                @php
                                                                                    $categories = App\Models\Car\Category::where('parent_id', 0)->where('status', 1)
                                                                                          ->get();
                                                                                @endphp
                                                                                <label>{{ __('Category') }} *</label>
                                                                                <select name="en_main_category_id"
                                                                                        class="form-control select2 @error('category_id') is-invalid @enderror"
                                                                                        id="adsMaincat"
                                                                                        onchange="saveDraftData(this , 'category_id')">
                                                                                    <option selected
                                                                                            disabled>{{ __('Select a Category') }}</option>
                                                                                    @foreach ($categories as $category)
                                                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                @error('category_id')
                                                                                <span class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                                  <script>
                                                                                    $(document).ready(function () {
                                                                                        $('#adsMaincat').select2({
                                                                                            placeholder: "Search and select a category",
                                                                                            allowClear: true
                                                                                        });
                                                                                    });
                                                                                </script>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 sub_sub_sub_category mb-3" id="sub_catgry">
                                                                            <div class="form-group">
                                                                                <label>{{ __('Select a Sub Category') }}
                                                                                    *</label>
                                                                                <select disabled name="en_category_id"
                                                                                        class="form-control  subhidden"
                                                                                        id="adsSubcat"
                                                                                        onchange="saveDraftData(this , 'sub_category_id')">
                                                                                    <option selected
                                                                                            disabled>{{ __('Select Sub Category') }}</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 mb-3">
                                                                      <div class="form-group">
                                                                          <div class="form-check form-check-inline">
                                                                              <label class="form-check-label" for="inlineRadio3">Ad
                                                                                  Type</label>
                                                                          </div>
                                                                          <div class=" align-items-center d-flex">
                                                                              <div class="form-check form-check-inline">
                                                                                  <input class="form-check-input" type="radio"
                                                                                         name="ad_type" id="inlineRadio1"
                                                                                         @if($draft_ad == true && empty($draft_ad->ad_type) ) checked
                                                                                         @endif @if($draft_ad == true && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Sale') checked
                                                                                         @endif onchange="saveDraftData(this , 'ad_type')"
                                                                                         value="Sale">&nbsp;
                                                                                  <label class="form-check-label" for="ad_type">For
                                                                                      Sale</label>

                                                                              </div>
                                                                              <div class="form-check form-check-inline">
                                                                                  <input class="form-check-input" type="radio"
                                                                                         name="ad_type" id="inlineRadio2"
                                                                                         @if($draft_ad == true && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Wanted') checked
                                                                                         @endif  onchange="saveDraftData(this , 'ad_type')"
                                                                                         value="Wanted">&nbsp;
                                                                                  <label class="form-check-label"
                                                                                         for="ad_type">Wanted</label>
                                                                              </div>
                                                                          </div>

                                                                      </div>
                                                                  </div><hr/>
                                                                  <h4 style="color:gray">Videos </h4>
                                                                  <div class="col-lg-6 mb-3">
                                                                    <div class="form-group">
                                                                        <label>{{ __('Optional YouTube Video') }} </label>
                                                                        <input type="text" class="form-control @error('youtube_video') is-invalid @enderror"
                                                                               name="youtube_video"
                                                                               placeholder="Enter youtube Video URL">
                                                                               @error('youtube_video')
                                                                                  <span class="invalid-feedback" role="alert">
                                                                                      <strong>{{ $message }}</strong>
                                                                                  </span>
                                                                              @enderror
                                                                    </div>
                                                                </div>
                                                                <hr/>
                                                                <h4 style="color:gray">Ad Details </h4>

                                                                 <div class="row">
                                                                        <div class="col-md-12 mb-3">
                                                                          <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                                                              @php
                                                                                  $placeholder = 'What you are selling?';
                                                                                  if ($draft_ad && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Wanted') {
                                                                                      $placeholder = 'What you are looking for?';
                                                                                  }
                                                                              @endphp
                                                                              <label>{{ __('Ad Title') }} *</label>
                                                                              <input type="text" id="input-title" class="form-control "
                                                                                    onfocusout="saveDraftData(this , 'ad_title')"
                                                                                    value="@if($draft_ad == true && !empty($draft_ad->ad_title)) {{$draft_ad->ad_title}} @endif"
                                                                                    name="{{ $language->code }}_title"
                                                                                    placeholder="{{ $placeholder  }}">
                                                                              <span class="form-text">
                                                                              {{ __('Your ad title will be shown in search results') }}
                                                                          </span>
                                                                          </div>
                                                                      </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12 mb-3">
                                                                            <div class="form-group {{ $language->direction == 1 ? 'rtl text-right' : '' }}">
                                                                                <label>{{ __('Description') }} *</label>
                                                                                <textarea
                                                                                        id="{{ $language->code }}_description"
                                                                                        onfocusout="saveDraftData(this , 'ad_description')"
                                                                                        class="form-control "
                                                                                        name="{{ $language->code }}_description"
                                                                                        data-height="500"
                                                                                        style="height: 300px;"
                                                                                        placeholder="Tell us a bit more about your ad, giving us as much information as possible to help sell your items">@if($draft_ad == true && !empty($draft_ad->ad_description)){{$draft_ad->ad_description}}@endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                       <div class="col-lg-6 d-flex align-items-center">
                                                                          <div class="form-group flex-grow-1 mr-2">
                                                                              <label>{{ __('Price') }}*</label>
                                                                              <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="ad_price"
                                                                                     onfocusout="saveDraftData(this, 'price')"
                                                                                     value="@if($draft_ad == true && !empty($draft_ad->price)) {{$draft_ad->price}} @endif"
                                                                                     placeholder="Enter Price in  &pound;">@error('price')
                                                                                     <p class="invalid-feedback">{{$message}}</p>

                                                                                     @enderror
                                                                          </div>&nbsp;

                                                                      </div>


                                                                        {{-- <div class="col-lg-6 mb-3">
                                                                            <div class="form-group">
                                                                                <label>{{ __('Optional YouTube Video') }} </label>
                                                                                <input type="text" class="form-control"
                                                                                       name="youtube_video"
                                                                                       placeholder="Enter youtube Video URL">
                                                                            </div>
                                                                        </div> --}}
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col">
                                                                        @php $currLang = $language; @endphp

                                                                        @foreach ($languages as $language)
                                                                            @continue($language->id == $currLang->id)

                                                                            <div class="form-check py-0">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                           type="checkbox"
                                                                                           onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                                                                    <span class="form-check-sign">{{ __('Clone for') }} <strong
                                                                                                class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                      {{ __('language') }}</span>
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="searcfilters" class="row">
                                        </div>
                                        <div id="searcfiltersdata" class="row">
                                        </div>
                                        <hr class="mt-3">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-8 ">
                                                        <div class="form-group">
                                                            <h4 style="color:gray">{{ __('Contact Details') }} </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ __('Full Name') }}*</label>
                                                    <input type="text" class="form-control" name="full_name"
                                                           value="{{ $vendor->vendor_info->name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>{{ __('Email') }}*</label>
                                                    <input type="text" value="{{ $vendor->email }}" class="form-control"
                                                           name="email" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <label style="margin-top: 5px;margin-left: 10px;font-size: 21px;color: #7b7b7b;">{{ __('Phone') }}*</label>
                                                <div class="form-group input-group" style="margin-top: 10px;">

                                                    <div class="d-flex col-lg-12" style="    margin-top: -12px;">
                                                         <div class="custom-select">
                                                             <div class="select-selected bg-light">

                                                                @php
                                                                    $ct = $country_codes->firstWhere('country', 'United Kingdom');

                                                                    $flagUrl = $ct->flag_url;
                                                                    $flagcode = $ct->code;
                                                                    $s_code = $ct->short_code;

                                                                    if(!empty($vendor->country_code))
                                                                    {
                                                                        $ct = $country_codes->firstWhere('code', $vendor->country_code);

                                                                        $flagUrl = $ct->flag_url;
                                                                        $flagcode = $ct->code;
                                                                        $s_code = $ct->short_code;

                                                                    }

                                                                @endphp
                                                                <img src="{{ $flagUrl }}" alt="UK Flag" class="flag">
                                                                <span class="short_code"> {{$s_code}} </span>
                                                                ({{ $flagcode }})
                                                            </div>
                                                             <div class="select-items select-hide" style="display: none;">
                                                                <div class="search-box">
                                                                    <input type="text" id="country-search"
                                                                           placeholder="Search country...">
                                                                </div>
                                                                @foreach($country_codes as $country)
                                                                    <div class="country-option"
                                                                         data-value="{{ $country->code }}"
                                                                         data-flag="{{ $country->flag_url }}">
                                                                        <img src="{{ $country->flag_url }}"
                                                                             alt="{{ $country->country }}" class="flag">
                                                                        <span class="short_code">  {{$country->short_code}} </span>
                                                                        <span style="display:none;">{{$country->country}}</span>
                                                                        ({{ $country->code }})
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                         </div>

                                                        <input type="hidden" name="c_code" id="c_code"
                                                               value="{{ !empty(Auth::guard('vendor')->user()->country_code) ? Auth::guard('vendor')->user()->country_code : '+44' }}"/>
                                                               {{-- <input value="{{ old('phone', $vendor->phone) }}" class="form-control" readonly> --}}

                                                        <input type="number" value="{{ $vendor->phone }}"
                                                               style="height: 40px;margin-top: 10px;    margin-right: 5px;"
                                                               class="form-control" name="phone" required readonly>


                                                         @if ($vendor->phone_verified == 1)
                                                            <button disabled class="btn  btn-success2" style="    height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                        @else
                                                            <button id="verifyPhone" class="btn btn-outline-secondary"
                                                                    style="height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button" title="verify"><i class='fas fa-fingerprint'></i></button>
                                                        @endif

                                                    </div>

                                                    <small style="margin-top: 8px;">Verify your phone number and help
                                                        reduce fraud and scams on Listit</small>
                                                    <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
<br/>
                                                <div class="form-group checkbox-xl row">
                                                    <div><label>{{ __('Allow contact by') }}</label></div>
                                                    <div class="col-lg-6">

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="message_center" id="inlineRadio1" value="yes"
                                                                   required checked>
                                                            <label class="form-check-label"
                                                                   for="message_center">Message </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="phone_text" id="inlineRadio2" value="yes"
                                                                   checked>
                                                            <label class="form-check-label" for="message_center">Phone/Text</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div><br/>
                                            <hr/>

                                            <div class="col-lg-6" style="display:none;">
                                                <div class="form-group">
                                                    <label>{{ __('Area') }}</label>
                                                    <input id="packageId" type="hidden" name="package_id" value="">
                                                    <input id="promoStatus" type="hidden" name="promo_status" value="0">
                                                    <select name="city" id="" class="form-control">
                                                        <option value="">Please select...</option>
                                                        @foreach ($countryArea as $area)
                                                            <option value="{{ $area->slug }}" {{ $area->slug == $vendor->vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none;">
                                                <div class="col-lg-8 col-sm-12 col-md-12">
                                                    <div class="form-group checkbox-xl">
                                                        <div><label>{{ __('Are you a professional trader?') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">

                                                            <input class="form-check-input traderradio" type="checkbox"
                                                                   name="traderstatus" id="inlineRadio1"
                                                                   @if ($vendor->trader == 1) checked @endif>
                                                            <label class="form-check-label" for="message_center">Yes,
                                                                I'm a trader</label>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="trader">
                                                <div class="col-lg-12 chkbox"
                                                     @if ($vendor->trader == 0) style="display: none;" @endif>
                                                    <div class="form-group ">
                                                        <label>{{ __('Business Name*') }} </label>
                                                        <input type="text"
                                                               value="{{ $vendor->vendor_info->business_name }}"
                                                               class="form-control" name="business_name">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 chkbox"
                                                     @if ($vendor->trader == 0) style="display: none;" @endif>
                                                    <div class="form-group ">
                                                        <label>{{ __('Business Address') }} </label>
                                                        <textarea id="" class="form-control "
                                                                  name="business_address"
                                                                  data-height="300">{{ $vendor->vendor_info->business_address }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 chkbox"
                                                     @if ($vendor->trader == 0) style="display: none;" @endif>
                                                    <label style="margin-left:8px; font-size: 1.2rem; color: #0d0c1b;">{{ __('VAT Number') }}</label>
                                                    <div class="form-group input-group">

                                                        <input type="text"
                                                               value="{{ $vendor->vendor_info->vat_number }}"
                                                               class="form-control" name="vat_number">
                                                        @if ($vendor->vendor_info->vatVerified == 1)
                                                            <button disabled title="Verified" class="btn btn-success2"
                                                                    type="button"><i class='fa fa-check-circle fa-lg'
                                                                                     aria-hidden='true'></i></button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div id="payplans" class="row">


                                            </div>

                                            <div id="packageSelected" class="row">

                                            </div>


                                            </form>
                                            {{-- <div class="col-lg-12">
                                                <label for="" class="mb-2"><strong>{{ __('Gallery Images') }}
                                                        **</strong> <br> <small class="text-danger"> load up to <span
                                                                id="change_text_photo_allow">15</span> images .jpg,
                                                        .png, & .gif </small></label>

                                                @if($draft_ad == true && !empty($draft_ad->images))
                                                    @php
                                                        $images = json_decode($draft_ad->images, true);
                                                        $items = [];
                                                    @endphp

                                                    @if(count($images) > 0)
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <table class="table table-striped" id="imgtable">
                                                                    @foreach($images as $image)
                                                                        @php
                                                                            $item = \App\Models\Car\CarImage::where('image', $image)->first();
                                                                        @endphp

                                                                        @if($item)
                                                                            @php
                                                                                $items[] = [
                                                                                    'id' => $item->id,
                                                                                    'image' => $item->image,
                                                                                    'rotation_point' => $item->rotation_point,
                                                                                    'priority' => $item->priority,
                                                                                ];
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach

                                                                    @php
                                                                        // Sort items by priority
                                                                        usort($items, function($a, $b) {
                                                                            return $a['priority'] <=> $b['priority'];
                                                                        });
                                                                    @endphp

                                                                    @foreach($items as $item)
                                                                        <tr class="trdb table-row"
                                                                            id="trdb{{ $item['id'] }}" draggable="true"
                                                                            ondragstart="dragStart(event)"
                                                                            ondrop="drop(event)"
                                                                            ondragover="allowDrop(event)">
                                                                            <td>
                                                                                <div class="">
                                                                                    <img class="thumb-preview wf-150"
                                                                                         src="{{ asset('assets/admin/img/car-gallery/' . $item['image']) }}"
                                                                                         id="img_{{$item['id']}}"
                                                                                         alt="Ad Image"
                                                                                         style="height:120px; width:120px; object-fit: cover;transform: rotate({{$item['rotation_point']}}deg);">
                                                                                </div>

                                                                                <div style="text-align: center;margin-bottom: 5px;color: gray;">
                                                                                    Set Cover <input
                                                                                            class='form-check-input'
                                                                                            value="{{ $item['id'] }}"
                                                                                            onclick="setCoverPhoto({{ $item['id'] }})"
                                                                                            type='radio'
                                                                                            name='flexRadioDefault'>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <i class="fa fa-times"
                                                                                   onclick="removethis({{ $item['id'] }})"></i>
                                                                                <i class="fa fa-undo rotatebtndb"
                                                                                   onclick="rotatePhoto({{ $item['id'] }})"></i>
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif


                                                <form action="{{ route('car.imagesstore') }}" id="my-dropzone"
                                                      enctype="multipart/formdata"
                                                      class="dropzone create us_dropzone">
                                                    @csrf
                                                    <div class="fallback">
                                                        <input name="file" type="file" multiple/>
                                                    </div>
                                                </form>
                                                <p class="em text-danger mb-0" id="errslider_images"></p>
                                            </div> --}}

                                            <form class="myajaxform" id="carForm"
                                                  action="{{ route('vendor.car_management.store_car') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                <div class="col-lg-12">

                                                    <div class="form-group text-center d-flex justify-content-end">

                                                        <p class="col-lg-7 text-start">
                                                            By clicking "<b>Sell Now</b>", you agree to the Listit
                                                            <a href="https://listit.eegc.in/terms-&-condition"
                                                               target="_blank" class="text-primary">Terms and
                                                                Conditions</a>.
                                                            <a href="#" target="_blank" class="text-primary">Read
                                                                More</a> about payment options.
                                                        </p>
                                                        <div class="col-lg-4">
                                                            <button type="button">Preview Ad</button>&nbsp;
                                                            <button type="submit" id="CarSubmit"
                                                                    data-can_car_add="{{ $can_car_add }}"
                                                                    class="btn btn-success btn-lg btn-block ">
                                                                @if($draft_ad == true && !empty($draft_ad->ad_type) && $draft_ad->ad_type == 'Wanted')
                                                                    Publish Now
                                                                @else
                                                                    {{ __('Sell Now') }}
                                                                @endif

                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="max_file_upload" name="max_file_upload"
                                                       value="50"/>
                                        </div>
                                        </form>


                                    </div>
                                </div>

                            </div>
                            <div class="">
                                <button type="submit" class="text-primary">Reset Form</button>
                            </div>


                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 text-center">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>





    <div class="modal fade" id="vintageYearAlertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: none;    padding-bottom: 0;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white">Modal title</h5>
                    <button type="button" class="close" onclick="closeModal()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-top: inherit;margin-bottom: 1rem;">
                    <div id="apendHTML"></div>
                </div>

            </div>
        </div>
    </div>



    <div class="modal fade" id="draftModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <h5>
                        <i class="fa fa-info-circle" aria-hidden="true" style="color: #367ede;font-size: 25px;"></i>
                        <span style="position: relative;bottom: 3px;font-size: 17px;left: 5px;color:#585858;">
                   You have a draft ad
               </span>

                        <a href="javascript:void(0);" class="btn btn-success" onclick="hidePanel()" style="background: white !important;
                color: black;
                text-align: right;
                float: right;
                height: 0px;
                position: relative;
                bottom: 5px;
                padding-right: 0px;">
                            <i class="fa fa-times" style="font-size: 18px;color:#585858;" aria-hidden="true"></i>
                        </a>


                    </h5>

                    <div style="margin-bottom: 1rem;margin-top: 1rem;color:gray">
                        We've saved some details from the last time you started placing as ad.
                    </div>

                    <div style="display:flex;">
                        <button type="button" class="btn btn-secondary" style="    padding: 5px;
    margin-right: 5px;
    width: 100%;
    color: black;
    background: white !important;
    border: 1px solid #000000 !important;
    font-size: 11px;" onclick="deletDarftAd()"> Start new ad
                        </button>
                        <button type="button" class="btn btn-primary" style="    padding: 5px;
    margin-left: 5px;
    width: 100%;
    font-size: 11px;" onclick="hidePanel()">Continue ad
                        </button>
                    </div>


                </div>

            </div>
        </div>
    </div>

@endsection
@php
    $languages = App\Models\Language::get();
    $labels = '';
    $values = '';
    foreach ($languages as $language) {
        $label_name = $language->code . '_label[]';
        $value_name = $language->code . '_value[]';
        if ($language->direction == 1) {
            $direction = 'form-group rtl text-right';
        } else {
            $direction = 'form-group';
        }

        $labels .= "<div class='$direction'><input type='text' name='" . $label_name . "' class='form-control' placeholder='Label ($language->name)'></div>";
        $values .= "<div class='$direction'><input type='text' name='$value_name' class='form-control' placeholder='Value ($language->name)'></div>";
    }
@endphp

@section('script')

    @if($draft_ad == true)

        <script>

            function hidePanel() {
                $('#draftModal').remove();

                $('body').css('overflow', 'auto');

                $('body').css('padding', '0px');
            }


            $(document).ready(function () {
                // Show the modal on page load
                $('#draftModal').modal('show');

                // Prevent modal from closing when clicking outside or pressing Esc key
                $('#draftModal').on('hide.bs.modal', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                });

                @if($draft_ad == true && !empty($draft_ad->category_id))
                var selectedOption = "{{ $draft_ad->category_id }}";
                $('#adsMaincat').val(selectedOption);
                $('#adsMaincat').change()
                @endif

            });

        </script>
    @endif

    {{-- dropzone css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

    {{-- atlantis css --}}

    {{-- select2 css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
    {{-- admin-main css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">
    <style type="">
        #carForm .form-control {
            display: block;
            width: 100%;
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem !important;
            font-size: 16px !important;
            font-weight: 400;
            line-height: 1.3 !important;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            background-image: none !important;
        }

        option {
            padding: 0px 8px 8px;
        }

        .form-check [type="checkbox"]:not(:checked), .form-check [type="checkbox"]:checked {

            left: inherit !important;
        }

        #carForm .btn-secondary {
            line-height: 16px !important;
            left: -4px;
        }

        .customRadio {
            width: 1.2em !important;
            height: 1.2em !important;
            border-color: #b1b1b1 !important;
            margin-right: 4px !important;
        }

        .customRadiolabel {
            margin-top: 3px !important;
            font-size: 14px;
            font-weight: 600;
        }

        .dropzone .dz-preview:hover .dz-image img {
            -webkit-transform: scale(1.05, 1.05);
            -moz-transform: scale(1.05, 1.05);
            -ms-transform: scale(1.05, 1.05);
            -o-transform: scale(1.05, 1.05);
            transform: scale(1.05, 1.05);
            -webkit-filter: blur(8px);
            filter: blur(0px);
        }

        .checkbox-xl .form-check-input {
            scale: 1.5;

        }

        .checkbox-xl .form-check-label {
            padding-left: 25px;


        }

        .form-check .form-check-input {
            margin-left: .0em !important;
            margin-top: 5px;
        }

        .btn-success2 {
            background: #28a745 !important;
            border-color: #28a745 !important;
        }

        button.rotate-btn {
            font-size: 12px;
            position: absolute;
            top: 40px;
            right: 10px;
            z-index: 30;
            border-radius: 5px;
            background-color: #004eabd6;
            color: #fff;
            outline: 0;
            border: none;
            cursor: pointer !important;
        }

        .rotatebtndb {

            top: 30px !important;

            color: #004eabd6 !important;

            cursor: pointer !important;
        }


        #payplans {
            padding: 15px 15px 15px 15px;
        }

        .card-pricing-vendor {
            padding-bottom: 10px;
            background: #fff !important;
            text-align: center;
            overflow: hidden;
            position: relative;
            border-radius: 5px;
            -webkit-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
            -moz-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
            box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
            min-height: 400px;
        }

        .pricing-content-align {
            min-height: 133px;
        }

        .price-rcomm {
            background-color: rgb(0, 170, 255);
            padding: 5px;
            color: #fff;
            font-size: 14px;
        }


        /* Ensure the modal backdrop covers everything */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1040; /* Set a high z-index */
        }

        /* Modal container */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Fixed position */
            z-index: 1050; /* Set a higher z-index than the backdrop */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent background */
            transition: opacity 0.3s ease;
            opacity: 0; /* Start with the modal invisible */
        }

        /* Modal content */
        .modal-content {
            background-color: white;
            margin: 15% auto;

            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Show the modal with fading effect */
        .modal.show {
            display: block;
            opacity: 1; /* Fully opaque when shown */
        }

        .form-group label, .form-check label {
            color: gray !important;
        }

        #searcfilters h3 {
            color: gray !important;
        }

        #payplans h4, h2 {
            color: gray !important;
        }


        @media (max-width: 1280px) {
            .custom-col-ad {
                /* border: 1px solid red !important; */
            }
        }

        @media (max-width: 1200px) {
            .custom-col-ad {
                /* border: 1px solid green !important; */
                width: 50%;
            }
        }

        @media (max-width: 1024px) {
            .custom-col-ad {
                /* border: 1px solid blue !important; */
                width: 50%;
            }
        }

        @media (max-width: 991px) {
            .custom-col-ad {
                width: 100%;
                /* border: 1px solid purple !important; */
            }
        }

        @media (max-width: 768px) {
            .custom-col-ad {
                /* border: 1px solid orange !important; */
                width: 100%;
            }
        }

        @media (max-width: 575px) {
            .custom-col-ad {
                /* width:98%; */
                /* border: 1px solid yellow !important; */
            }
        }

    </style>
    <script>
        'use strict';

        const baseUrl = "{{ url('/') }}";
    </script>

    {{-- core js files --}}



    {{-- jQuery ui --}}
    <script type="text/javascript" src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>

    {{-- jQuery time-picker --}}
    <script type="text/javascript" src="{{ asset('assets/js/jquery.timepicker.min.js') }}"></script>

    {{-- jQuery scrollbar --}}
    <script type="text/javascript" src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>

    {{-- bootstrap notify --}}
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-notify.min.js') }}"></script>

    {{-- sweet alert --}}
    <script type="text/javascript" src="{{ asset('assets/js/sweet-alert.min.js') }}"></script>

    {{-- bootstrap tags input --}}
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagsinput.min.js') }}"></script>

    {{-- bootstrap date-picker --}}
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    {{-- js color --}}
    <script type="text/javascript" src="{{ asset('assets/js/jscolor.min.js') }}"></script>

    {{-- fontawesome icon picker js --}}
    <script type="text/javascript" src="{{ asset('assets/js/fontawesome-iconpicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>

    {{-- datatables js --}}
    <script type="text/javascript" src="{{ asset('assets/js/datatables-1.10.23.min.js') }}"></script>

    {{-- datatables bootstrap js --}}
    <script type="text/javascript" src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>


    {{-- dropzone js --}}
    <script type="text/javascript" src="{{ asset('assets/js/dropzone.min.js') }}"></script>

    {{-- atlantis js --}}
    <script type="text/javascript" src="{{ asset('assets/js/atlantis.js') }}"></script>

    {{-- fonts and icons script --}}
    <script type="text/javascript" src="{{ asset('assets/js/webfont.min.js') }}"></script>



    @if (session()->has('warning'))
        <script>
            'use strict';
            var content = {};

            content.message = '{{ session('warning') }}';
            content.title = 'Warning!';
            content.icon = 'fa fa-bell';

            $.notify(content, {
                type: 'warning',
                placement: {
                    from: 'top',
                    align: 'right'
                },
                showProgressbar: true,
                time: 1000,
                delay: 4000
            });
        </script>
    @endif

    {{-- select2 js --}}
    <script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

    {{-- admin-main js --}}
    <script type="text/javascript" src="{{ asset('assets/js/admin-main.js') }}"></script>


    <script>

        function closeModal() {
            $('#vintageYearAlertModal').modal('hide')
        }

        function checkYearAgo(self) {
            var year = $(self).val();

            if (year.length === 4 && !isNaN(year)) {
                var currentYear = new Date().getFullYear();

                var yearDifference = currentYear - parseInt(year, 10);

                if (yearDifference >= 30) {
                    $('#vintageYearAlertModal').modal('show')
                    $('#apendHTML').html('This vehicle  reg over ' + yearDifference + ' years ago. So this will be added to the vintage section. All The ads over 30 years ago will be added to vintage section.');
                }
            }
        }


        'use strict';
        var storeUrl = "{{ route('car.imagesstore') }}";
        var removeUrl = "{{ route('user.car.imagermv') }}";
        var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
        const account_status = "{{ Auth::guard('vendor')->user()->status }}";
        const secret_login = "{{ Session::get('secret_login') }}";


        var rotationAngle1 = 0;

        function rotatePhoto(id) {
            // Find the image element within the file preview element
            var imageElement = $('#img_' + id);


            if (imageElement.length) {
                // Increment the rotation angle by 90 degrees
                rotationAngle1 += 90;

                // Apply the rotation to the image element
                imageElement.css('transform', 'rotate(' + rotationAngle1 + 'deg)');

                // Reset rotation to 0 if it reaches 360 degrees
                if (rotationAngle1 === 360) {
                    rotationAngle1 = 0;
                }

                rotationSave(id, rotationAngle1);
            }

            return false;
        }


        function rotationSave(fileid, rotationEvnt) {
            var requestMethid = "POST";

            if ($('#request_method').val() != '') {
                var requestMethid = "GET";
            }

            $.ajax({
                url: '/customer/ad-management/img-db-rotate',
                type: requestMethid,
                data: {
                    fileid: fileid, rotationEvnt: rotationEvnt
                },
                success: function (data) {

                }
            });
        }

        function removethis(fileid) {
            $.ajax({
                url: removeUrl,
                type: 'POST',
                data: {
                    fileid: fileid
                },
                success: function (data) {
                    $("#slider" + fileid).remove();
                    $('#trdb' + fileid).remove()
                }
            });
        }

    </script>

    <script src="{{ asset('assets/js/car.js?v=9.6') }}"></script>
    <script>
        var labels = "{!! $labels !!}";
        var values = "{!! $values !!}";
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js?v=0.2') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js?v=0.9') }}"></script>

@endsection
