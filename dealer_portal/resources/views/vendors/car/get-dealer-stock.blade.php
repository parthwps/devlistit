
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

  </style>
<!DOCTYPE html>
<html lang="xxx" dir="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="KreativDev">

  <meta name="keywords" content="  ">
  <meta name="description" content="  ">
  <meta name="csrf-token" content="9GzQu3FC05HGHt7TaJmwEOQvWUZseIbmafq0XB6b" />
  <link rel="manifest" crossorigin="use-credentials" href="http://127.0.0.1:8000/manifest.json">

  
  <title>      Signup
   | List IT</title>
  
  <link rel="shortcut icon" type="image/png" href="http://127.0.0.1:8000/assets/img/652949ab18095.png">
  <link rel="apple-touch-icon" href="http://127.0.0.1:8000/assets/img/652949ab18095.png">

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/bootstrap.min.css">
<!-- Data Tables CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/datatables.min.css">
<!-- Fontawesome Icon CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/fonts/fontawesome/css/all.min.css">
<!-- Icomoon Icon CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/fonts/icomoon/style.css">
<!-- NoUi Range Slider -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/nouislider.min.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/magnific-popup.min.css">
<!-- Swiper Slider -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/swiper-bundle.min.css">
<!-- Nice Select -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/nice-select.css">
<!-- AOS Animation CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/aos.min.css">
<!-- Animate CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/vendors/animate.min.css">

<link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/floating-whatsapp.css">

<link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/toastr.min.css">

<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/tinymce-content.css">

<!-- Main Style CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/style.css">
<!-- Responsive CSS -->
<link rel="stylesheet" href="http://127.0.0.1:8000/assets/front/css/responsive.css">


<link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/dropzone.min.css">

<link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/atlantis_custom.css">

<link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/select2.min.css">

<style type="text/css">
  .select2-selection__rendered {
    line-height: 42px !important;
}
.select2-container .select2-selection--single {
    height: 45px !important;
}
.select2-selection__arrow {
    height: 44px !important;
}
</style>

  <style>
    :root {
      --color-primary: #F02B7D;
      --color-primary-rgb: 240, 43, 125;
    }
  </style>


</head>

<body dir="">

@if (count($data['cars']) == 0)
                <h3 class="">{{ __('You have not placed any Ads yet') }}</h3>
                <small class="text-center">What are you waiting for? Start selling today</small><br>
                <a href="{{ route('vendor.cars_management.create_car') }}" class="btn btn-primary btn-sm float-right"><i
                  class="fas fa-plus"></i> {{ __('Place an Ad') }}</a>
              @else

              <div style="display:flex;">
                <img src="{!! $data['photo'] !!}" style="width: 100px;height: 100px;border-radius: 50%;border: 0.5px solid #d4d4d4;margin-top: 1rem;margin-right: 1.5rem;" />
                <h3 style="margin-top: 3%;">{{Auth::guard('vendor')->user()->username}} <br> {{Auth::guard('vendor')->user()->phone}}</h3>
              </div>

                  <table class="table table-bordered mt-3" id="">
                    <thead>
                      <tr>
                  
                        <th scope="col">{{ __('Image') }}</th>
                        <th scope="col">{{ __('Year') }}</th>
                        <th scope="col">{{ __('Make') }}</th>
                        <th scope="col">{{ __('Model') }}</th>
                        <th scope="col">{{ __('Engine size') }}</th>
                        <th scope="col">{{ __('Fuel Type') }}</th>
                        <th scope="col">{{ __('Trans-mission') }}</th>
                        <th scope="col">{{ __('ODO-Meter') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data['cars'] as $car)
                        <tr>
                          <td>

                          @php 
                            $image_path = $car->feature_image;
                            
                            if(empty($car->feature_image))
                            {
                                $image_path = $car->galleries[0]->image;
                            }

                            @endphp


                           <img src="{{asset('assets/admin/img/car-gallery/'.$image_path )}}"  style="padding: 10px;max-width: 7rem;border-radius: 20px;"/>
                          </td>

                          <td>
                           
                           {{ $car->year }}
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
                              {{$car->engineCapacity }}
                          </td>

                          <td>
                            @php
                              if ($car->car_content) {
                                  $fuel_type = $car->car_content->fuel_type()->first();
                              } else {
                                  $fuel_type = null;
                              }
                            @endphp
                            {{ $fuel_type != null ? $fuel_type['name'] : '-' }}
                          </td>


                          <td>
                            @php
                              if ($car->car_content) {
                                  $transmission_type = $car->car_content->transmission_type()->first();
                              } else {
                                  $transmission_type = null;
                              }
                            @endphp
                            {{ $transmission_type != null ? $transmission_type['name'] : '-' }}
                          </td>

                          
                          <td>
                              {{number_format($car->mileage )}}
                          </td>

                          <td>
                              {{number_format($car->price , 2)}}
                          </td>

                        </tr>
                      @endforeach
                    </tbody>
                  </table>
            
              @endif




<!-- Jquery JS -->
<script src="http://127.0.0.1:8000/assets/front/js/vendors/jquery.min.js"></script>
<!-- Popper JS -->
<script src="http://127.0.0.1:8000/assets/front/js/vendors/popper.min.js"></script>
<!-- Bootstrap JS -->
<script src="http://127.0.0.1:8000/assets/front/js/vendors/bootstrap.min.js"></script>

</body>

</html>
