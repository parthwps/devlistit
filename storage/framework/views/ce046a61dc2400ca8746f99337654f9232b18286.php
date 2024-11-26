
                           
<?php if(in_array('make', json_decode($categories->filters))): ?> 
<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
        <h3><?php echo e(__('Vehicle Details')); ?> </h3>
        <label>Get all your vehicle details instantly</label>
    
        </div>
    </div>
    
</div>
<div class="row" >
<div class="col-lg-10">
    
    
    <div class="form-group" id="car_registration_section">
    <label><?php echo e(__('Enter vehicle registration')); ?> *</label>
    <div class="input-group mb-3">
        <input type="text" style = "width:60%; height:44px;" class="form-control vregNo-mobile" placeholder="Vehicle registration no" aria-label="vehicle registrtion" aria-describedby="basic-addon2" name="vregNo" id="vregNo">
        <div class="input-group-append btn-group mr-2">
        <button id="getVehData" class="btn btn-secondary mr-2" type="button">Find</button>
        <button id="getVehDataManual" class="btn btn-primary mr-2" type="button">Enter Manually</button>
        </div>
        
    </div>
    
    

    </div>
</div>

</div>
<?php endif; ?>
            
            <?php /**PATH /home/u673667181/domains/listit.im/public_html/resources/views/vendors/car/carfilteroptions.blade.php ENDPATH**/ ?>