<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLabel" style="color: #EE2C7B;"><i class="fal fa-star fa-lg" ></i>
                        {{ __('Save Search') }}</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
 

                        
<div class="container">
 

<?php
$value_brand =json_encode(app('request')->input('brands'));
$brand = str_replace(array('[',']'),'',$value_brand);
$brands = trim($brand, '"');

$value_model =json_encode(app('request')->input('models'));
$model = str_replace(array('[',']'),'',$value_model);
$models = trim($model, '"');

$cat = app('request')->input('category');
 ?> 


  <form action="{{ route('Search.Filter') }}" method="POST">
    @csrf
    <div class="form-group">

      

       

      <label for="name">Name your search </label>
      <input type="text" class="form-control" id="title" name="title" 
value="@if($value_brand !==''){{$brands}}in{{$cat}}@endif @if($value_brand ===''){{$cat}}@endif">
    </div>


    <div class="form-group">
                       @if(app('request')->input('category') !="" )
                    Category = {{app('request')->input('category')}},

<?php     $category =    app('request')->input('category'); ?>
<input type="hidden" value="{{$category}}"  name="category" id="category" />
               

                    @endif

                     @if(app('request')->input('location') !="" )
                    Location = {{app('request')->input('location')}},

<?php     $location =    app('request')->input('location'); ?>
<input type="hidden" value="{{$location}}"  name="location" id="location"/>
               

                    @endif


            @if(app('request')->input('min') !="" && app('request')->input('max') !="")
           price =  {{app('request')->input('min')}} - {{app('request')->input('max')}},

<?php    
 $prices_min =    app('request')->input('min'); ?>
       <input type="hidden" value="{{$prices_min}}"  name="prices_min" id="prices_min"/>

<?php
$prices_max= app('request')->input('max'); ?>
<input type="hidden" value="{{$prices_max}}"  name="prices_max" id="prices_max"/> 

              @endif

                        
                      @if(json_encode(app('request')->input('brands'))!=="null" )
                   Brands = {{$brands}},


<input type="hidden" value="{{$brands}}"  name="brands" id="brands"/>
              

                       @endif


                       @if(json_encode(app('request')->input('models')) !=="null" )
                       Model = {{$models}},

                       <input type="hidden" value="{{$models}}"  name="models" id="models"/>

                        @endif


                       

 @if(app('request')->input('year_min') !="" && app('request')->input('year_max') !="")

                    Year = {{app('request')->input('year_min')}} -  {{app('request')->input('year_max')}},


<?php     $year_min =    app('request')->input('year_min') ; ?>
<input type="hidden" value="{{$year_min}}" name="year_min" id="year_min"/>

<?php $year_max =    app('request')->input('year_max') ; ?>
<input type="hidden" value="{{$year_max}}" name="year_max" id="year_max"/>
                      @endif

                      


                       @if(app('request')->input('mileage_min') !=""  &&  app('request')->input('mileage_max') !="")

                      Mileage ={{app('request')->input('mileage_min')}} - {{app('request')->input('mileage_max')}},

<?php     $mileage_min =    app('request')->input('mileage_min') ; ?>
<input type="hidden" value="{{$mileage_min}}" name="mileage_min" id="mileage_min"/>

<?php $mileage_max =    app('request')->input('mileage_max') ; ?>
<input type="hidden" value="{{$mileage_max}}" name="mileage_max" id="mileage_max"/>



                        @endif

                       


                       @if(app('request')->input('fuel_type') !="" )

                      Fuel{{app('request')->input('fuel_type')}},
<?php     $fuel_type =    app('request')->input('fuel_type'); ?>
<input type="hidden" value="{{$fuel_type}}"  name="fuel_type" id="fuel_type"/>

                      @endif



                       @if(app('request')->input('engine_min') !="" &&  app('request')->input('engine_max') !="")

                       Engine ={{app('request')->input('engine_min')}} - {{app('request')->input('engine_max')}},

<?php     $engine_min =    app('request')->input('engine_min') ; ?>
<input type="hidden" value="{{$engine_min}}"  name="engine_min" id="engine_min"/>

 <?php $engine_max =    app('request')->input('engine_max') ; ?>
<input type="hidden" value="{{$engine_max}}"  name="engine_max" id="engine_max"/>


                     @endif
                    



 @if(app('request')->input('power_min') !="" &&  app('request')->input('power_max') !="")

                       Power ={{app('request')->input('power_min')}} - {{app('request')->input('power_max')}},
<?php     $power_min =    app('request')->input('power_min') ; ?>
<input type="hidden" value="{{$power_min}}"  name="power_min" id="power_min"/>

 <?php $power_max =    app('request')->input('power_max') ; ?>
<input type="hidden" value="{{$power_max}}"  name="power_max" id="power_max"/>


                     @endif




                       @if(app('request')->input('battery') !="" )

                      Battery = {{app('request')->input('battery')}},

                       <?php     $battery =    app('request')->input('battery'); ?>
<input type="hidden" value="{{$battery}}"  name="battery" id="battery"/>

                        @endif



                       @if(app('request')->input('condition') !="" )

                        Condtion = {{app('request')->input('condition')}},
  <?php     $condition =    app('request')->input('condition'); ?>
<input type="hidden" value="{{$condition}}"  name="condition" id="condition"/>

                        @endif



                     @if(app('request')->input('owners') !="" )

                       Owner = {{app('request')->input('owners')}},

  <?php     $owners =    app('request')->input('owners'); ?>
<input type="hidden" value="{{$owners}}"  name="owners" id="owners"/>

                         @endif



                     @if(app('request')->input('doors') !="" )

                      Doors ={{app('request')->input('doors')}} ,

<?php     $doors =    app('request')->input('doors'); ?>
<input type="hidden" value="{{$doors}}"  name="doors"  id="doors" />
                       @endif

                       @if(app('request')->input('seat_min') !=""  && app('request')->input('seat_max') !="" )

                    Seats = {{app('request')->input('seat_min')}}-{{app('request')->input('seat_max')}},

                     <?php     $seat_min =    app('request')->input('seat_min') ; ?>
<input type="hidden" value="{{$seat_min}}"  name="seat_min" id="seat_min"/>

<?php     $seat_max =    app('request')->input('seat_max') ; ?>
<input type="hidden" value="{{$seat_max}}"  name="seat_max" id="seat_max"/>
                @endif


              </div>


   <div class="form-group">
 <p style="color: #EE2C7B;"> Want to get notified on this search? </p>
   <div class="radio">
  <label><input type="radio" name="optradio" id="optradio"  value="daily_alerts" checked>Yes,daily alerts</label>
</div>
<div class="radio">
  <label><input type="radio" name="optradio" id="optradio" value="instant_alerts">Yes,instant alerts</label>
</div>

<div class="radio">
  <label><input type="radio" name="optradio"  id="optradio" value="no_alerts">No alerts</label>
</div>
</div>

 <div class="form-group">
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">Cancel</span>
                        </button>
    <button type="submit" class="btn btn-primary" id="savedata">Submit</button>
  </div>
  </form>
</div>
  
                      </div>
                     
                    </div>
                  </div>
                </div>
                   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
 <script>
        $(document).ready(function(){
            $('#savedata').click(function(e){


                e.preventDefault();
               $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
                $.ajax({
                     headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
                     url: "{{ route('Search.Filter') }}",
                    method: 'post',
                    data: {
                        title: $('#title').val(),
                         optradio: $('#optradio').val(),

                        seats: $('#seats').val(),
                        category: $('#category').val(),
                        location: $('#location').val(),
                        prices_min: $('#prices_min').val(),
                        prices_max: $('#prices_max').val(),
                         brands: $('#brands').val(),
                        models: $('#models').val(),

                         year_min: $('#year_min').val(),
                         year_max: $('#year_max').val(),

                        mileage_min: $('#mileage_min').val(),
                        mileage_max: $('#mileage_max').val(),
                        
                         fuel_type: $('#fuel_type').val(),

                         
                        engine_min: $('#engine_min').val(),
                        engine_max: $('#engine_max').val(),

                         power_min: $('#power_min').val(),
                          power_max: $('#power_max').val(),

                        battery: $('#battery').val(),
                         condition: $('#condition').val(),
                        owners: $('#owners').val(),
                         doors: $('#doors').val(),
                        seat_min: $('#seat_min').val(),
                        seat_max: $('#seat_max').val(),


                        

                    },
                    success: function(result){
  $('#exampleModal').modal('hide');

                        if (result.message !== true) {
                            swal("Done!", result.message, "success");
                            // refresh page after 2 seconds
                            setTimeout(function(){
                                location.reload();
                            },2000);
                        } else {
                            swal("Error432!", result.message, "error");
                        }
                        if(result.errors)
                        {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>'+value+'</li>');
                            });
                        }
                        else
                        {
                            $('.alert-danger').hide();
                            $('#exampleModal').modal('hide');
                        }
                      
                    }
                });
            });
        });
    </script>