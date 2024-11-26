<?php if(in_array('make', json_decode($categories->filters))): ?> 
<div class="col-lg-9">
<?php if($apiarray['response'] == "manually"): ?>  
  
<?php elseif($apiarray['response'] == "ItemNotFound" || $apiarray['response'] == "KeyInvalid"): ?>
<div class="alert alert-danger">We couldn't find a match. Try again or enter manually.</div>
<?php else: ?> 
<div class="alert alert-success">Vehicle details found. Check the details below before publishing your ad </div>
<?php endif; ?> 
 
</div>
<?php endif; ?>
<?php if(in_array('mileage', json_decode($categories->filters))): ?> 
<div class="col-lg-4">
    <div class="form-group">
        <label>Mileage (M) *</label>
        <input type="text" class="form-control" onfocusout="saveDraftData(this , 'milage')"  value="<?php if($draft_ad == true && !empty($draft_ad->milage)): ?> <?php echo e($draft_ad->milage); ?> <?php endif; ?>"  name="mileage" placeholder="Enter Mileage"> 
    </div>
    </div> 
<?php endif; ?>                          
<?php if(in_array('make', json_decode($categories->filters))): ?> 
   
      <div class="col-lg-4">
        <div class="form-group">
        <?php
           
            $brands = App\Models\Car\Brand::where('cat_id', $catID)
            ->where('status', 1)
            ->withCount('cars')
            ->orderBy('cars_count', 'desc')
            ->orderBy('name', 'asc')
            ->take(10) 
            ->get();
            
            $otherBrands = App\Models\Car\Brand::where('cat_id', $catID)
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
         
        ?>

        <label><?php echo e(__('Make')); ?> </label>
        <select name="brand_id"  class="form-control  carmake js-example-basic-single3" data-code="en"   onchange="saveDraftData(this , 'make')" >
            <option value="" >Please Select Make</option>
             <option disabled>-- Popular Brands --</option>
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            
                if(isset($check_post)) 
                {
                    if (strcasecmp($check_post->make, $brand->name) == 0)
                    {
                        $brandId = $brand->id;
                    }
                }
                
                if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                {
                    $brandId = $draft_ad->make;
                } 
                
            ?>
            
            
            <option value="<?php echo e($brand->id); ?>"  <?php if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id): ?> selected <?php endif; ?>   <?php if(isset($check_post)) { if (strcasecmp($check_post->make, $brand->name) == 0)  { echo "selected";} } ?>><?php echo e($brand->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <option disabled>-- Other Makes --</option>
            
            <?php $__currentLoopData = $otherBrands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php
                if(isset($check_post)) 
                {
                    if(strcasecmp($check_post->make, $brand->name) == 0 )
                    {
                        $brandId = $brand->id;
                    }
                }
                
                if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id)
                {
                    $brandId = $draft_ad->make;
                } 
            ?>
            
            
            <option value="<?php echo e($brand->id); ?>"   <?php if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id): ?> selected <?php endif; ?>  <?php if(isset($check_post)) {  if (strcasecmp($check_post->make, $brand->name) == 0)  { echo "selected";} } ?>><?php echo e($brand->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div>     
    </div>
    <div class="col-lg-4">
        <div class="form-group">
        <?php
        if(isset($brandId)) 
        {
            $models = App\Models\Car\CarModel::where('brand_id', $brandId)->get();
        } 
        ?>
        <label><?php echo e(__('Model')); ?> </label>
        <select name="car_model_id" class="form-control  en_car_brand_model_id"   id="carModel"  onchange="saveDraftData(this , 'model')" >
        <?php if(isset($brandId)): ?> 
        <?php $__currentLoopData = $models; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option   <?php if(isset($check_post)) { if (strcasecmp($check_post->model, $model->name) == 0) { echo "selected";} } ?>
        value="<?php echo e($model->id); ?>"   <?php if($draft_ad == true && !empty($draft_ad->model) && $draft_ad->model == $model->id): ?> selected <?php endif; ?>    ><?php echo e($model->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <option  value="">Any</option>
        <?php endif; ?>
        </select>
        </div>
    </div>
<?php endif; ?>
    
    <?php if(in_array('year', json_decode($categories->filters))): ?> 
    <div class="col-lg-4">
            <div class="form-group">
            <label><?php echo e(__('Year')); ?> </label>
                <input type="text" class="form-control"  value="<?php if($draft_ad == true && !empty($draft_ad->year)): ?> <?php echo e($draft_ad->year); ?> <?php else: ?> <?php if(isset($check_post->year)): ?> <?php echo e($check_post->year); ?> <?php endif; ?> <?php endif; ?>  "  onfocusout="saveDraftData(this , 'year')"   placeholder="Enter Year" oninput="checkYearAgo(this)" name="year"/>
            </div>
        </div>
    <?php endif; ?>

    <?php if(in_array('fuel_types', json_decode($categories->filters))): ?>
    <div class="col-lg-4">
        <div class="form-group">
        <?php
            $fuel_types = App\Models\Car\FuelType::where('status', 1)->get();
        ?>
        
        <label><?php echo e(__('Fuel Type')); ?> </label>
        <select name="fuel_type_id" id="fuelType" class="form-control" onchange="changeVal()">
            <option value="" >Please Select Fuel Type</option>
           
            <?php $__currentLoopData = $fuel_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuel_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if($catID == 48 || $catID == 62): ?>
             
             <?php if( $fuel_type->name != 'Diesel'): ?>
                <option value="<?php echo e($fuel_type->id); ?>"
                <?php if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id): ?> selected <?php endif; ?>
                <?php if(isset($check_post->fuel_type)) { if (strcasecmp($check_post->fuel_type, $fuel_type->name) == 0) { echo "selected";} } ?>>
                <?php echo e($fuel_type->name); ?> 
                </option>
             <?php endif; ?>
             
            <?php else: ?>
            <option value="<?php echo e($fuel_type->id); ?>"
             <?php if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id): ?> selected <?php endif; ?>
            <?php if(isset($check_post->fuel_type)) {  if (strcasecmp($check_post->fuel_type, $fuel_type->name) == 0){ echo "selected";} } ?>>
            <?php echo e($fuel_type->name); ?> 
            </option>
            <?php endif; ?>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        </div>
    </div>
    <?php endif; ?>
    
    
    <?php if(in_array('engine', json_decode($categories->filters))): ?>
    
    <?php if($draft_ad == true  ): ?> 
    

     <?php if($catID == 48 || $catID == 62 ): ?>
        <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
                <label>Engine size (cc)  </label>
                <input type="number" class="form-control" id="addCapacity" name="engineCapacity" value="<?php echo e($draft_ad->engine); ?>"  onfocusout="addnsjfjdfj(this)" />
            </div>
        </div>
    <?php else: ?>
    
            <?php if(!empty($draft_ad->fuel) && in_array($draft_ad->fuel , [14,15]) ): ?>
        
            <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
            <?php
                $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
            ?>
            <label><?php echo e(__('Engine size (litres)')); ?> </label>
                    <select name="engineCapacity" id="engine_sizes" class="form-control" onchange="saveDraftData(this , 'engine')"  >
                        <option value="" >Please Select Engine</option>
                        <?php $__currentLoopData = $engine_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option  value="<?php echo e($engine->name); ?>"  <?php if($draft_ad->engine == $engine->name): ?> selected <?php endif; ?>  ><?php echo e(($engine->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            
            <?php else: ?>
                <div class="col-lg-4" id="new_engine_caacity">
                    <div class="form-group">
                        <label>Engine size (KW) </label>
                        <input type="number" class="form-control" id="addCapacity" name="engineCapacity" value="<?php echo e($draft_ad->engine); ?> "  onfocusout="addnsjfjdfj(this)" />
                    </div>
                </div>
            <?php endif; ?>
    <?php endif; ?>
    
    <?php else: ?>
    
        <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
            <?php
                $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
            ?>
            <label><?php echo e(__('Engine size (litres)')); ?> </label>
            <select name="engineCapacity" id="engine_sizes" class="form-control" onchange="saveDraftData(this , 'engine')"  >
                <option value="" >Please Select Engine</option>
                <?php $__currentLoopData = $engine_sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $engine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <option  value="<?php echo e($engine->name); ?>"  ><?php echo e(($engine->name)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    
     <?php endif; ?> 
     
   <?php endif; ?>

<?php if(in_array('transmision_type', json_decode($categories->filters))): ?>
<div class="col-lg-4" id="trsmisn_type"   <?php if($draft_ad == true && !empty($draft_ad->fuel) && !in_array($draft_ad->fuel , [14,15])): ?>  style="display:none;" <?php endif; ?>  >
    <div class="form-group">
        <?php
        $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
            ->get();
        ?>

        <label><?php echo e(__('Transmission Type')); ?> </label>
        <select name="transmission_type_id" class="form-control" id="transmissionType" onchange="saveDraftData(this , 'transmission')" >
        <option value="" >Please Select Transmission Type</option>
        
        <?php $__currentLoopData = $transmission_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transmission_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($transmission_type->id); ?>"  <?php if($draft_ad == true && !empty($draft_ad->transmission) && $draft_ad->transmission == $transmission_type->id): ?> selected <?php endif; ?>  <?php if(isset($check_post->transmission)) {  if (strcasecmp($check_post->transmission, $transmission_type->name) == 0) { echo "selected";} } ?>><?php echo e($transmission_type->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('body_type', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group">
        <?php
         $body_types = App\Models\Car\BodyType::where('status', 1)->where('cat_id' , $catID)->orderBy('serial_number', 'asc')->get();
         
         if($body_types->count() == 0)
         {
            $body_types =  App\Models\Car\BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
         }
        ?>
        <label><?php echo e(__('Body Type')); ?> </label>
        <select name="body_type_id" id="bodyType" class="form-control" onchange="saveDraftData(this , 'body')" >
            <option value="" >Please Select Body Type</option>
        <?php $__currentLoopData = $body_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
            <option value="<?php echo e($body_type->id); ?>" <?php if($draft_ad == true && !empty($draft_ad->body) && $draft_ad->body == $body_type->id): ?> selected <?php endif; ?>   <?php if(isset($apiarray['BodyType'])) { if(ucfirst(strtolower($apiarray['BodyType'])) == $body_type->name){ echo "selected";} } ?>)><?php echo e($body_type->name); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
</div> 
<?php endif; ?>
<?php if(in_array('colour', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group ">
    <?php
        $colour = App\Models\Car\CarColor::where('status', 1)->get();
    ?>

    <label><?php echo e(__('Colour')); ?> </label>
    <select name="car_colour_id" class="form-control" id="carColour" onchange="saveDraftData(this , 'color')" >
        <option value="">Please Select Colour</option>
        
        <?php $__currentLoopData = $colour; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $colour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($colour->id); ?>" <?php if($draft_ad == true && !empty($draft_ad->color) && $draft_ad->color == $colour->id): ?> selected <?php endif; ?>  <?php if(isset($check_post->color)) {  if (strcasecmp($check_post->color, $colour->name) == 0) { echo "selected";} } ?>><?php echo e($colour->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('doors', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group">
    <label>Please Select Doors </label>
    <select name="doors"  class="form-control" id="carDoors" onchange="saveDraftData(this , 'doors')" >
    <option value="">Please Select</option>
    <option value="2" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 2): ?> selected <?php endif; ?> >2</option>
    <option value="3"  <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 3): ?> selected <?php endif; ?>>3</option>
    <option value="4" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 4): ?> selected <?php endif; ?>>4</option>
    <option value="5" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 5): ?> selected <?php endif; ?>>5</option>
    <option value="6" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 6): ?> selected <?php endif; ?>>6</option>
    <option value="7" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 7): ?> selected <?php endif; ?>>7</option>
    <option value="8" <?php if($draft_ad == true && !empty($draft_ad->doors) && $draft_ad->doors == 8): ?> selected <?php endif; ?>>8</option>
    </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('seat_count', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group">
    <label>Please Select Seats</label>
    <?php
    // Determine the selected value
    $selectedSeats = !empty($draft_ad->seats) ? $draft_ad->seats : ($check_post->seats ?? '');
?>

<select name="seats" id="seats" class="form-control" onchange="saveDraftData(this , 'seats')">
    <option value="">Please select...</option>
    <option value="2" <?php echo e($selectedSeats == 2 ? 'selected' : ''); ?>>2</option>
    <option value="3" <?php echo e($selectedSeats == 3 ? 'selected' : ''); ?>>3</option>
    <option value="4" <?php echo e($selectedSeats == 4 ? 'selected' : ''); ?>>4</option>
    <option value="5" <?php echo e($selectedSeats == 5 ? 'selected' : ''); ?>>5</option>
    <option value="6" <?php echo e($selectedSeats == 6 ? 'selected' : ''); ?>>6</option>
    <option value="7" <?php echo e($selectedSeats == 7 ? 'selected' : ''); ?>>7</option>
    <option value="8" <?php echo e($selectedSeats == 8 ? 'selected' : ''); ?>>8</option>
</select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('power', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group ">
    <?php
        $engine_power = App\Models\Car\CarPower::where('status', 1)->get();
    ?>

    <label><?php echo e(__('Power')); ?> BHP</label>
    
      <input type="number" class="form-control"  value="<?php if($draft_ad == true && !empty($draft_ad->power)): ?><?php echo e($draft_ad->power); ?><?php endif; ?>"  onfocusout="saveDraftData(this , 'power')"   placeholder="Enter Power"  name="power"/>
  
    </div>
</div>
<?php endif; ?>
<?php if(in_array('battery', json_decode($categories->filters))): ?>
<div class="col-lg-4" id="betry_dropdown" <?php if($draft_ad == true && !empty($draft_ad->fuel) && in_array($draft_ad->fuel , [14,15])): ?>  style="display:none;" <?php endif; ?>>
    <div class="form-group ">
   
    <label>Battery Range  </label>
    
    <select name="battery" class="form-control" id="battery" onchange="saveDraftData(this , 'bettery')" >
        <option value=""> Select Range  </option>
        <option value=""><?php echo e(__('Any')); ?></option>
        <option value="100" <?php if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 100 ): ?> selected <?php endif; ?>  >100+ M</option>
        <option value="200" <?php if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 200 ): ?> selected <?php endif; ?> >200+ M</option>
        <option value="300" <?php if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 300 ): ?> selected <?php endif; ?> >300+ M</option>
        <option value="400" <?php if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 400 ): ?> selected <?php endif; ?> >400+ M</option>
        <option value="500" <?php if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 500 ): ?> selected <?php endif; ?>  >500+ M</option>
    </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('owners', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group ">
   
    <label>Please Select Owners</label>
    <select id="owners" class="form-select form-control"  name="owners"  onchange="saveDraftData(this , 'owners')" >
        <option value="">Please Select</option>
        <option value="1"  <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 1 ): ?> selected <?php endif; ?> >1</option>
        <option value="2"   <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 2 ): ?> selected <?php endif; ?>>2</option>
        <option value="3"   <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 3 ): ?> selected <?php endif; ?>>3</option>
        <option value="4"   <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 4 ): ?> selected <?php endif; ?>>4</option>
        <option value="5"   <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 5 ): ?> selected <?php endif; ?>>5</option>
        <option value="6"   <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 6 ): ?> selected <?php endif; ?>>6</option>
        <option value="7"  <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 7 ): ?> selected <?php endif; ?>>7</option>
        <option value="8"  <?php if($draft_ad == true && !empty($draft_ad->owners) && $draft_ad->owners == 8 ): ?> selected <?php endif; ?> >8</option>
    </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('road-tax', json_decode($categories->filters))): ?>
<div class="col-lg-4">
    <div class="form-group ">
   
    <label><?php echo e(__('Annual Road Tax')); ?> </label>
    
  <?php
    // Determine the value to display
    $taxValue = !empty($draft_ad->tax) ? $draft_ad->tax : (isset($check_post->tax_fee) ? $check_post->tax_fee : '');
?>

<input type="number" class="form-control"
       value="<?php echo e($taxValue); ?>"
       onfocusout="saveDraftData(this , 'tax')"
       step="any"
       placeholder="Enter Annual Road Tax"
       name="road_tax"/>
    
    
    </div>
</div>
<?php endif; ?>
<?php if(in_array('verification', json_decode($categories->filters))): ?>
<!-- <div class="col-lg-4">
    <div class="form-group ">
   
    <label><?php echo e(__('Verification')); ?> </label>
    <select id="verification" class="form-select form-control"  name="verification">
        <option value=""><?php echo e(__('Any')); ?></option>
        <option value="manufacture">Manufacturer Approved</option>
        <option value="greenlight" >Greenlight Verified</option>
        <option value="trusted" >Trusted Dealer</option>
    </select>
    </div>
</div> -->
<?php endif; ?>
<?php if(in_array('warranty', json_decode($categories->filters))): ?>
<div class="col-lg-4" style="display:none;">
    <div class="form-group ">
   
    <label>Please Select Warranty </label>
    <select id="warranty" class="form-select form-control"  name="warranty">
        <option value=""><?php echo e(__('Any')); ?></option>
        <option value="3 Month" >3 Month</option>
        <option value="6 Month" >6 Month</option>
        <option value="9 Month" >9 Month</option>
        <option value="1 Month" >12 Month</option>
        <option value="2 Year" >2 Year</option>
        <option value="3 Year" >3 Year</option>
        <option value="4 Year" >4 Year</option>
        <option value="5 Year" >5 Year</option>
        <option value="6 Year" >6 Year</option>
        <option value="7 Year" >7 Year</option>
        <option value="8 Year" >8 Year</option>
    </select>
    </div>
</div>
<?php endif; ?>
<?php if(in_array('mot', json_decode($categories->filters))): ?>
<div class="col-lg-4" style="display:none;">
    <div class="form-group ">
   
    <label>Please Select Mot</label>
    <select id="valid_test" class="form-select form-control"  name="valid_test">
    <option value=""><?php echo e(__('Any')); ?></option>
    <option value="3" >More than 3 Months</option>
    <option value="6" >More than 6 Months</option>
    <option value="9" >More than 9 Months</option>
    <option value="12" > 12 Months</option>
    <option value="">Not Applicable</option>
    
    </select>
    </div>
</div>
<?php endif; ?><?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/vehicledetails.blade.php ENDPATH**/ ?>