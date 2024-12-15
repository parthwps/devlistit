  <div class="card car_category"  >
        
                <div class="card-body">
                
                <div class="row " >
                  <div class="col-lg-8 ">
                    <div class="form-group">
                      <h3>{{ __('Add Details') }} </h3>
                      <!--<label>Get all your vehicle details instantly</label>-->
                  
                    </div>
                  </div>
                  
                </div>
               
            <div class="row us_car_features" >
                
                <div class="col-lg-2">
                    <div class="form-group">
                      <label id="labael_new"> New </label>
                      &nbsp;&nbsp; <input type="radio"  name="what_type" value="brand_new" onchange="hide_owner_if_new(this);saveDraftData(this , 'what_type')"  id="what_type"  @if($draft_ad == true && empty($draft_ad->what_type) ) checked @endif @if($draft_ad == true && !empty($draft_ad->what_type) && $draft_ad->what_type == 'brand_new') checked @endif >
                    </div>
                </div>
                
                <div class="col-lg-2">
                    <div class="form-group">
                      <label id="labael_used" >Used </label>
                      &nbsp;&nbsp; <input type="radio"   name="what_type" value="used" onchange="hide_owner_if_new(this);saveDraftData(this , 'what_type')"  id="what_type"  @if($draft_ad == true && empty($draft_ad->what_type) ) checked @endif @if($draft_ad == true && !empty($draft_ad->what_type) && $draft_ad->what_type == 'used') checked @endif >
                    </div>
                </div>
                
                <div class="col-lg-8"></div>
                
                
              @if ( in_array('registration', json_decode($categories->filters)) || in_array('registration_no', json_decode($categories->filters)) )   
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                          <label>Enter vehicle registration *</label>
                          <div style="display:flex;">
                              <input type="text" class="form-control validateTextBoxs" name="vehicle_reg" style="border-top-right-radius:0px;border-bottom-right-radius:0px;" placeholder="Enter vehicle registration" id="vehicle_reg" >
                              <button class="btn btn-sm btn-success" type="button" onclick="getVehicleData(this , 1)" style="border-top-left-radius:0px;border-bottom-left-radius:0px;"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        
                          <div id="result_status"></div>
                    </div>
                </div>
                @endif
                
            @if (in_array('make', json_decode($categories->filters))) 
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                  <div class="form-group">
                    @php
                    
                        $brands = App\Models\Car\Brand::where('cat_id', $categories->id)
                        ->where('status', 1)
                        ->withCount('cars')
                        ->orderBy('cars_count', 'desc')
                        ->orderBy('name', 'asc')
                        ->take(10) 
                        ->get();
                        
                        
                        $otherBrands = App\Models\Car\Brand::where('cat_id', $categories->id)
                        ->where('status', 1)
                        ->whereNotIn('id', $brands->pluck('id'))
                        ->orderBy('name', 'asc')
                        ->get();
                        
                    @endphp
                
                    <label>{{ __('Make') }} *</label>
                    <select name="en_brand_id"
                      class="form-control  validateTextBoxs" onchange="getModel(this);saveDraftData(this , 'make')" id="make" data-code="en">
                      <option value="" >{{ __('Select make') }}</option>
                      <option disabled>-- Popular Brands --</option>
                      @foreach ($brands as $brand)
                      
                        @php
                        
                        if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                        {
                            $brandId = $draft_ad->make;
                        } 
                        
                        @endphp
                
                        <option value="{{ $brand->id }}" @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif>{{ $brand->name }}</option>
                      @endforeach
                      <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Brands --</option>
                      @foreach ($otherBrands as $brand)
                      
                        @php
                        
                        if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                        {
                            $brandId = $draft_ad->make;
                        } 
                        
                        @endphp
                        
                        <option value="{{ $brand->id }}" @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif >{{ $brand->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
             
                 
                 
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                  <div class="form-group">
                
                    <label>{{ __('Model') }} *</label>
                    @php
                    if(isset($brandId)) 
                    {
                        $models = App\Models\Car\CarModel::where('brand_id', $brandId)->get();
                    } 
                    @endphp
        
                    <select name="en_car_model_id" class="form-control validateTextBoxs en_car_brand_model_id" onchange="saveDraftData(this , 'model')"   id="carModel">
                    @if(isset($brandId)) 
                    @foreach ($models as $model)
                        <option    value="{{ $model->id }}"   @if($draft_ad == true && !empty($draft_ad->model) && $draft_ad->model == $model->id) selected @endif    >{{ $model->name }}</option>
                    @endforeach
                    @else
                        <option  value="">Any</option>
                    @endif
                    </select>
                  </div>
                </div>
                @endif
                
                @if (in_array('year', json_decode($categories->filters))) 
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                  <label>{{ __('Year') }} *</label>
                  <input type="number" class="form-control validateTextBoxs" oninput="checkYearAgo(this)" 
                  value="@if($draft_ad == true && !empty($draft_ad->year)){{$draft_ad->year}}@endif" onfocusout="saveDraftData(this , 'year')" name="year" placeholder="Enter Year" id="carYear" >
                </div>
                </div>
                  @endif
          
            @if (in_array('fuel_types', json_decode($categories->filters)))
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
              <div class="form-group">
                @php
                  $fuel_types = App\Models\Car\FuelType::where('status', 1)
                      ->get();
                @endphp
            
                <label>{{ __('Fuel Type') }} *</label>
                <select name="en_fuel_type_id" id="fuelType" onchange="changeVal();saveDraftData(this , 'fuel')" class="form-control validateTextBoxs" >
                  <option value="" >{{ __('Select') }}</option>
            
                  @foreach ($fuel_types as $fuel_type)
                  
                  @if(( $categories->id == 48 || $categories->id == 62) && $fuel_type->name == 'Diesel' )
                        <option value="{{ $fuel_type->id }}" style="display:none;"  @if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id) selected @endif >{{ $fuel_type->name }}</option>
                  @else
                        <option value="{{ $fuel_type->id }}"  @if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id) selected @endif >{{ $fuel_type->name }}</option>
                  @endif
            
                  @endforeach
                </select>
              </div>
            </div>
            @endif
                 
            @if (in_array('engine', json_decode($categories->filters)))
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 " id="new_engine_caacity">
            <div class="form-group">
              <label> Engine Size   @if($categories->id == 48 || $categories->id == 62 ) [cc] @elseif(!empty($draft_ad->fuel) && in_array($draft_ad->fuel , [14,15]) ) [Liter] @else [Kw] @endif * </label>
              <input type="text" class="form-control validateTextBoxs" name="engineCapacity" value="@if($draft_ad == true && !empty($draft_ad->engine)) {{$draft_ad->engine}}  @endif" onfocusout="saveDraftData(this , 'engine')" placeholder="Enter Size" id="EngineCapacity" >
            </div>
            </div>
            
            @endif
                   
                 
                  @if (in_array('transmision_type', json_decode($categories->filters)))
                   <!-- editable --> 
                   <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                              <div class="form-group">
                                @php
                                  $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Transmission Type') }} *</label>
                                <select name="en_transmission_type_id" class="form-control validateTextBoxs" id="transmissionType" onchange="saveDraftData(this , 'transmission')">
                                 <option value="" >{{ __('Select') }}</option>

                                  @foreach ($transmission_types as $transmission_type)
                                    <option value="{{ $transmission_type->id }}" @if($draft_ad == true && !empty($draft_ad->transmission) && $draft_ad->transmission == $transmission_type->id) selected @endif>{{ $transmission_type->name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                              @endif
                    
                    @if (in_array('body_type', json_decode($categories->filters)))          
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                        
                    @php
                        $body_types = App\Models\Car\BodyType::where('status', 1)->where('cat_id' , $categories->id)->orderBy('serial_number', 'asc')->get();
                        
                        if($body_types->count() == 0)
                        {
                            $body_types =  App\Models\Car\BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
                        }
                    @endphp
                    
                    <label>{{ __('Body Type') }} </label>
                    <select name="body_type_id" id="bodyType" class="form-control" onchange="saveDraftData(this , 'body')" >
                    <option value="" >Please Select Body Type</option>
                    @foreach ($body_types as $body_type)
                    
                    <option value="{{ $body_type->id }}"   @if($draft_ad == true && !empty($draft_ad->body) && $draft_ad->body == $body_type->id) selected @endif >{{ $body_type->name }}
                    </option>
                    @endforeach
                    </select>
                    </div>
                    </div>
                    
                    @endif
                  
                    @if (in_array('doors', json_decode($categories->filters)))
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                    <label>{{ __('Doors') }} *</label>
                    <select name="doors" class="form-control validateTextBoxs" id="carDoors" required onchange="saveDraftData(this , 'doors')" >
                    <option value="">Please select...</option>
                    <option value="2" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 2) selected @endif >2</option>
                    <option value="3"  @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 3) selected @endif>3</option>
                    <option value="4" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 4) selected @endif>4</option>
                    <option value="5" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 5) selected @endif>5</option>
                    <option value="6" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 6) selected @endif>6</option>
                    <option value="7" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 7) selected @endif>7</option>
                    <option value="8" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 8) selected @endif>8</option>
                    </select>
                    </div>
                    </div>
                    
                    @endif
                  
                    @if (in_array('colour', json_decode($categories->filters)))
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group ">
                    @php
                      $colour = \DB::table('car_colors')->where('status', 1)
                          ->get(['id' , 'name']);
                    @endphp
                    
                    <label>{{ __('Colour') }} *</label>
                    <select name="en_car_color_id" class="form-control validateTextBoxs" id="carColour" onchange="saveDraftData(this , 'color')">
                      <option value="">{{ __('Select Colour') }}</option>
                    
                      @foreach ($colour as $colour)
                        <option value="{{ $colour->id }}" @if($draft_ad == true && !empty($draft_ad->color) && $draft_ad->color == $colour->id) selected @endif>{{ $colour->name }}</option>
                      @endforeach
                    </select>
                    </div>
                    </div>
                    @endif
                   
                    @if (in_array('seat_count', json_decode($categories->filters)))
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                    <label>{{ __('Seats') }} *</label>
                    <select name="seats" id="carSeats" class="form-control validateTextBoxs" onchange="saveDraftData(this , 'seats')">
                    <option value="">Please select...</option>
                    <option value="2" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 2) selected @endif >2</option>
                    <option value="3"  @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 3) selected @endif>3</option>
                    <option value="4" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 4) selected @endif>4</option>
                    <option value="5" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 5) selected @endif>5</option>
                    <option value="6" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 6) selected @endif>6</option>
                    <option value="7" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 7) selected @endif>7</option>
                    <option value="8" @if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 8) selected @endif>8</option>
                    </select>
                    </div>
                    </div>
                    @endif
                
                    @if (in_array('mileage', json_decode($categories->filters))) 
                    
                    <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                    <div class="form-group">
                      <label>{{ __('Add your mileage') }} (M) *</label>
                      <input type="number" class="form-control validateTextBoxs" name="mileage" step="any"  value="@if($draft_ad == true && !empty($draft_ad->milage)){{$draft_ad->milage}}@endif" onfocusout="saveDraftData(this , 'milage')" id="Mileage" placeholder="Enter Mileage"> 
                    </div>
                    </div>
                    
                    @endif
                   
                @if (in_array('owners', json_decode($categories->filters)))
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 " id="ownerParentDiv">
                <div class="form-group">
                <label>{{ __('Number of Owners') }} *</label>
                <select name="number_of_owners" id="" class="form-control validateTextBoxs" onchange="saveDraftData(this , 'owners')">
                <option value="1"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 1 ) selected @endif >1</option>
                <option value="2"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 2 ) selected @endif>2</option>
                <option value="3"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 3 ) selected @endif>3</option>
                <option value="4"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 4 ) selected @endif>4</option>
                <option value="5"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 5 ) selected @endif>5</option>
                <option value="6"   @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 6 ) selected @endif>6</option>
                <option value="7"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 7 ) selected @endif>7</option>
                <option value="8"  @if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 8 ) selected @endif >8</option>
                </select>
                </div>
                </div>
                @endif
                 
                 
                @if (in_array('road-tax', json_decode($categories->filters)))
                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 ">
                <div class="form-group">
                @php
                // Determine the value to display
                $taxValue = !empty($draft_ad->tax) ? $draft_ad->tax : (isset($check_post->tax_fee) ? $check_post->tax_fee : '');
                @endphp
                
                <label>Annual Road Tax </label>
                <input type="number" class="form-control validateTextBoxs" name="annual_road_tax" onfocusout="saveDraftData(this , 'tax')"    value="{{ $taxValue }}"  placeholder="Enter Annual Road Tax" id="carRoadTax" >
                
                
                </div>
                </div>
                @endif
        
                 <input type="hidden" value="{{Auth::guard('vendor')->user()->vendor_info->city}}" name="current_area_regis" />
        
                  <div class="col-lg-12">
                    <div class="form-group">
                     <hr>
                    </div>
                  </div>

                  <div class="col-2" style="width: 130px;">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;">Sale </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" @if($draft_ad == true && !empty($draft_ad->sale) && $draft_ad->sale == '1') checked @endif onchange="saveDraftData(this , 'sale')" name="is_sale" value="1"  id="sale" >
                    </div>
                  </div>
                  
                   <div class="col-2"  style="width: 130px;">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;" id="labael_sold" >Sold </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;" onchange="saveDraftData(this , 'sold')" @if($draft_ad == true && !empty($draft_ad->sold) && $draft_ad->sold == '1') checked @endif  name="is_sold" value="1"  id="sold" >
                    </div>
                  </div>
                  
                  <div class="col">
                    <div class="form-group">
                      <label style="    font-size: 18px !important;"  id="labael_reduced_price">Reduced Price </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;"  name="reduce_price" value="1" @if($draft_ad == true && !empty($draft_ad->reduced_price) && $draft_ad->reduced_price == '1') checked @endif onchange="saveDraftData(this , 'reduced_price')"   id="reduce_price" >
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group" style="padding-left: 0px;padding-right: 0px;">
                      <label style="    font-size: 18px !important;"  id="labael_manager_special">Manager special </label>
                      &nbsp;&nbsp; <input type="checkbox"   style="zoom: 1.3;position: relative;top: 1px;"  name="manager_special"  value="1" @if($draft_ad == true && !empty($draft_ad->manager_special) && $draft_ad->manager_special == '1') checked @endif  onchange="saveDraftData(this , 'manager_special')" id="manager_special" >
                    </div>
                  </div>

                  <div class="col">
                    <div class="form-group">
                      <label style="    font-size: 18px !important;">Deposit  Taken </label>
                      &nbsp;&nbsp; <input type="checkbox"  style="zoom: 1.3;position: relative;top: 1px;"   name="deposit_taken"  value="1" @if($draft_ad == true && !empty($draft_ad->deposit_taken) && $draft_ad->deposit_taken == '1') checked @endif  onchange="saveDraftData(this , 'deposit_taken')"  id="deposit_taken" >
                    </div>
                  </div>


                </div>
                
                
                     </div>
         </div>
  
  @if($categories->id == '44')
    
        <div class="card car_category us_key_feture"  >

        <div class="card-body">
        <div class="row">
    
                <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Comfort & Convenience </b>
                    
                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>

      
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="air_conditioning" type="checkbox"    {{ in_array('air_conditioning', $key_features) ? 'checked' : '' }}   />
                         <label class="lbel">Air Conditioning </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="climate_control" type="checkbox"  {{ in_array('climate_control', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Climate control </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="dual_zone_climate_control" type="checkbox"  {{ in_array('dual_zone_climate_control', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Dual zone  climate control </label>
                    </div>
                </div>

                
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         <input class="chekbox" name="seat_n_vantilation[]" value="seat_vantilation" type="checkbox"  {{ in_array('seat_vantilation', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Seat Ventilation</label>
                    </div>
                </div>
                
                
                 <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         <input class="chekbox" name="electric_n_handbrake[]" value="electric_handbrake" type="checkbox" {{ in_array('electric_handbrake', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Electric Handbrake</label>
                    </div>
                </div>
                

                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="multi_zone_climate_control"  type="checkbox"  {{ in_array('multi_zone_climate_control', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Multi zone  climate control</label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="armrest" type="checkbox" {{ in_array('armrest', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Armrest </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox"  name="comfort_n_convenience[]" value="keyless_entry" type="checkbox"  {{ in_array('keyless_entry', $key_features) ? 'checked' : '' }}/>
                         <label  class="lbel">Keyless Entry </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="electrically_adjustable_seats" type="checkbox"  {{ in_array('electrically_adjustable_seats', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Electrically adjustable seats </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox"  name="comfort_n_convenience[]" value="heated_windshield" type="checkbox" {{ in_array('heated_windshield', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Heated Windshield </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox"  name="comfort_n_convenience[]" value="electric_boot" type="checkbox"  {{ in_array('electric_boot', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Electric boot </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox"  name="comfort_n_convenience[]" value="electric_side_mirrors" type="checkbox" {{ in_array('electric_side_mirrors', $key_features) ? 'checked' : '' }}  />
                         <label class="lbel">Electric side mirrors </label>
                    </div>
                </div>





                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="heated_seats" type="checkbox"  {{ in_array('heated_seats', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Heated seats</label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="heated_steering_wheel" type="checkbox"  {{ in_array('heated_steering_wheel', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Heated steering wheel </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="lumbar_support" type="checkbox" {{ in_array('lumbar_support', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Lumbar support </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="massage_seats" type="checkbox"  {{ in_array('massage_seats', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Massage seats </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox"  name="comfort_n_convenience[]" value="multi_func_steering_wheel" type="checkbox" {{ in_array('multi_func_steering_wheel', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Multi function steering wheel </label>
                    </div>
                </div>



                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                        
                         <input class="chekbox" name="comfort_n_convenience[]" value="rain_sensor" type="checkbox" {{ in_array('rain_sensor', $key_features) ? 'checked' : '' }}/>
                         <label  class="lbel">Rain sensor </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="rain_sensor" type="checkbox"  {{ in_array('rain_sensor', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Spare tyre </label>
                    </div>
                </div>



               
                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                         
                         <input  class="chekbox" name="comfort_n_convenience[]" value="electric_windows" type="checkbox" {{ in_array('electric_windows', $key_features) ? 'checked' : '' }} />
                         <label  class="lbel">Electric windows </label>
                    </div>
                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="gear_shift_paddles" type="checkbox"  {{ in_array('gear_shift_paddles', $key_features) ? 'checked' : '' }}/>
                         <label class="lbel">Gear Shift Paddles </label>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
                    <div class="form-group ">
                       
                         <input class="chekbox" name="comfort_n_convenience[]" value="split_rear_seats" type="checkbox"  {{ in_array('split_rear_seats', $key_features) ? 'checked' : '' }} />
                         <label class="lbel">Split rear seats</label>
                    </div>
                </div>



   </div>
</div>
</div>



<div class="card car_category us_key_feture"  >
<div class="card-body">
<div class="row">

                
                 <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                    <b style="font-size: 20px;">Media & Conectivity </b>
                    
                    <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
                </div>



              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="andriod_auto" type="checkbox" {{ in_array('andriod_auto', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Andriod auto</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="apple_carplay" type="checkbox" {{ in_array('apple_carplay', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Apple Carplay</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="bluetooth" type="checkbox" {{ in_array('bluetooth', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Bluetooth</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="cd" type="checkbox" {{ in_array('cd', $key_features) ? 'checked' : '' }} />
        <label class="lbel">CD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="mp3_compatitble" type="checkbox" {{ in_array('mp3_compatitble', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Mp3 compatible</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="12v_power_outlet" type="checkbox" {{ in_array('12v_power_outlet', $key_features) ? 'checked' : '' }} />
        <label class="lbel">12v power outlet</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="radio" type="checkbox" {{ in_array('radio', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Radio</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="touch_screen_display" type="checkbox" {{ in_array('touch_screen_display', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Touch screen display</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection" type="checkbox" {{ in_array('usb_connection', $key_features) ? 'checked' : '' }} />
        <label class="lbel">USB connection (front)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="usb_connection_rear" type="checkbox" {{ in_array('usb_connection_rear', $key_features) ? 'checked' : '' }} />
        <label class="lbel">USB connection (rear)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="media_n_conectivity[]" value="wifi" type="checkbox" {{ in_array('wifi', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Wifi</label>
    </div>
</div>

                

   </div>
</div>
</div>



  <div class="card car_category us_key_feture"  >
<div class="card-body">
<div class="row">

            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
                <b style="font-size: 20px;">Assistance & Utility </b>
                
                <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
                
              
              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="adaptive_cruise_control" type="checkbox" {{ in_array('adaptive_cruise_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Adaptive cruise control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="cruise_control" type="checkbox" {{ in_array('cruise_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Cruise control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="hill_hold_assist" type="checkbox" {{ in_array('hill_hold_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Hill hold assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="navigation_system" type="checkbox" {{ in_array('navigation_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Navigation system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="self_steering_parking" type="checkbox" {{ in_array('self_steering_parking', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Self-steering parking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_camera" type="checkbox" {{ in_array('parking_camera', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Parking camera</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="front_parking_sensor" type="checkbox" {{ in_array('front_parking_sensor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Front parking sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="rear_parking_sensor" type="checkbox" {{ in_array('rear_parking_sensor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Rear parking sensor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="remote_boot_release" type="checkbox" {{ in_array('remote_boot_release', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Remote boot release</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="roof_rails" type="checkbox" {{ in_array('roof_rails', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Roof rails</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="speed_limiter" type="checkbox" {{ in_array('speed_limiter', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Speed limiter</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="start_stop_system" type="checkbox" {{ in_array('start_stop_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Start-stop system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="traffic_sign_recognition" type="checkbox" {{ in_array('traffic_sign_recognition', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Traffic sign recognition</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="trailer_hitch" type="checkbox" {{ in_array('trailer_hitch', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Trailer hitch</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="voice_control" type="checkbox" {{ in_array('voice_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Voice control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="assistance_n_utility[]" value="parking_assistance" type="checkbox" {{ in_array('parking_assistance', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Parking Assistance</label>
    </div>
</div>


   </div>
</div>
</div>



<div class="card car_category us_key_feture"  >
<div class="card-body">
<div class="row">
    

            <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Styling & Appearance </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

               <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="digital_instrument_panel" type="checkbox" {{ in_array('digital_instrument_panel', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Digital instrument panel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="alloy_wheels" type="checkbox" {{ in_array('alloy_wheels', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Alloy wheels</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="electric_sunroof" type="checkbox" {{ in_array('electric_sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Electric sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_interior" type="checkbox" {{ in_array('leather_interior', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Leather interior</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="leather_steel_wheel" type="checkbox" {{ in_array('leather_steel_wheel', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Leather steering wheel</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="panaramic_sunroof" type="checkbox" {{ in_array('panaramic_sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Panoramic sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="spoiler" type="checkbox" {{ in_array('spoiler', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Spoiler</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sport_seats" type="checkbox" {{ in_array('sport_seats', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sport seats</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="sunroof" type="checkbox" {{ in_array('sunroof', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sunroof</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="tinted_windows" type="checkbox" {{ in_array('tinted_windows', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Tinted windows</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="styling_n_appearance[]" value="steel_wheels" type="checkbox" {{ in_array('steel_wheels', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Steel wheels</label>
    </div>
</div>


    
   </div>
</div>
</div>


 <div class="card car_category us_key_feture"  >
<div class="card-body">
<div class="row">
    

<div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Lighting & Illumination </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>

             <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="night_visson_assist" type="checkbox" {{ in_array('night_visson_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Night vision assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="adaptive_headlights" type="checkbox" {{ in_array('adaptive_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Adaptive headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="ambient_lighting" type="checkbox" {{ in_array('ambient_lighting', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Ambient lighting</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="auto_lights" type="checkbox" {{ in_array('auto_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Auto lights (dusk sensor)</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="bi_xenon_headlights" type="checkbox" {{ in_array('bi_xenon_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Bi-xenon headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="daytime_runing_lights" type="checkbox" {{ in_array('daytime_runing_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Daytime running lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="fog_lights" type="checkbox" {{ in_array('fog_lights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Fog Lights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="high_beam_assist" type="checkbox" {{ in_array('high_beam_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">High beam assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="led_headlights" type="checkbox" {{ in_array('led_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">LED headlights</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="lighting_n_illumination[]" value="xenon_headlights" type="checkbox" {{ in_array('xenon_headlights', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Xenon headlights</label>
    </div>
</div>

    
   </div>
</div>
</div>   



    <div class="card car_category us_key_feture"  >
    <div class="card-body">
    <div class="row">
        
     <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Safety & Security </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
           

              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="abs" type="checkbox" {{ in_array('abs', $key_features) ? 'checked' : '' }} />
        <label class="lbel">ABS</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_change_assist" type="checkbox" {{ in_array('lane_change_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Lane change assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="anti_collision_system" type="checkbox" {{ in_array('anti_collision_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Anti collision system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="alarm_system" type="checkbox" {{ in_array('alarm_system', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Alarm system</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="blind_spot_assist" type="checkbox" {{ in_array('blind_spot_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Blind spot assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_brake_assist" type="checkbox" {{ in_array('emergency_brake_assist', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Emergency brake assist</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="remote_central_locking" type="checkbox" {{ in_array('remote_central_locking', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Remote central locking</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="driver_side_airbag" type="checkbox" {{ in_array('driver_side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Driver-side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="immobilizer" type="checkbox" {{ in_array('immobilizer', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Immobilizer</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="isofix" type="checkbox" {{ in_array('isofix', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Isofix</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="lane_departure_warning" type="checkbox" {{ in_array('lane_departure_warning', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Lane departure warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="tyre_pressure_monitor" type="checkbox" {{ in_array('tyre_pressure_monitor', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Tyre pressure monitor</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="passenger_side_airbag" type="checkbox" {{ in_array('passenger_side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Passenger-side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="seat_belt_warning" type="checkbox" {{ in_array('seat_belt_warning', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Seat belt warning</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="side_airbag" type="checkbox" {{ in_array('side_airbag', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Side airbag</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="stabilty_control" type="checkbox" {{ in_array('stabilty_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Stability control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="traction_control" type="checkbox" {{ in_array('traction_control', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Traction control</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="safety_n_security[]" value="emergency_tyre_repair_kit" type="checkbox" {{ in_array('emergency_tyre_repair_kit', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Emergency tyre repair kit</label>
    </div>
</div>

 
   </div>
</div>
</div>    
    
    
    
     <div class="card car_category us_key_feture" >
<div class="card-body">
<div class="row">
    
     <div class="col-lg-12" style="margin-bottom: 1rem;cursor:pointer;" onclick="openClosestBox(this)">
            <b style="font-size: 20px;">Performance & Handling </b>
            
            <i class="fa fa-caret-down" style="float: right;font-size: 1.5rem;" aria-hidden="true"></i>
            </div>
    
              <div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="air_suspension" type="checkbox" {{ in_array('air_suspension', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Air suspension</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="4wd" type="checkbox" {{ in_array('4wd', $key_features) ? 'checked' : '' }} />
        <label class="lbel">4WD</label>
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-12 us_hide_by_default">
    <div class="form-group">
        <input class="chekbox" name="performance_n_handling[]" value="sport_suspension" type="checkbox" {{ in_array('sport_suspension', $key_features) ? 'checked' : '' }} />
        <label class="lbel">Sport suspension</label>
    </div>
</div>

    
    </div>
</div>
</div>    
    
 

    
  @endif