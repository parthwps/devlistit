
                           
@if (in_array('make', json_decode($categories->filters))) 
<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
        <h3>{{ __('Vehicle Details') }} </h3>
        <label>Get all your vehicle details instantly</label>
    
        </div>
    </div>
    
</div>
<div class="row" >
<div class="col-lg-10">
    
    
    <div class="form-group">
    <label>{{ __('Enter vehicle registration') }} *</label>
    <div class="input-group mb-3">
        <input type="text" style = "width:60%; height:44px;" class="form-control vregNo-mobile" placeholder="Vehicle registrtion" aria-label="vehicle registrtion" aria-describedby="basic-addon2" name="vregNo" id="vregNo">
        <div class="input-group-append btn-group mr-2">
        <button id="getVehData2" class="btn btn-secondary mr-2" type="button">Find</button>
        <button id="getVehDataManual" class="btn btn-primary mr-2" type="button">Enter Manually</button>
        </div>
        
    </div>

    </div>
</div>

</div>
@endif
            
            