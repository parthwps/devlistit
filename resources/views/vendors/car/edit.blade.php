@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Ads') }}
  @else
    {{ __('Ads') }}
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
'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Ads'),
])

@php
$carContent = App\Models\Car\CarContent::where('car_id', $car->id)->first();
$categories = App\Models\Car\Category::where('id', $carContent->category_id)->first();

@endphp
<div class="user-dashboard pt-20 pb-60">
    <div class="container">

  <div class="row gx-xl-5">

       @includeIf('vendors.partials.side-custom')
  <div class="col-md-9">


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">{{ __('Edit Ad') }}</div>
          <a style="float: right;" class="btn btn-info btn-sm float-right d-inline-block"
            href="{{ route('vendor.car_management.car', ['language' => $defaultLang->code]) }}">
            <span class="btn-label">
              <i class="fas fa-backward"></i>
            </span>
            {{ __('Back') }}
          </a>
          @php
            $dCarContent = App\Models\Car\CarContent::where('car_id', $car->id)
                ->where('language_id', $defaultLang->id)
                ->first();
          @endphp
          <a style="float: right;margin-right: 1rem;" class="mr-2 btn btn-success btn-sm float-right d-inline-block"
            href="{{ route('frontend.car.details', ['cattitle' => catslug($dCarContent->category_id), 'slug' => $dCarContent->slug, 'id' => $car->id]) }}" target="_blank">
            <span class="btn-label">
              <i class="fas fa-eye"></i>
            </span>
            {{ __('Preview') }}
          </a>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger pb-1 dis-none" id="carErrors">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul></ul>
              </div>

              <div class="col-lg-12">
                <label for="" class="mb-2"><strong>{{ __('Gallery Images') }} **</strong> <br> <small class="text-danger">load up to {{$car->package ? $car->package->photo_allowed : 15 }} images .jpg, .png, & .gif</small> </label>
                <div class="row">
                  <div class="col-12">
                    @php
                // Sort galleries by priority
                $sortedGalleries = $car->galleries->sortBy('priority');

                // Extract the feature image
                $featureImage = $sortedGalleries->firstWhere('image', $car->feature_image);

                // Remove the feature image from the sorted galleries
                if ($featureImage) {
                $sortedGalleries = $sortedGalleries->reject(function($item) use ($featureImage) {
                return $item->id === $featureImage->id;
                });

                // Prepend the feature image to the sorted galleries
                $sortedGalleries->prepend($featureImage);
                }
                @endphp

                <table class="table table-striped" id="imgtable">
                @foreach ($sortedGalleries as $item)
                <tr class="trdb table-row" id="trdb{{$item->id}}">
                <td>
                <div class="">
                    <img class="thumb-preview wf-150"
                         src="{{ asset('assets/admin/img/car-gallery/' . $item->image) }}"
                         id="img_{{$item->id}}"
                         alt="Ad Image"
                         style="height: 120px;width:120px; object-fit: cover; transform: rotate({{$item->rotation_point}}deg);">
                </div>
                @if ($item->image != $car->feature_image)
                    <div style="text-align: center; margin-bottom: 5px; color: gray;">
                        Set Cover  <input class='form-check-input' value="{{ $item['id'] }}" onclick="setCoverPhoto({{ $item['id'] }})" type='radio' name='flexRadioDefault'>
                    </div>
                @endif
                </td>

                <td>
                <i class="fa fa-times" onclick="removethis({{ $item->id }})"></i>
                <i class="fa fa-undo rotatebtndb" onclick="rotatePhoto({{ $item->id }})"></i>
                @if ($item->image == $car->feature_image)
                    <label class="cover_label">Cover photo</label>
                @endif
                </td>
                </tr>
                @endforeach
                </table>

                  </div>
                </div>
                <form action="{{ route('vendor.car.imagesstore') }}" id="my-dropzone" enctype="multipart/formdata"
                  class="dropzone create us_dropzone ">
                  @csrf
                  <div class="fallback">
                    <input name="file" type="file" multiple />
                  </div>
                  <input type="hidden" value="{{ $car->id }}" name="car_id">
                </form>
                <p class="em text-danger mb-0" id="errslider_images"></p>
              </div>

              <form id="carForm" action="{{ route('vendor.car_management.update_car', $car->id) }}" method="POST"
                enctype="multipart/form-data" >
                @csrf
                <input type="hidden" name="car_id" value="{{ $car->id }}">
                <input type="hidden" name="can_car_add" value="1">
                <input type="hidden" id="defaultImg" name="car_cover_image" value="">



                @if($car->car_content->main_category_id == 24 && !empty($car->car_content->brand_id))

                    @if (in_array('make', json_decode($categories->filters)))
                        <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group">
                            <h3>{{ __('Vehicle Details') }} </h3>

                              </div>
                          </div>
                        </div>
                    @endif

                <div class="row">
                    @if (in_array('make', json_decode($categories->filters)))

                     @php
                        $brands = App\Models\Car\Brand::where('id', $carContent->brand_id)->first();
                    @endphp

                    @if($brands == true)
                      <div class="col-lg-6 col-sm-6">
                        <div class="form-group editAdLabel">

                          <label>{{ __('Make:') }} </label>
                          <b>{{$brands->name}}</b>
                        </div>
                      </div>
                   @endif

                  @endif

                  @if (in_array('model', json_decode($categories->filters)))

                    @php
                        $models = App\Models\Car\CarModel::where('id', $carContent->car_model_id)->first();
                    @endphp

                    @if($models == true)
                      <div class="col-lg-6 col-sm-6">
                        <div class="form-group editAdLabel">

                          <label>{{ __('Model:') }} </label>
                          <b>{{$models->name}}</b>
                        </div>
                      </div>
                    @endif

                  @endif

                  @if (in_array('year', json_decode($categories->filters)))
                  @if(!empty($car->year))
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">
                      <label>{{ __('Year:') }} </label>
                      <b>{{$car->year}}</b>
                    </div>
                  </div>
                  @endif
                  @endif

                  @if (in_array('fuel_types', json_decode($categories->filters)))
                   @php
                     $fuel_types = App\Models\Car\FuelType::where('id', $carContent->fuel_type_id)->first();
                     @endphp
                     @if($fuel_types == true)
                  <div class="col-lg-6 col-sm-6">
                    <div class="form-group editAdLabel">

                      <label>{{ __('Fuel Type:') }} </label>
                      <b>{{$fuel_types->name}}</b>
                    </div>
                  </div>
                  @endif
                   @endif


             @if (in_array('engine', json_decode($categories->filters))  && !empty($fuel_types->id) &&  in_array($fuel_types->id , [14,15]) )
                <div class="col-lg-4">
                    <div class="form-group">
                    @php
                        $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
                    @endphp
                    <label>{{ __('Engine size (litres)') }} </label>
                    <select name="engineCapacity" id="engine_sizes" class="form-control" >
                        <option value="" >{{ __('Select') }}</option>
                        @foreach ($engine_sizes as $engine)
                         <option  value="{{ $engine->name }}"  @selected($engine->name == $car->engineCapacity)>{{ ($engine->name) }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                @else

                <div class="col-lg-4">
                    <div class="form-group">
                        <label>Engine size (KW) </label>

                        <input type="text" name="engineCapacity" value="{{$car->engineCapacity}}" class="form-control" />
                    </div>
                </div>
            @endif


                @if (in_array('transmision_type', json_decode($categories->filters)))
                <div class="col-lg-4"  @if( !empty($fuel_types->id) && !in_array($fuel_types->id , [14,15]) )  style="display:none;" @endif  >
                    <div class="form-group">
                        @php
                        $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
                            ->get();
                        @endphp

                        <label>{{ __('Transmission Type') }} </label>
                        <select name="transmission_type_id" class="form-control" id="transmissionType">
                        <option value="" >{{ __('Select') }}</option>

                        @foreach ($transmission_types as $transmission_type)
                            <option value="{{ $transmission_type->id }}" @selected($transmission_type->id == $carContent->transmission_type_id)>{{ $transmission_type->name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                @endif
                @if (in_array('body_type', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group">
                        @php
                        $body_types = App\Models\Car\BodyType::where('status', 1)->get();
                        @endphp
                        <label>{{ __('Body Type') }} </label>
                        <select name="body_type_id" id="bodyType" class="form-control">
                        @foreach ($body_types as $body_type)

                            <option value="{{ $body_type->id }}" @selected($body_type->id == $carContent->body_type_id)>{{ $body_type->name }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                </div>
                @endif
                @if (in_array('colour', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group ">
                    @php
                        $colour = App\Models\Car\CarColor::where('status', 1)->get();
                    @endphp

                    <label>{{ __('Colour') }} </label>
                    <select name="car_colour_id" class="form-control" id="carColour">
                        <option value="">{{ __('Select Colour') }}</option>

                        @foreach ($colour as $colour)
                        <option value="{{ $colour->id }}"  @selected($colour->id == $carContent->car_color_id)>{{ $colour->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                @endif
                @if (in_array('doors', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group">
                    <label>{{ __('Number of doors') }} </label>
                    <select name="doors"  class="form-control" id="carDoors" >
                    <option value="">Please select...</option>
                    <option value="2" @selected($car->doors == 2)>2</option>
                    <option value="3" @selected($car->doors == 3)>3</option>
                    <option value="4" @selected($car->doors == 4)>4</option>
                    <option value="5" @selected($car->doors == 5)>5</option>
                    <option value="6" @selected($car->doors == 6)>6</option>
                    <option value="7" @selected($car->doors == 7)>7</option>
                    <option value="8" @selected($car->doors == 8)>8</option>
                    </select>
                    </div>
                </div>
                @endif
                @if (in_array('seat_count', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group">
                    <label>{{ __('Seat count') }} </label>
                    <select name="seats" id="seats" class="form-control">
                    <option value="">Please select...</option>
                    <option value="2" @selected($car->seats == 2)>2</option>
                    <option value="3" @selected($car->seats == 3)>3</option>
                    <option value="4" @selected($car->seats == 4)>4</option>
                    <option value="5" @selected($car->seats == 5)>5</option>
                    <option value="6" @selected($car->seats == 6)>6</option>
                    <option value="7" @selected($car->seats == 7)>7</option>
                    <option value="8" @selected($car->seats == 8)>8</option>
                    </select>
                    </div>
                </div>
                @endif
                @if (in_array('power', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group ">


                    <label>{{ __('Power') }} </label>

                    <input type="number" class="form-control"  value="{{$car->power}}"   placeholder="Enter Power HP"  name="power"/>


                    </div>
                </div>
                @endif
                @if (in_array('battery', json_decode($categories->filters)) && !empty($fuel_types->id) &&  !in_array($fuel_types->id , [14,15]))
                <div class="col-lg-4">
                    <div class="form-group ">

                    <label>{{ __('Battery') }} </label>
                    <select name="battery" class="form-control" id="battery">
                        <option value="">{{ __('Select battery') }}</option>

                        <option value="">{{ __('Any') }}</option>
                        <option value="100" @selected($car->battery == 100)>100+ M</option>
                        <option value="200" @selected($car->battery == 200)>200+ M</option>
                        <option value="300" @selected($car->battery == 300)>300+ M</option>
                        <option value="400" @selected($car->battery == 400)>400+ M</option>
                        <option value="500" @selected($car->battery == 500)>500+ M</option>
                    </select>
                    </div>
                </div>
                @endif
                @if (in_array('owners', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group ">

                    <label>{{ __('Number of owners') }} </label>
                    <select id="owners" class="form-select form-control"  name="owners">
                        <option value="">{{ __('Any') }}</option>
                        <option value="1" @selected($car->owners == 1)>1</option>
                        <option value="2" @selected($car->owners == 2)>2</option>
                        <option value="3" @selected($car->owners == 3)>3</option>
                        <option value="4" @selected($car->owners == 4)>4</option>
                        <option value="5" @selected($car->owners == 5)>5</option>
                        <option value="6" @selected($car->owners == 6)>6</option>
                        <option value="7" @selected($car->owners == 7)>7</option>
                        <option value="8" @selected($car->owners == 8)>8</option>

                    </select>
                    </div>
                </div>
                @endif
                @if (in_array('road-tax', json_decode($categories->filters)))
                <div class="col-lg-4">
                    <div class="form-group ">

                    <label>{{ __('Annual road tax') }} </label>

                    <input type="number" class="form-control"  value="{{$car->road_tax}}"   placeholder="Enter annual road tax"  name="road_tax"/>


                    </div>
                </div>
                @endif



                @endif


                  @if(!empty($output))
                    {!!$output!!}
                @endif


                <div id="accordion" class="mt-3">
                  @foreach ($languages as $language)


                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>{{ __('Title*') }}</label>
                                <input type="text" class="form-control" name="{{ $language->code }}_title"
                                  placeholder="Enter Title" value="{{ $carContent ? $carContent->title : '' }}">
                              </div>
                            </div>

                            <!-- <div class="col-lg-3">
                              <div class="form-group ">
                                @php
                                  $categories = App\Models\Car\Category::where('language_id', $language->id)
                                      ->where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Category') }} *</label>
                                <select name="{{ $language->code }}_category_id"
                                  class="form-control js-example-basic-single2">
                                  <option selected disabled>{{ __('Select a Category') }}</option>

                                  @foreach ($categories as $category)
                                    <option
                                      {{ ($carContent ? $carContent->category_id : '' == $category->id) ? 'selected' : '' }}
                                      value="{{ $category->id }}">{{ $category->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div> -->


                          <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>{{ __('Description') }} *</label>
                                <textarea class="form-control" id="{{ $language->code }}_description"
                                  name="{{ $language->code }}_description" data-height="300" style="height: 300px;" >{{ $carContent ? $carContent->description : '' }}</textarea>
                              </div>
                            </div>
                          </div>
                          <div class="row">

                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>{{ __('Price') }} </label>
                              <input type="number" class="form-control" @if($carContent->main_category_id == 233 || $carContent->main_category_id == 347 ) readonly @endif name="previous_price" placeholder="Enter Previous Price"
                                value="{{ (!empty($car->previous_price)) ? $car->previous_price :  $car->price }}">
                            </div>
                            <div class="form-group" style="margin-top: 35px;">
                              <select class="form-control" name="sign">
                                  <option value="£" {{ old('sign', $draft_ad->sign ?? '£') == '£' ? 'selected' : '' }}>£</option>
                                  <option value="₹" {{ old('sign', $draft_ad->sign ?? '₹') == '₹' ? 'selected' : '' }}>₹</option>
                              </select>
                          </div>
                          </div>
                          <div class="col-lg-6 ">
                            <div class="form-group">
                              <label>{{ __('Optional YouTube Video') }} </label>
                                 <input type="text" class="form-control" name="youtube_video" value="{{$car->youtube_video}}" placeholder="Enter youtube Video URL">
                              </div>
                              </div>
                           </div>

                          @endforeach
                        </div>
                        <div class="row pt-20">
                        <div class="col-lg-12">
                        <div class="row " >
                        <div class="col-lg-8 ">
                          <div class="form-group">
                            <h4>{{ __('Contact Details') }} </h4>
                          </div>
                        </div>
                        </div>
                        </div>
                        </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Full Name') }}</label>
                      <input type="text" class="form-control" name="full_name" value="{{ $vendor->vendor_info->name }}">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label>{{ __('Email') }}</label>
                      <input type="text" value="{{ $vendor->email }}" class="form-control" name="email" disabled>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <label style="margin-top: 5px;margin-left: 10px;font-size: 21px;color: #7b7b7b;">{{ __('Phone') }}</label>
                    <div class="form-group input-group">

                      <div class="d-flex" style="    margin-top: -12px;">
                        <div class="custom-select">
                        <div class="select-selected">

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
                        <span class="short_code"> {{$s_code}} </span> ({{ $flagcode }})
                        </div>
                        <div class="select-items select-hide">
                        <div class="search-box">
                        <input type="text" id="country-search" placeholder="Search country...">
                        </div>
                        @foreach($country_codes as $country)
                        <div class="country-option" data-value="{{ $country->code }}" data-flag="{{ $country->flag_url }}">
                        <img src="{{ $country->flag_url }}" alt="{{ $country->country }}" class="flag">
                        <span  class="short_code">  {{$country->short_code}} </span> <span style="display:none;">{{$country->country}}</span> ({{ $country->code }})
                        </div>
                        @endforeach
                        </div>
                        </div>

                        <input type="hidden" name="c_code" id="c_code" value="{{ !empty(Auth::guard('vendor')->user()->country_code) ? Auth::guard('vendor')->user()->country_code : '+44' }}"/>

                        <input  type="number" value="{{ $vendor->phone }}" style="height: 40px;margin-top: 10px;    margin-right: 5px;" class="form-control" name="phone" required>


                       @if ($vendor->phone_verified == 1)
                        <button disabled   class="btn  btn-success2"  style="    height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button"><i class="fa fa-check" aria-hidden="true"></i></button>
                         @else
                        <button  id="verifyPhone" class="btn btn-outline-secondary"  style="height: 40px;
                        margin-top: 10px;
                        font-size: 25px;
                        padding-top: 5px;
                        width: 50px;
                        padding-left: 12px;
                        background: transparent;
                        color: #1b87f4;" type="button" title="verify"><i class='fas fa-fingerprint'></i></button>
                        @endif

                        </div>


                     <small style="    margin-top: 10px;">Verify your phone number and help reduce fraud and scams on Listit</small>
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>


                  <div class="col-lg-6">

                      <div class="form-group checkbox-xl row">
                          <div> <label>{{ __('Allow contact by') }}</label></div>
                      <div class="col-lg-6">

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="message_center" id="inlineRadio1" value="yes" required  <?= ($car->message_center == 1) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="message_center">Message </label>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-check form-check-inline">
                             <input class="form-check-input" type="checkbox" name="phone_text" id="inlineRadio2" value="yes"  <?= ($car->phone_text == 1) ? 'checked' : '' ?> >
                            <label class="form-check-label" for="message_center">Phone/Text</label>
                        </div>
                      </div>

                    </div>
                  </div>


                  <div class="col-lg-6" style="display:none;">
                    <div class="form-group">
                     <label>{{ __('Area') }}</label>

                     <input id ="promoStatus" type="hidden" name="promo_status" value="0">
                      <select name="city" id="" class="form-control">
                    <option value="">Please select...</option>
                    @foreach ($countryArea as $area)
                      <option value="{{ $area->slug }}" {{ $area->slug == $vendor->vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                    @endforeach
                    </select>
                    </div>
                  </div>


                  <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="CarSubmit" class="btn btn-primary">
                {{ __('Update') }}
              </button>
            </div>
          </div>
                  </div>
                <input type="hidden" id="max_file_upload" name="max_file_upload" value="{{$car->package ? $car->package->photo_allowed : 15 }}" />

                <div id="sliders">
                    @if(!empty($sortedGalleries) && count($sortedGalleries) > 0 )
                        @foreach($sortedGalleries as $itm)
                            <input type="hidden" name="slider_images[]" id="slider{{$itm->id}}" value="{{$itm->id}}">
                        @endforeach
                    @endif

                </div>
              </form>
            </div>
          </div>
        </div>
        </div>

        <div class="card-footer">

        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div> </div>
  </div>

   <input type="hidden" id="request_method" value="GET" />


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
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
option {
  padding: 0px 8px 8px;
}

 #carForm .btn-secondary{
  line-height: 16px !important;
  left:-4px;
 }
 .customRadio{
  width: 1.2em !important;
    height: 1.2em !important;
    border-color:#b1b1b1 !important;
    margin-right:4px !important;
 }
 .customRadiolabel{
  margin-top:3px !important;
  font-size: 14px;
  font-weight: 600;
 }
 .editAdLabel label{

  width:150px;
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


.rotatebtndb
{

    top: 30px !important;

    color: #004eabd6 !important;

    cursor: pointer !important;
}
.form-group label, .form-check label {
 color:gray !important;
}


.row h3,b,h4,label
{
     color:gray !important;
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

<!-- @if (session()->has('success'))
  <script>
    'use strict';
    var content = {};

    content.message = '{{ session('success') }}';
    content.title = 'Success';
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: 'success',
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      delay: 4000
    });
  </script>
@endif -->

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
    'use strict';
    var storeUrl = "{{ route('car.imagesstore') }}";
    var removeUrl = "{{ route('user.car.imagermv') }}";
    var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
    var rmvdbUrl = "{{ route('vendor.car.imgdbrmv') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";

    var rotationAngle1 = 0;

    function rotatePhoto(id)
{
    // Find the image element within the file preview element
    var imageElement = $('#img_'+id);


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

    function removethis(fileid)
    {
        $.ajax({
          url: removeUrl,
          type: 'POST',
          data: {
            fileid: fileid
          },
          success: function (data) {
            $("#slider" + fileid).remove();
            $('#trdb'+fileid).remove()
          }
        });
    }


     function rotationSave(fileid , rotationEvnt)
    {
        var requestMethid = "POST";

        if($('#request_method').val() != '')
        {
           var requestMethid = "GET";
        }

           $.ajax({
          url: '/customer/ad-management/img-db-rotate',
          type: requestMethid,
          data: {
            fileid: fileid , rotationEvnt:rotationEvnt
          },
          success: function (data)
          {

          }
        });
    }



  </script>

   <script src="{{ asset('assets/js/car.js?v=0.9') }}"></script>
  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";
  </script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-partial.js?v=0.2') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/js/admin-dropzone.js?v=0.9') }}"></script>
@endsection

