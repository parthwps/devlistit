
<!-- Modal -->
<div class="modal fade" id="informationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;">AD PERFORMANCE</h5>

        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 30%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

       <div class="row">
        <div class="col-md-12" style="font-size: 13.5px;">
          <b>Ad Click % (CTR)</b>
          
          <p style="margin-bottom: 2rem;"> The percentage of customer  who clicked  to view the ad after  it appeared  on a search  page  on the listit app or website.</p>
        </div>

        <div class="col-md-12" style="font-size: 13.5px;">
          <b>Ad Views</b>
          
          <p style="margin-bottom: 2rem;">The number  of customers that have viewed this ad via the listit app or website.</p>
        </div>


        <div class="col-md-12" style="font-size: 13.5px;">
          <b>Ad Saves</b>
          
          <p style="margin-bottom: 2rem;">The number of times that customers have  saved ad via the listit app or website.</p>
        </div>

        <div class="col-md-12" style="font-size: 13.5px;">
          <b>Phone No. Reveals</b>
          
          <p style="margin-bottom: 2rem;"> The number of customers that have revealed the phone number on  ad via the  listit app or website.</p>
        </div>

        <div class="col-md-12" style="font-size: 13.5px;">
          <b>Conversations</b>
          
          <p style="margin-bottom: 2rem;">The number of customers that have send you message  for ads via the  listit app or website.</p>
        </div>

        <div class="col-md-12 text-center" style="font-size: 13.5px;">
        <hr>
          <p style="margin-bottom: 2rem;">  
          Need help ? Please contact our Sales team on <a href="mailto:dealer@listit.im" style="color:#ee2c7b;">dealer@listit.im</a>.
        </p>
        </div>
      
       </div>

      </div>
     
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="emailSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;">Email Subscription Report</h5>
       
        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 25%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>


      <div class="modal-body">

      <p style="font-size: 12px;color: black;font-weight: 900;">The emails who subscribe will receive last 7 days report on every monday.</p>

      <form method="get" id="emailForm" action="{{route('vendor.car_management.submit_emails')}}">
     
      </form>
      </div>
     
    </div>
  </div>
</div>


<input type="hidden" id="selectedCateid" />




<!-- Modal -->
<div class="modal fade" id="addnewusermodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;">Add New User</h5>
       
        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 25%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>


      <div class="modal-body">


      <form method="get" id="emailForm" action="{{route('vendor.cars_management.saveuser')}}">
        <div class="row">
          <div class="col-md-12" style="margin-bottom:1rem;">
          <label>Name</label>
          <input type="text" required name="name" id="name" class="form-control" />
          </div>

          <div class="col-md-12"  style="margin-bottom:1rem;">
          <label>Email</label>
          <input type="email" required name="email" id="email" class="form-control" />
          </div>

            <input type="hidden" name="enquiry_id" id="enquiry_id" />

          <div class="col-md-12"  style="margin-bottom:1rem;">
          <label>Phone</label>
          <input type="number" id="phone_no" required name="phone_no" class="form-control" />
          </div>

          <div class="col-md-12" >
        
         <button class="btn btn-sm btn-success" style="width: 100%;">Save</button>
          </div>

        </div>
      </form>
      </div>
     
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="checkcarhistory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;">Verify Car History Before You Buy</h5>
       
        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 25%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>


      <div class="modal-body">


        <div class="row">
          <div class="col-md-12" style="margin-bottom:1rem;">
          <label style="    margin-bottom: 0.5rem;">Registration Number</label>
                <div style="display:flex;">
                <input type="text" class="form-control validateTextBoxs" name="vehicle_history_reg" style="border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="Enter vehicle registration" id="vehicle_history_reg" >
                <button class="btn btn-sm btn-success" type="button" onclick="getVehicleHistoeyData(this)" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
          </div>

          <div class="col-md-12"  style="margin-bottom:1rem;">
       
          <div id="result_statuss" style="background: #e7e7e7;padding: 1rem;border-radius: 10px;">
            Below are the details you get freenium version</div>
          </div>
 
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"   style="margin-bottom:1rem;">
          <label>Make</label>
          <div id="carMake"></div>
          </div>
          
          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Model</label>
          <div id="carModel"></div>
          </div>

          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Year</label>
          <div id="carYear"></div>
          </div>


          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Fuel Type</label>
          <div id="carFuelType"></div>
          </div>

          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Engine Capacity</label>
          <div id="carEngineCapacity"></div>
          </div>

          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Transmission Type</label>
          <div id="carTransmissionType"></div>
          </div>
       
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Body Type</label>
          <div id="carBodyType"></div>
          </div>

          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Mileage</label>
          <div id="carMileage"></div>
          </div>

          
          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Number Of Seats</label>
          <div id="carNumberOfSeats"></div>
          </div>


          <div class="col-md-3 col-sm-6 col-6 mob_mt_1rem"  style="margin-bottom:1rem;">
          <label>Car Doors</label>
          <div id="carDoors"></div>
          </div>


        </div>
 
      </div>
     
    </div>
  </div>
</div>


<div class="modal fade" id="checkCredits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;text-align: center;">
            Your Available Credits
           
        </h5>
       
        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 25%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>


      <div class="modal-body">


        <div class="row">
          

          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: bolder;font-size: 15px !important;">Bumps</label>
          
          </div>
   
          
          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: bolder;font-size: 15px !important;">History Check Credit</label>
        
          </div>


          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: bolder;font-size: 15px !important;">Add Posting Credits</label>
          
          </div>
    
    
            @if(!empty(Auth::guard('vendor')->user()))
             <div class="col-md-12"  style="margin-bottom:1rem;">   <hr> </div>
         
          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Available Bump</label>
          <div id="">{{Auth::guard('vendor')->user()->bump}}</div>
          </div>

          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Available credits</label>
          <div id="">{{Auth::guard('vendor')->user()->history_check}}</div>
          </div>

          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Available limit</label>
          <div id="">{{Auth::guard('vendor')->user()->no_of_ads}}</div>
          </div>

          <div class="col-md-12"  style="margin-bottom:1rem;">   <hr> </div>

          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Used Bump</label>
          <div id="">{{Auth::guard('vendor')->user()->bump_used }}</div>
          </div>

        
          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Used credits</label>
          <div id="">{{Auth::guard('vendor')->user()->history_check_used }}</div>
          </div>

          
          <div class="col-md-4 text-center"  style="margin-bottom:1rem;">
          <label style="font-weight: 600;font-size: 13px !important;">Used credits</label>
          <div id="">{{Auth::guard('vendor')->user()->no_of_ads_used	}}</div>
          </div>

            <div class="col-md-12"  style="text-align: center;margin-bottom: 1rem;margin-top: 2rem;">   Looking to upgrade  or change  your current package? Please contact our sales team on 
            <a href="mailto:hello@listit.im" style="color:#ee2c7b;">hello@listit.im</a> </div>
   @endif
        </div>
 
      </div>
     
    </div>
  </div>
</div>


   @if(!empty(Auth::guard('vendor')->user()))
<!-- Modal -->
<div class="modal fade" id="uploadBannerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="justify-content:center;">
     
        <h5 class="modal-title" id="exampleModalLabel" style="justify-content: center;">Upload Your Home Banner</h5>
       
        <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" style="position: relative;left: 25%;font-size: 20px;" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>


      <div class="modal-body">

      <form method="post" id="imageUploadForm" enctype="multipart/form-data">
          
        <div id="imagePreview">
             @if(!empty(Auth::guard('vendor')->user()->banner_image))
            <img style="width: 100%;height: 200px;margin-bottom: 1rem;border-radius: 10px;" src="{{asset('public/uploads/'.Auth::guard('vendor')->user()->banner_image)}}" alt="Preview">
            @endif
        </div>

        <input type="file" class="form-control" id="imageInput" name="image" />
        
        <button  type="button" onclick="uploadImage()" class="btn btn-success btn-sm" style="float: right;margin-top: 1rem;">Save</button>
      </form>
      
      
      </div>
     
    </div>
  </div>
</div>
@endif

 @if(!empty(Auth::guard('vendor')->user()))
<!-- Modal -->
<div class="modal fade" id="buyNowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"  role="document">
    <div class="modal-content">
      <div class="modal-header" >
  
        <h5 class="modal-title" style="width: 100%;display: inline-block;" >
            Buy Extras 
            @if(!empty(Auth::guard('vendor')->user()))
            <br>
            <span style="color: gray;font-size: 15px;"> 
            
                <b>
                    Your Available Credits Balance is
                </b> 
                
                <span style="color:black;font-weight: 600;"> 
                    : £  {{number_format(Auth::guard('vendor')->user()->amount , 2)}} 
                </span> 
                
            </span>
            @endif
             <span aria-hidden="true" onclick="closeModal()"  style="cursor:pointer;font-size: 20px;float: right;" >&times;</span>
        </h5>
       
        <br>
      </div>


      <div class="modal-body">


        <div class="row">
          
        <div  class="col-md-12"  style="margin-bottom:0.5rem;">
            <div class="alert " role="alert" id="alertMessage" style="display:none;"> </div>
        </div>

          <div class="col-md-12"  style="margin-bottom:0.5rem;">
          <label style="font-weight: bolder;font-size: 19px !important;">Buy Bump(s)</label>
          
          </div>
   
        <div class="col-md-12"  style="margin-bottom:0.5rem;">
            <form method="GET" onsubmit="return updateExtras(0)">
            <label class="mb-1">Each bump multiply by cost <span style="color:black;font-weight: 600;">&nbsp;&nbsp;£ {{getSetVal('per_bump_price')}} </span></label>
            <div style="display:flex;">
                <input type="number" class="form-control" min="1" value="1" id="no_of_bumps" />
                <button type="submit" style="width: 200px;margin-left: 1rem;" class="btn btn-primary us_dis_btn">Buy Now</button>
            </div>
            </form>
        </div>
        
         <div class="col-md-12"  style="margin-bottom:0.5rem;">
          <label style="font-weight: bolder;font-size: 19px !important;">Buy More Ads(s)</label>
          
          </div>
          
          
         <div class="col-md-12"  style="margin-bottom:0.5rem;">
            <form method="GET"  onsubmit="return updateExtras(1)">
            <label class="mb-1">Each Ad multiply by cost <span style="color:black;font-weight: 600;">&nbsp;&nbsp; £ {{getSetVal('per_ad_price')}} </span></label>
            <div style="display:flex;">
                <input type="number" class="form-control" min="1" value="1" id="no_of_ads" />
                <button type="submit" style="width: 200px;margin-left: 1rem;" class="btn btn-primary  us_dis_btn">Buy Now</button>
            </div>
            </form>
        </div>
        
        
                </div>
 
            </div>
     
        </div>
      </div>
    </div>
    
    
    <div class="modal fade" id="vintageYearAlertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

  <div class="modal fade" id="showAlertForDebit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    
      <div class="modal-body" style="font-weight: 600;display: flex;">
       <i class='fas fa-exclamation-circle' style="    font-size: 25px;
    margin-right: 10px;
    position: relative;
    top: 5px;"></i>  <div>
           You have reached all of your package credits if you proceed now you will charge extra for this service.
       </div>
      </div>
      <div style="padding: 1rem;display: flex;" id="PyMdlFtr">
        <button type="button" class="btn btn-danger" style="width:100%;margin-right: 10px;" onclick="closepModal()" >Cancel</button>
        <button type="button" class="btn btn-primary" style="width:100%" onclick="confirmedPayemnt()">Confirm</button>
      </div>
    </div>
  </div>
</div>




   @endif
   
   
<script>
  'use strict';
  /*const baseURL = "{{ url('/') }}";
  const all_model = "{{ __('All') }}";
  const read_more = "{{ __('Read More') }}";
  const read_less = "{{ __('Read Less') }}";
  const show_more = "{{ __('Show More') . '+' }}";
  const show_less = "{{ __('Show Less') . '-' }}";*/
  var vapid_public_key = "{!! env('VAPID_PUBLIC_KEY') !!}";
</script>
<!-- Jquery JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.min.js') }}"></script>
<!-- Popper JS -->
<script src="{{ asset('assets/front/js/vendors/popper.min.js') }}"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('assets/front/js/vendors/bootstrap.min.js') }}"></script>

<!-- Data Tables JS -->
<script src="{{ asset('assets/front/js/vendors/datatables.min.js') }}"></script>
<!-- Counter JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.counterup.min.js') }}"></script>
<!-- Nice Select JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.nice-select.min.js') }}"></script>
<!-- Magnific Popup JS -->
<script src="{{ asset('assets/front/js/vendors/jquery.magnific-popup.min.js') }}"></script>
{{-- syotimer js --}}
<script src="{{ asset('assets/js/jquery-syotimer.min.js') }}"></script>
<!-- Swiper Slider JS -->
<script src="{{ asset('assets/front/js/vendors/swiper-bundle.min.js') }}"></script>
<!-- Lazysizes -->
<script src="{{ asset('assets/front/js/vendors/lazysizes.min.js') }}"></script>
<!-- Noui Range Slider JS -->
<script src="{{ asset('assets/front/js/vendors/nouislider.min.js') }}"></script>
<!-- AOS JS -->
<script src="{{ asset('assets/front/js/vendors/aos.min.js') }}"></script>
<!-- Mouse Hover JS -->
<script src="{{ asset('assets/front/js/vendors/mouse-hover-move.js') }}"></script>
<!-- Svg Loader JS -->
<script src="{{ asset('assets/front/js/vendors/svg-loader.min.js') }}"></script>
{{-- whatsapp js --}}
<script src="{{ asset('assets/js/floating-whatsapp.js') }}"></script>
{{-- tinymce script js --}}
<script src="{{ asset('assets/js/tinymce/js/tinymce/tinymce.min.js') }}"></script>
{{-- toastr --}}
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
{{-- push notification js --}}
<!--<script src="{{ asset('assets/js/push-notification.js') }}"></script>-->
<!-- Main script JS -->
<script src="{{ asset('assets/front/js/script.js?v=0.10') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>

        function validateCarBump(car_id)
        {
            $('#PyMdlFtr').html('<input type="hidden" id="py_car_id" value="'+car_id+'" /> <button type="button" class="btn btn-danger" style="width:100%;margin-right: 10px;" onclick="closepModal()" >Cancel</button><button type="button" class="btn btn-primary" style="width:100%" onclick="confirmedPayemnt(2)">Confirm</button>')
            $('#showAlertForDebit').modal('show');
            return false;
        }
        
        function validateCarFeatured(car_id)
        {
            $('#PyMdlFtr').html('<input type="hidden" id="py_car_id" value="'+car_id+'" /> <button type="button" class="btn btn-danger" style="width:100%;margin-right: 10px;" onclick="closepModal(1)" >Cancel</button><button type="button" class="btn btn-primary" style="width:100%" onclick="confirmedPayemnt(1)">Confirm</button>')
            $('#showAlertForDebit').modal('show');
            return false;
        }
       
        function closepModal(type = null)
        {
             $('#showAlertForDebit').modal('hide'); 
          
             if(type == 1)
             {
                $('#fearured_select_box').val(0)
             }
        }
        
        function showAlertForDebit()
        {
            $('#showAlertForDebit').modal('show');
        }
        
        function confirmedPayemnt(type = null)
        {
            if(type == 1)
            {
               $('#featureForm'+$('#py_car_id').val()).submit()
            }
            
             if(type == 2)
            {
               window.location.href="car-management/add-bump?car="+$('#py_car_id').val()
            }
            
            $('#prmrnt_artBtn').hide();
            $('#CarSubmit').show();
            $('#CarSubmit').click();
            $('#showAlertForDebit').modal('hide');
        }
        
        $(document).ready(function() {
            $(document).on('change', '.us_hide_by_default input[type="checkbox"]', function() {
                var checkboxValue = $(this).val();
                var isChecked = $(this).is(':checked'); // Simplified
        
                $.ajax({
                    url: '{{ route("savetodraftkeyfeature") }}',
                    method: 'GET',
                    data: { current_val: checkboxValue, isChecked: isChecked },
                    dataType: 'json',
                    success: function(response) {
                        // Handle success
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        
        function saveDraftData(self , column_name = null )
        {
        
        if(column_name != null)
        {
           
            if(column_name == 'ad_type' )
            {
                if($(self).val()  == 'Sale')
                {
                    $('#selling_label').html('What you are selling?')
                    $('#CarSubmit').html('Sell Now')
                }
                else
                {
                     $('#selling_label').html('What you are looking for?')
                      $('#CarSubmit').html('Publish Now')
                }
            }
                
                $isChecked = false;
                if ($(self).is(':checked')) 
                {
                   $isChecked = true;
                }
                
            $.ajax({
                url: '{{ route("savetodraft") }}',
                method: 'GET',
                data: {current_val : $(self).val() ,  column_name : column_name , 'isChecked' : $isChecked},
                dataType:'json',
                success: function (response) 
                {
                    var $selectedElement = $(self).closest('.sub_sub_sub_category');
                    var $nextElements = $selectedElement.nextAll('.sub_sub_sub_category');
                    $nextElements.remove();
                  
                  
                   if(response.result == 'ok')
                   {
                    $(".sub_sub_sub_category").last().after(response.output);
                   }
                   else if(response.result == 'dataonline')
                   {
                       $('#searcfiltersdata').html(response.output);
                   }
                    else if(response.result == 'dataoffline')
                    {
                       $('#searcfiltersdata').html('');
                    }
                    
                  
                    
                    if((column_name == 'sub_category_id' || column_name == 'category_id') && ($('#adsMaincat').val()  == 233 || $('#adsMaincat').val()  == 347 ) )
                    {
                        $('#addTYAP').hide();
                        $('#ad_price').val(0);
                        $('#ad_price').attr('readonly' , true);
                    }
                    else
                    {
                        $('#addTYAP').show();
                        $('#ad_price').val('');
                        $('#ad_price').attr('readonly' , false);
                    }
                    
                
                    
            
                },
               
            });
        }
        else
        {
            $.ajax({
                url: '{{ route("savetodraft") }}',
                method: 'GET',
                data: {current_val : $(self).val() },
                dataType:'json',
                success: function (response) 
                {
                    var $selectedElement = $(self).closest('.sub_sub_sub_category');
                    var $nextElements = $selectedElement.nextAll('.sub_sub_sub_category');
                    $nextElements.remove();
                        
                    if(response.result == 'ok')
                    {
                        $(".sub_sub_sub_category").last().after(response.output);
                    }
                    else if(response.result == 'dataonline')
                    {
                       $('#searcfiltersdata').html(response.output);
                    }
                    else if(response.result == 'dataoffline')
                    {
                       $('#searcfiltersdata').html('');
                    }
                },
                error: function (xhr, status, error) 
                {
                    console.error(xhr.responseText);
                }
            });
        }
        
       
                    if((column_name == 'sub_category_id' || column_name == 'category_id')  && $('#adsMaincat').val() == 39)
                    {
                           
                            
                        $('#labael_sold').html('SOLD STC');
                        $('#labael_reduced_price').html('REDUCED');
                        $('#labael_manager_special').html('UNDER OFFER');
                        $('#labael_new').html('New build');
                        $('#labael_used').html('2nd Hand Property');
                    }
                    else
                    {
                        $('#labael_sold').html('Sold');
                        $('#labael_reduced_price').html('Reduced Price');
                        $('#labael_manager_special').html('Manager  special');
                        $('#labael_new').html('New');
                        $('#labael_used').html('Used');
                    }
                     
    }
    
    function deletDarftAd()
    {
        $.ajax({
            url: '{{ route("deleteToDraft") }}',
            method: 'GET',
            
            success: function (response) 
            {
               location.reload(true)
            },
            error: function (xhr, status, error) 
            {
                console.error(xhr.responseText);
            }
        });
    }
    
    
function hide_owner_if_new(self)
{
    if($(self).val() == 'brand_new')
    {
       $('#ownerParentDiv').hide() 
    }
    else
    {
        $('#ownerParentDiv').show()
    }
}

    $(document).on('click', '.dz-error-mark', function() {
        
        $(this).closest('.dz-error').remove();
    });

    
    function hideFuelIf(self)
    {
        var thisVal = $('#adsSubcat').val();
        
        if (thisVal == 48 || thisVal == 62) 
        {
            $('#fuelType option[value="14"]').addClass('hidden-option');
        }
        else
        {
            $('#fuelType option[value="14"]').removeClass('hidden-option');
        }
        
        $.ajax({
            url: "{{route('frontend.getValidinput')}}",
            type: 'GET',
            data:{catVal:thisVal },
            success: function(data) 
            {
              $('#loadFiltersCategoryWise').html(data);  
              
            
            }
        });
    }

    function changeVal(self = null)
    {
        var selectedText = $('#fuelType').find('option:selected').text();
        var thisVal = $('#fuelType').val();
        var subcatVal = $('#adsSubcat').val();
      
        
       if (selectedText.trim() === 'Petrol' || selectedText.trim() === 'Diesel') 
        {
            $('#trsmisn_type').show()
        }
        else
        {
            
            $('#transmissionType').val(14);
            $('#transmissionType').change();
            $('#trsmisn_type').hide()
        }
      
    $.ajax({
        url: "{{route('frontend.getEngineCapacity')}}",
        type: 'GET',
        data:{selectedText:selectedText , thisVal:thisVal , subcatVal:subcatVal },
        success: function(data) 
        {
          $('#new_engine_caacity').html(data);  
        }
    });

}
    
    
function handleImageLoad(imgElement) {
    // Check if the image failed to load
    if (imgElement.naturalWidth === 0) {
        handleImageError(imgElement, imgElement.src); // Fallback to itself for further inspection
    }
}

function handleImageError(imgElement, fallbackUrl, attempt = 1) {
    // Remove the error handler to prevent endless loops
    imgElement.onerror = null;

    // Set the image source to the fallback URL
    imgElement.src = fallbackUrl;

    // Define the maximum number of retry attempts
    const maxAttempts = 5;
    
    // Define a retry delay in milliseconds
    const retryDelay = 500; // 2 seconds

    // Add a delay before retrying
    imgElement.onload = () => {
        console.log('Fallback image loaded successfully');
        imgElement.onload = null; // Clean up
    };

    imgElement.onerror = () => {
        if (attempt < maxAttempts) {
            console.log(`Retry ${attempt} failed, retrying in ${retryDelay}ms...`);
            // Wait for a specified delay before retrying
            setTimeout(() => {
                handleImageError(imgElement, fallbackUrl, attempt + 1);
            }, retryDelay);
        } else {
            console.log('Fallback image failed to load after maximum attempts');
        }
    };
}

    
    
$(document).ready(function() {
    // Clear the existing content
    $('.dz-default.dz-message').empty();
    
    // Append the cloud icon, a specific instruction message, and additional details
    $('.dz-default.dz-message').append(`
        <i class="fa fa-cloud-upload-alt" style="font-size: 48px;"></i>
        <h3 style="    margin-top: 1rem;">Drag & Drop to Upload File</h3>
        <p>or</p>
        <button class="btn btn-primary" type="button">Click to Browse Files</button>
    `);
});

function checkYearAgo(self) {
    // Get the value from the input, trim spaces
    var year = $(self).val().trim();
    
    // Allow only numeric input and enforce a maximum length of 4 digits
    if (year.length > 4) {
        year = year.slice(0, 4); // Limit to the first 4 digits
        $(self).val(year); // Update the input field
    }
    
    // Check if year has 4 digits and is a number
    if (year.length === 4 && !isNaN(year)) {
        var currentYear = new Date().getFullYear();
        
        // Check if the input year is greater than the current year
        if (parseInt(year, 10) > currentYear) {
            // Set the input value to the current year
            $(self).val(currentYear);
            year = currentYear; // Update the year variable to the current year
        }
        
        var yearDifference = currentYear - parseInt(year, 10);
        
        // Check if the year difference is greater than or equal to 30
        if (yearDifference >= 30) {
            $('#vintageYearAlertModal').modal('show');
            $('#apendHTML').html('This vehicle was registered over ' + yearDifference + ' years ago. So this will be added to the vintage section. All the ads over 30 years ago will be added to the vintage section.');
        }
    }
}
 
    
function updateExtras(type)
{
    if(type == 0)
    {
        var numberOfData = $('#no_of_bumps').val(); 
    }
    else
    {
         var numberOfData = $('#no_of_ads').val();
    }
   
    $('.us_dis_btn').prop('disabled' , true);
    
      $.ajax({
        url: '{{ route("vendor.car_management.save_more_credits") }}',
        type: 'GET',
        data:{type:type , numberOfData:numberOfData },
        dataType:'json',
        success: function(data) 
        {
             $('#alertMessage').show();
             $('.us_dis_btn').prop('disabled' , false);
            if(data.response == 'error')
            {
                $('#alertMessage').addClass('alert-danger');
                $('#alertMessage').html(data.message);
            }
            else
            {
                $('#alertMessage').addClass('alert-success');
                $('#alertMessage').html(data.message);
                
                setTimeout(function() { 
                 location.reload(true);
                }, 5000);
            }
        },
        error: function(error) 
        {
            console.error('Error:', error);
        }
    });
        
        return false;
}


function opentopSearch()
{
    $('#topSearch').modal('show');
}
function clsoeModal()
{
    $('#topSearch').modal('hide');
}

    // Display image preview
    $('#imageInput').change(function () 
    {
        var input = this;
        var reader = new FileReader();

        reader.onload = function (e) 
        {
            $('#imagePreview').html('<img style="width: 100%;height: 200px;margin-bottom: 1rem;border-radius: 10px;" src="' + e.target.result + '" alt="Preview">');
        };

        reader.readAsDataURL(input.files[0]);
    });
    
  function uploadImage() {
        var formData = new FormData($('#imageUploadForm')[0]);
    
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
        });

        $.ajax({
            url: "{{route('vendor.update_profile_banner')}}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) 
            {
               if(response.success )
               {
                   alert('Uploaded successfully');
               }
            },
            error: function (error) {
                // Handle error
                console.error('Error uploading image:', error);
            }
        });
        
        return false;
    }
    
    
    function addBnneraccount()
    {
       $('#uploadBannerModal').modal('show') 
    }
    
    function myaccount()
    {
      $('#checkCredits').modal('show')
    }
    
    function buyExtra()
    {
      $('#buyNowModal').modal('show')
    }
    
    function checkVehiclehistory()
    {
      $('#checkcarhistory').modal('show')
    }

function getVehicleHistoeyData(self)
{
  $(self).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style=" font-size: 16px;"></i><span class="sr-only">Loading...</span>')
    var vehicle_history_reg = $('#vehicle_history_reg').val();

    $.ajax({
        url: '{{ route("vendor.car_management.vheicle_deatails") }}',
        type: 'GET',
        data:{vehicle_reg:vehicle_history_reg},
        dataType:'json',
        success: function(data) 
        {
          if(data.response == 'yes')
          {
            $('#carModel').html(data.output.Model);
            $('#carMake').html(data.output.Make);
            $('#carYear').html(data.output.Year);
            $('#carFuelType').html(data.output.FuelType);
            $('#carEngineCapacity').html(data.output.EngineCapacity);
            $('#carTransmissionType').html(data.output.TransmissionType);
            $('#carBodyType').html(data.output.BodyType);
            $('#carMileage').html(data.output.Mileage);
            $('#carNumberOfSeats').html(data.output.NumberOfSeats);
            $('#carDoors').html(data.output.carDoors);
            $fullmodel = data.output.Make + ' ' + data.output.Model + ' ' + data.output.Year; 
            $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
            $('#result_statuss').html('<span style="font-weight: 800;color: #574c4c;"><i class="fal fa-check" style="font-size: 20px;color: #05eb05;margin-right: 5px;"></i> '+$fullmodel+'</span>')
            $('#result_statuss').show()
         
          }
          else
          {
            
            $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
            if(data.message)
            {
                $('#result_statuss').html('<span style="color:red;"> <i class="fal fa-times" style="font-size: 20px;color: red;margin-right: 5px;"></i> '+data.message+'</span>')
            }
            else
            {
              $('#result_statuss').html('<span style="color:red;"> <i class="fal fa-times" style="font-size: 20px;color: red;margin-right: 5px;"></i> Data Not found</span>')  
            }
            
            $('#result_statuss').show()
          }
          
        
        },
        error: function(error) 
        {
            console.error('Error:', error);
        }
    });


}

function addnewuser(user_id = null , self = null)
  {
    $name = $(self).data("name")
    $email = $(self).data("email")
    $phone_no = $(self).data("phone_no")


    $('#name').val(  $name);
    $('#email').val(  $email);
    $('#phone_no').val(  $phone_no);

    $('#enquiry_id').val(user_id)
    $('#addnewusermodal').modal('show')
  }


  function getVehicleData(self , type = null)
  {

    $(self).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style=" font-size: 16px;"></i><span class="sr-only">Loading...</span>')
    var vehicle_reg = $('#vehicle_reg').val();

    $.ajax({
        url: '{{ route("vendor.car_management.vheicle_deatails") }}',
        type: 'GET',
        data:{vehicle_reg:vehicle_reg , type:type},
        dataType:'json',
        success: function(data) 
        {
          if(data.response == 'yes')
          {
           
        /////// for make ////////////

        var makeSelect = $('#make');
        var MakeValue = data.output.Make.toLowerCase();

        // Iterate through options
        makeSelect.find('option').each(function() 
        {
          var optionValue =  $(this).text().toLowerCase();

          // Check if option value matches NumberOfDoors
        
            if (optionValue.includes(MakeValue)) {
            // Set the 'selected' attribute for the matching option
            $(this).prop('selected', true);
            $('#make').change()
            return false; // Exit the loop
          }
        });


         /////// for Fuel type ////////////

         var fuelTypeSelect = $('#fuelType');
        var fuelTypeValue = data.output.FuelType.toLowerCase();

        // Iterate through options
        fuelTypeSelect.find('option').each(function() 
        {
          var optionValue =  $(this).text().toLowerCase();

          // Check if option value matches NumberOfDoors
         
            if (optionValue.includes(fuelTypeValue)) {
            // Set the 'selected' attribute for the matching option
            $(this).prop('selected', true);
            $('#fuelType').change()
            return false; // Exit the loop
          }
        });


        /////// for Transmission type ////////////

        var transmissionTypeSelect = $('#transmissionType');
        var transmissionTypeValue = data.output.TransmissionType.toLowerCase();

        // Iterate through options
        transmissionTypeSelect.find('option').each(function() 
        {
          var optionValue =  $(this).text().toLowerCase();

          // Check if option value matches NumberOfDoors
          if (optionValue.includes(transmissionTypeValue)) {
            // Set the 'selected' attribute for the matching option
            $(this).prop('selected', true);
            $('#transmissionType').change()
            return false; // Exit the loop
          }
        });


        /////// for bodyType ////////////

        var ColorSelect = $('#carColour');
        var ColorSelectValue = data.output.Color.toLowerCase();

        // Iterate through options
        ColorSelect.find('option').each(function() 
        {
          var optionValue =  $(this).text().toLowerCase();

          // Check if option value matches NumberOfDoors
          if (optionValue.includes(ColorSelectValue)) {
            // Set the 'selected' attribute for the matching option
            $(this).prop('selected', true);
            $('#carColour').change()
            return false; // Exit the loop
          }
        });

       
              /////// for carSeats ////////////

              var carSeatsSelect = $('#carSeats');
            var carSeatsValue = data.output.NumberOfSeats;

            // Iterate through options
            carSeatsSelect.find('option').each(function() 
            {
              var optionValue =  $(this).text();

              // Check if option value matches NumberOfDoors
              if (optionValue.includes(carSeatsValue)) {
                // Set the 'selected' attribute for the matching option
                $(this).prop('selected', true);
                $('#carSeats').change()
                return false; // Exit the loop
              }
            });


            
             
            setTimeout(function() { 
        /////// for carModel ////////////

        var carModelSelect = $('#carModel');
            var carModelValue = data.output.Model.toLowerCase();
            var makeSelect = $('#make').val();
        $.ajax({
        url: '{{ route("vendor.car_management.get_cr_mdl") }}',
        type: 'GET',
        data:{carModelValue:carModelValue , makeSelect:makeSelect},
        success: function(carmodelresponse) 
        {
            // Set the value of the select element
            $('#carModel').val(carmodelresponse);

            // Trigger a change event to ensure any associated events are fired
            $('#carModel').change();
        },
        error: function(error) 
        {
            console.error('Error:', error);
        }
    });

    }, 1000);
            
            $('#carYear').val(data.output.Year);
            $('#carRoadTax').val(data.output.Tax_Fee);
           
            $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
            $('#result_status').html('<span style="color:#25b425;">Data  found</span>')
            $('#result_status').show()
         
          }
          else
          {
            $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
            $('#result_status').html('<span style="color:red;">Data Not found</span>')
            $('#result_status').show()
          }
          
          setTimeout(function() { 
            $('#result_status').hide()
            }, 2000);

        },
        error: function(error) 
        {
            console.error('Error:', error);
        }
    });


  }

  

  function getVehicleValuationData(self)
  {
    $(self).html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style=" font-size: 16px;"></i><span class="sr-only">Loading...</span>')
    var regisno = $('#vehicle_Valuationreg').val();
      $.ajax({
          url: '{{ route("vendor.car_management.get_car_valuation_data") }}',
          type: 'GET',
          data:{'regisno': regisno},
          dataType:"json",
          success: function(data) 
          {
            if(data.response == 'yes')
            {
              $('#VehicleDescription').html(data.output.VehicleDescription)
              $('#Mileage').html(data.output.Mileage)
              $('#PlateYear').html(data.output.PlateYear)

              $('#OTR').html(data.output.OTR)
              $('#DealerForecourt').html(data.output.DealerForecourt)
              $('#TradeRetail').html(data.output.TradeRetail)

              $('#PrivateClean').html(data.output.PrivateClean)
              $('#PrivateAverage').html(data.output.PrivateAverage)
              $('#PartExchange').html(data.output.PartExchange)

              $('#Auction').html(data.output.Auction)
              $('#TradeAverage').html(data.output.TradeAverage)
              $('#TradePoor').html(data.output.TradePoor)

              $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
              $('#result_status').html('<span style="color:#25b425;">Data  found successfully</span>')
              $('#result_status').show()
            }
            else
            {
              $(self).html('<i class="fa fa-search" aria-hidden="true"></i>')
              $('#result_status').html('<span style="color:red;">Data Not found</span>')
              $('#result_status').show()
            }

            setTimeout(function() { 
            $('#result_status').hide()
            }, 2000);

          },
          error: function(error) 
          {
              console.error('Error:', error);
          }
      });
  }

function getSubMails()
{
    $.ajax({
        url: '{{ route("vendor.car_management.getsubemail") }}',
        type: 'GET',
        success: function(response) 
        {
          $('#emailForm').html(response);
          $('#emailSubscriptionModal').modal('show')
        },
        error: function(error) 
        {
            console.error('Error:', error);
        }
    });
}

function openInfoModal()
{
  $('#informationModal').modal('show')
}

function closeModal()
{
  $('.modal').modal('hide')
}

function loadAndPrint() {
            // Make an AJAX request to fetch the HTML content
            $.ajax({
                url: '{{ route("vendor.car_management.carstock") }}',
                type: 'GET',
                success: function(response) {
                    // Place the fetched content into the 'printArea' div
                    $('#printArea').html(response);

                    setTimeout(function() { 
                      printSpecificArea();
                    }, 100);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function printSpecificArea() {
            var printContent = document.getElementById('printArea');
            var originalContent = document.body.innerHTML;

            // Replace the entire body content with the content of the specific area
            document.body.innerHTML = printContent.innerHTML;

            // Print the specific area
            window.print();

            // Restore the original content
            document.body.innerHTML = originalContent;

            $('#printArea').html('');

        }



$(document).ready(function() {
    $('#myTable2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );


$('#myTable3').DataTable({
    dom: 'Bfrtip',
    ordering: false,
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Excel',
            title: 'All Ads Excel File',
            filename: 'all_ads',
            exportOptions: {
                columns: ':not(.no-export)' // Skip columns with the 'no-export' class
            }
        },
        {
            extend: 'csvHtml5',
            text: 'CSV',
            title: 'All Ads CSV File',
            filename: 'all_ads',
            exportOptions: {
                columns: ':not(.no-export)' // Skip columns with the 'no-export' class
            }
        },
        {
            extend: 'pdfHtml5',
            text: 'PDF',
            title: 'All Ads PDF File',
            filename: 'all_ads',
            exportOptions: {
                columns: ':not(.no-export)' // Skip columns with the 'no-export' class
            }
        }
    ]
});








} );
</script>


<script>
$(function() {
  $('#daterange').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});


$(document).ready(function () {
        $('.onchngesubmit').on('change', function () {
          formSubmit()
        });
    });

function formSubmit()
{
  $('#filter_form').submit();
}
</script>


<script>
    $(document).ready(function () {
        var hoverTimeout;
        var currentElement;

        $('.product-default').on('mouseover', function () {
            // Clear any existing timeout
            clearTimeout(hoverTimeout);

            // Store a reference to the current element
            currentElement = $(this);

            // Set a new timeout to trigger the AJAX request after 1000 milliseconds (1 second)
            hoverTimeout = setTimeout(function () {
                // Make your AJAX request here using the stored reference to the current element
                var ad_id = currentElement.attr("data-id");

                $.ajax({
                url: '{{ route("ad.impression.count") }}',
                method: 'GET',
                data: {ad_id : ad_id },
                success: function (response) 
                {
                   
                },
                error: function (xhr, status, error) 
                {
                    console.error(xhr.responseText);
                }
            });

            }, 1000);
        });

        // Clear the timeout if the mouse leaves the element
        $('.product-default').on('mouseout', function () {
            clearTimeout(hoverTimeout);
        });
    });
</script>



<script type="text/javascript">
 $(document).ready(function () {
  $('.js-example-basic-single1').select2();
  $('.js-example-basic-single2').select2();
  $('.js-example-basic-single3').select2();
  $('.js-example-basic-single4').select2();
  $('.js-example-basic-single5').select2();
  $('.js-example-basic-single6').select2();
  $('.js-example-basic-single7').select2();
  //$('.subhidden').addClass('hidden');
}); 


</script>
{{-- whatsapp init code --}}
@if ($basicInfo->whatsapp_status == 1)
  <script type="text/javascript">
    var whatsapp_popup = "{{ $basicInfo->whatsapp_popup_status }}";
    var whatsappImg = "{{ asset('assets/img/whatsapp.svg') }}";

    $(function() {
      $('#WAButton').floatingWhatsApp({
        phone: "{{ $basicInfo->whatsapp_number }}", //WhatsApp Business phone number
        headerTitle: "{{ $basicInfo->whatsapp_header_title }}", //Popup Title
        popupMessage: `{!! nl2br($basicInfo->whatsapp_popup_message) !!}`, //Popup Message
        showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
        buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
        position: "right" //Position: left | right
      });
    });
  </script>
@endif
<!--Start of Tawk.to Script-->
@if ($basicInfo->tawkto_status)
  <script type="text/javascript">
    var Tawk_API = Tawk_API || {},
      Tawk_LoadStart = new Date();
    (function() {
      var s1 = document.createElement("script"),
        s0 = document.getElementsByTagName("script")[0];
      s1.async = true;
      s1.src = "{{ $basicInfo->tawkto_direct_chat_link }}";
      s1.charset = 'UTF-8';
      s1.setAttribute('crossorigin', '*');
      s0.parentNode.insertBefore(s1, s0);
    })();
  </script>
@endif
<!--End of Tawk.to Script-->
@yield('script')
@if (session()->has('success'))
  <script>
    "use strict";
    toastr['success']("{{ __(session('success')) }}");
  </script>
@endif

@if (session()->has('error'))
  <script>
    "use strict";
    toastr['error']("{{ __(session('error')) }}");
  </script>
@endif
@if (session()->has('warning'))
  <script>
    "use strict";
    toastr['warning']("{{ __(session('warning')) }}");
  </script>
@endif
