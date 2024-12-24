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

       @includeIf('vendors.partials.side-custom')

    <div class="col-md-9">

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title">{{ __('Edit Profile') }}</div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 mx-auto">
                    @php
                    $vendor_info = App\Models\VendorInfo::where('vendor_id', $vendor->id)
                    ->where('language_id', $language->id)
                    ->first();
                    @endphp
                          @foreach ($languages as $language)
              <form id="ajaxEditForm" action="{{ route('vendor.update_profile') }}" method="post">
                @csrf

                <div class="row">
                  <div class="col-lg-12">
                        <div class="form-group">
                        <label for="">{{ __('Photo') }}</label>
                        <br>
                        <div class="thumb-preview">
                        @if ($vendor->photo != null)
                        @php
                        $photoUrl = env('HOME_URL').'assets/admin/img/vendor-photo/' . $vendor->photo;

                        if (file_exists(public_path('assets/admin/img/vendor-photo/' . $vendor->photo)))
                        {
                            $photoUrl = asset('assets/admin/img/vendor-photo/' . $vendor->photo);
                        }
                        @endphp
                        <img style="border-radius: 10%; max-width: 60px;" class="lazyload blur-up uploaded-img" src="assets/images/placeholder.png" data-src="{{ $photoUrl }}" alt="Vendor" >
                        @else
                        <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                        @endif
                        </div>

                        <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                        {{ __('Choose Photo') }}
                        <input type="file" id="uploadImage" class="img-input" name="photo">
                        </div>
                        <p id="editErr_photo" class="mt-1 mb-0 text-danger em"></p>

                        </div>

                        <!-- Crop Modal -->
                        <div id="cropModal" style="display:none;margin-top: 7px;">
                            <div id="dimensionDisplay" style="margin-bottom: 7px !important;" class="mt-2 mb-0 text-warning text-warning">Width: <span id="cropWidth">0</span> px, Height: <span id="cropHeight">0</span> px</div>

                        <img id="imageToCrop" style="max-width:100%;">

                        <button id="cropButton" type="button" style="margin-top: 1rem;" class="btn btn-success">Crop</button>
                        </div>
                        </div>
                  </div>
                  <div class="col-lg-12" hidden>
                  <div class="form-group">
                      <h5>i am a</h5>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="1" id="flexRadioDefault1" @if ($vendor->trader == 1) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Trader
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input traderradio" type="radio" name="traderstatus" value="0" id="flexRadioDefault2"
                        @if ($vendor->trader == 0) checked @endif>
                        <label class="form-check-label" for="flexRadioDefault2">
                          Private Seller
                        </label>
                      </div>
                  </div>
                </div>

                <div class="col-lg-6 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('Business Name') }}</label>
                      <input type="text" value="{{ $vendor_info->business_name }}" class="form-control" name="business_name">
                      <p id="editErr_business_name" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-6 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('VAT Number (if applicable)') }}</label>
                      <input type="text" value="{{ $vendor_info->vat_number }}" class="form-control" name="vat_number">
                      <p id="editErr_vat_number" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-12 chkbox" @if ($vendor->trader == 0) style="display: none;" @endif>
                    <div class="form-group">
                      <label>{{ __('Business Address') }}</label>
                      <textarea class="form-control" name="business_address" placeholder="type your valid business address here ..." rows="3" style="height: 100px;">{{ $vendor_info->business_address }}</textarea>

                      <p id="editErr_business_address" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>{{ __('Username*') }}</label>
                      <input type="text" value="{{ $vendor->username }}"  readonly class="form-control" name="username">
                      <p id="editErr_username" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="form-group">
                      <label>{{ __('Email*') }}</label>
                      <input type="text" value="{{ $vendor->email }}" class="form-control" name="email">
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label style="margin-left:8px; font-weight: 600;">{{ __('Phone') }}</label>
                    <div class="form-group input-group">

                      <input   type="tel" value="{{ $vendor->phone }}" class="form-control" id="phone-number" readonly name="phone" required>
                      <span id="verification-status" class="ml-2" style="font-size: 1.5rem; margin-bottom: 10px;"></span>


                     <!--<small>Verify your phone number and help reduce fraud and scam on Listit</small>-->
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                  <script>

                    document.addEventListener('DOMContentLoaded', function () {
  const phoneInput = document.getElementById('phone-number');
  const verificationStatus = document.getElementById('verification-status');

  // Function to update verification status
  const updateVerificationStatus = () => {
    let phoneNumber = phoneInput.value.trim();

    // Ensure numbers starting with 7624 are displayed as 07624
    if (!phoneNumber.startsWith('0') && phoneNumber.startsWith('7624')) {
      phoneNumber = '0' + phoneNumber;
      phoneInput.value = phoneNumber; // Update displayed phone number
    }

    // Check if phone number starts with 07624
        if (phoneNumber.startsWith('07624')) {
          // Green Verification for Isle of Man
          verificationStatus.innerHTML = `
            <span style="color: green; font-weight: bold;margin-left: 10px; white-space: nowrap;font-size:16px;">
              ✅ Isle of Man
            </span>`;
        } else {
          // Orange Verification for others
          verificationStatus.innerHTML = `
            <span style="color: orange; font-weight: bold;margin-left: 10px; white-space: nowrap;font-size:16px">
              🟧 Verified
            </span>`;
        }
      };

      // Initial call to set verification status
      updateVerificationStatus();

      // Update verification status when phone input changes
      phoneInput.addEventListener('input', updateVerificationStatus);
    });

                  </script>



                  <div class="col-lg-12">
                    <div id="accordion" class="">

                        <div class="version" style="border: 0px !important;">


                          <div id="collapse{{ $language->id }}"
                            class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                            <div class="version-body" >
                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>{{ __('Name*') }}</label>
                                    <input type="text" value="{{ !empty($vendor_info) ? $vendor_info->name : '' }}"
                                      class="form-control" name="{{ $language->code }}_name" placeholder="Enter Name" required>
                                    <p id="editErr_{{ $language->code }}_name" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>

                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>{{ __('County') }}</label>
                                    <input type="text"
                                      value="Isle of Man"
                                      class="form-control" name="{{ $language->code }}_country"
                                      placeholder="Enter County" disabled >

                                    <p id="editErr_{{ $language->code }}_country" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>{{ __('City/Area')  }}</label>
                                    <select name="{{ $language->code }}_city" id="" class="form-control">
                                    <option value="">Please select...</option>
                                    @foreach ($countryArea as $area)
                                    <option value="{{ $area->slug }}" {{ $area->slug == $vendor_info->city ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                    </select>

                                    <p id="editErr_{{ $language->code }}_city" class="mt-1 mb-0 text-danger em"></p>
                                  </div>
                                </div>


                                  <div class="col-lg-12">
                    <div class="form-group">
                    <label style="width: 100%;
                    background: #9f9b9b;
                    padding: 15px;
                    text-align: center;
                    color: white !important;
                    border-radius: 5px;
                    margin-bottom: 2rem;">Opening Hours</label>

                    <table style='width: 100%;'>
                        <tr>
                            <th>Day</th>
                            <th>Opening Time</th>
                            <th>Closing Time</th>
                            <th>Holiday</th>
                        </tr>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <tr>
                                <td style="margin-right:150px;">{{ $day }}</td>
                                <td>
                                    <input type="time" name="opening_hours[{{ strtolower($day) }}][open_time]" value="{{ !empty($openingHour[$day]) ? $openingHour[$day]->open_time : '' }}" style="margin-top: 1rem;" class="form-control" required>
                                </td>
                                <td>
                                    <input type="time" name="opening_hours[{{ strtolower($day) }}][close_time]" value="{{ !empty($openingHour[$day]) ? $openingHour[$day]->close_time : '' }}" style="margin-top: 1rem;    margin-left: 1rem;"  class="form-control" required>
                                </td>
                                <td>
                                    <input type="checkbox" name="opening_hours[{{ strtolower($day) }}][holiday]"  {{ !empty($openingHour[$day]) && $openingHour[$day]->holiday ? 'checked' : '' }}  style="margin-top: 10px;margin-left: 1rem;zoom: 2;"  value="1">
                                </td>
                            </tr>
                        @endforeach
                    </table>


                      </div>
                    </div>


                        <div class="col-lg-12">
                        <div class="form-group">
                        <label style="width: 100%;
                        background: #9f9b9b;
                        padding: 15px;
                        text-align: center;
                        color: white !important;
                        border-radius: 5px;">Car Financing Dealer</label>

                        <label for="" class="mb-2" style="margin-top: 1rem;"><strong>Enter the url below to seamlessly direct users to your preferred financing dealer.</strong></label>
                        <input type="text" class="form-control"  placeholder="Enter url here where user redirect" value="{{$vendor->finance_url}}" name="finance_url" />

                         </div>
                        </div>


                                <div class="col-lg-12">
                                <div class="form-group">
                                <label>{{ __('Address') }}</label>


                                <textarea class="form-control" name="{{ $language->code }}_address" placeholder="type your valid address here ..." rows="3" style="height: 100px;">{{ !empty($vendor_info) ? $vendor_info->address : '' }}</textarea>


                                <p id="editErr_{{ $language->code }}_address" class="mt-1 mb-0 text-danger em"></p>
                                </div>
                                </div>



                                <div class="col-lg-12">
                                <div class="form-group">
                                <label>About Us </label>

                                <textarea class="form-control" name="about_us" placeholder="type here ..." rows="3" style="height: 100px;">{{ !empty($vendor) ? $vendor->about_us : '' }}</textarea>

                                </div>
                                </div>



                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                  </div>
                  <div class="col-lg-12" >
                    <div class="row">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_email_addresss == 1 ? 'checked' : '' }}
                              name="show_email_addresss" class="custom-control-input" id="show_email_addresss">
                            <label class="custom-control-label"
                              for="show_email_addresss">{{ __('Show Email Address in Profile Page') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_phone_number == 1 ? 'checked' : '' }}
                              name="show_phone_number" class="custom-control-input" id="show_phone_number">
                            <label class="custom-control-label"
                              for="show_phone_number">{{ __('Show Phone Number in Profile Page') }}</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" {{ $vendor->show_contact_form == 1 ? 'checked' : '' }}
                              name="show_contact_form" class="custom-control-input" id="show_contact_form">
                            <label class="custom-control-label"
                              for="show_contact_form">{{ __('Allow To Chat') }}</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>
              @endforeach
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="updateBtn" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
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
{{-- dropzone css --}}
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">

{{-- select2 css --}}
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/pages/inner-pages.css') }}">
{{-- admin-main css --}}
<link rel="stylesheet" href="{{ asset('assets/css/admin-main.css') }}">

<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">


<style type="">
  #carForm .form-control {
    display: block;
    width: 80%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 14px !important;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out
}
 #carForm .btn-secondary{
  line-height: 13px !important;
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>



{{-- select2 js --}}
<script type="text/javascript" src="{{ asset('assets/js/select2.min.js') }}"></script>

{{-- admin-main js --}}
<script type="text/javascript" src="{{ asset('assets/js/admin-main.js') }}"></script>

  <script>
    'use strict';
    var storeUrl = "{{ route('car.imagesstore') }}";
    var removeUrl = "{{ route('user.car.imagermv') }}";
    var getBrandUrl = "{{ route('user.get-car.brand.model') }}";
    const account_status = "{{ Auth::guard('vendor')->user()->status }}";
    const secret_login = "{{ Session::get('secret_login') }}";
  </script>


  <script>
    var labels = "{!! $labels !!}";
    var values = "{!! $values !!}";

    let cropper;
    let imageModal = document.getElementById('cropModal');
    let image = document.getElementById('imageToCrop');
    let fileInput = document.querySelector('.img-input');
    let cropWidthDisplay = document.getElementById('cropWidth');
    let cropHeightDisplay = document.getElementById('cropHeight');

    // When the file input changes (user selects an image)
    $('.img-input').on('change', function (event) {
    let file = event.target.files[0];

    if (file) {
        // Revoke any existing object URL to free up memory
        if (image.src.startsWith('blob:')) {
            URL.revokeObjectURL(image.src);
        }

        // Clear any previous cropper instance if it exists
        if (cropper) {
            cropper.destroy();
            cropper = null;  // Ensure cropper is fully reset
        }

        // Set the new image source
        image.src = URL.createObjectURL(file);
        imageModal.style.display = 'block'; // Show the modal for cropping

        // Ensure the image is fully loaded before initializing Cropper.js
        image.onload = function() {
            // Initialize Cropper.js on the uploaded image without an aspectRatio constraint
            cropper = new Cropper(image, {
                viewMode: 1, // This gives you a free-resize behavior
                autoCropArea: 1, // Automatically fill the container
                crop: function(event) {
                    // Update dimensions display dynamically
                    cropWidthDisplay.textContent = Math.round(event.detail.width);
                    cropHeightDisplay.textContent = Math.round(event.detail.height);
                }
            });
        };
    }
    });

    // When the "Crop" button is clicked
    document.getElementById('cropButton').addEventListener('click', function() {
    if (cropper) {
        // Create a canvas from the cropped area
        let canvas = cropper.getCroppedCanvas();

        // Create another canvas to draw the cropped image with a white background
        let canvasWithBg = document.createElement('canvas');
        canvasWithBg.width = canvas.width;
        canvasWithBg.height = canvas.height;

        let ctx = canvasWithBg.getContext('2d');

        // Fill the canvas with white background
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, canvasWithBg.width, canvasWithBg.height);

        // Draw the cropped image over the white background
        ctx.drawImage(canvas, 0, 0);

        // Convert the canvas to data URL (JPEG format)
        let croppedImageData = canvasWithBg.toDataURL('image/jpeg');

        // Set the cropped image data to the preview
        $('.uploaded-img').attr('src', croppedImageData);

        imageModal.style.display = 'none';

        let croppedImageInput = document.createElement('input');
        croppedImageInput.type = 'hidden';
        croppedImageInput.name = 'cropped_image';
        croppedImageInput.value = croppedImageData;

        document.querySelector('form').appendChild(croppedImageInput);

        cropper.destroy();  // Destroy the cropper instance
        cropper = null;     // Reset cropper to null
        URL.revokeObjectURL(image.src);  // Clean up the object URL
        fileInput.value = '';  // Clear file input
    }
    });

  </script>


@endsection
