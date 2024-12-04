@if (in_array('make', json_decode($categories->filters)))
<div class="col-lg-9">
@if ($apiarray['response'] == "manually")

@elseif ($apiarray['response'] == "ItemNotFound" || $apiarray['response'] == "KeyInvalid")
<div class="alert alert-danger">We couldn't find a match. Try again or enter manually.</div>
@else
<div class="alert alert-success">Vehicle details found. Check the details below before publishing your ad </div>
@endif

</div>
@endif
@if (in_array('mileage', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
        <label>Mileage (M) *</label>
        <input type="text" class="form-control" onfocusout="saveDraftData(this , 'milage')"  value="@if($draft_ad == true && !empty($draft_ad->milage)) {{$draft_ad->milage}} @endif"  name="mileage" placeholder="Enter Mileage">
    </div>
    </div>
@endif
@if (in_array('make', json_decode($categories->filters)))

      <div class="col-lg-4">
        <div class="form-group">
        @php

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

        @endphp

        <label>{{ __('Make') }} </label>
        <select name="brand_id" class="form-control carmake js-example-basic-single3 mb-20 select2" data-code="en" onchange="saveDraftData(this, 'make')" id="brandDropdown">
          <option value="">Please Select Make</option>
          <option disabled>-- Popular Brands --</option>
          @foreach ($brands as $brand)
              @php
                  $selected = "";
                  if(isset($check_post) && strcasecmp($check_post->make, $brand->name) == 0) {
                      $brandId = $brand->id;
                      $selected = "selected";
                  } elseif($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) {
                      $brandId = $draft_ad->make;
                      $selected = "selected";
                  }
              @endphp
              <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
          @endforeach
          <option disabled>-- Other Makes --</option>
          @foreach ($otherBrands as $brand)
              @php
                  $selected = "";
                  if(isset($check_post) && strcasecmp($check_post->make, $brand->name) == 0) {
                      $brandId = $brand->id;
                      $selected = "selected";
                  } elseif($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) {
                      $brandId = $draft_ad->make;
                      $selected = "selected";
                  }
              @endphp
              <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
          @endforeach
      </select>
      <script>
        $(document).ready(function() {
            $('#brandDropdown').select2({
                placeholder: "Search for brands...",
                allowClear: true
            });
        });
    </script>

        {{-- <div class="search-container">
          <input type="text" id="search" placeholder="Search for brands..." oninput="filterDropdown()" autocomplete="off" class="form-control">
          <select name="brand_id" class="form-control carmake js-example-basic-single3 mb-20" data-code="en" onchange="saveDraftData(this, 'make')" id="brandDropdown">

            <option value="">Please Select Make</option>
            <option disabled>-- Popular Brands --</option>
            @foreach ($brands as $brand)
              @php
                  $selected = "";
                  if(isset($check_post) && strcasecmp($check_post->make, $brand->name) == 0) {
                      $brandId = $brand->id;
                      $selected = "selected";
                  } elseif($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) {
                      $brandId = $draft_ad->make;
                      $selected = "selected";
                  }
              @endphp
              <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
            @endforeach
            <option disabled>-- Other Makes --</option>
            @foreach ($otherBrands as $brand)
              @php
                  $selected = "";
                  if(isset($check_post) && strcasecmp($check_post->make, $brand->name) == 0) {
                      $brandId = $brand->id;
                      $selected = "selected";
                  } elseif($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) {
                      $brandId = $draft_ad->make;
                      $selected = "selected";
                  }
              @endphp
              <option value="{{ $brand->id }}" {{ $selected }}>{{ $brand->name }}</option>
            @endforeach
          </select>
        </div>
<script>
  function filterDropdown() {
  const input = document.getElementById("search").value.toLowerCase();
  const dropdown = document.getElementById("brandDropdown");
  const options = dropdown.options;

  for (let i = 0; i < options.length; i++) {
    const option = options[i];
    const text = option.textContent || option.innerText;

    if (i === 0 || text.toLowerCase().includes(input)) {
      option.style.display = "";
    } else {
      option.style.display = "none";
    }
  }
}

</script> --}}
        {{-- <select name="brand_id"  class="form-control  carmake js-example-basic-single3" data-code="en"   onchange="saveDraftData(this , 'make')" >
            <option value="" >Please Select Make</option>
             <option disabled>-- Popular Brands --</option>
            @foreach ($brands as $brand)
            @php

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

            @endphp


            <option value="{{ $brand->id }}"  @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif   @php if(isset($check_post)) { if (strcasecmp($check_post->make, $brand->name) == 0)  { echo "selected";} } @endphp>{{ $brand->name }}</option>
            @endforeach
            <option disabled>-- Other Makes --</option>

            @foreach ($otherBrands as $brand)

            @php
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
            @endphp


            <option value="{{ $brand->id }}"   @if($draft_ad == true && !empty($draft_ad->make) && $draft_ad->make == $brand->id) selected @endif  @php if(isset($check_post)) {  if (strcasecmp($check_post->make, $brand->name) == 0)  { echo "selected";} } @endphp>{{ $brand->name }}</option>
            @endforeach
        </select> --}}
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
        @php
        if(isset($brandId))
        {
            $models = App\Models\Car\CarModel::where('brand_id', $brandId)->get();
        }
        @endphp
        <label>{{ __('Model') }} </label>
        <select name="car_model_id" class="form-control  en_car_brand_model_id"   id="carModel"  onchange="saveDraftData(this , 'model')" >
        @if(isset($brandId))
        @foreach ($models as $model)
        <option   @php if(isset($check_post)) { if (strcasecmp($check_post->model, $model->name) == 0) { echo "selected";} } @endphp
        value="{{ $model->id }}"   @if($draft_ad == true && !empty($draft_ad->model) && $draft_ad->model == $model->id) selected @endif    >{{ $model->name }}</option>
        @endforeach
        @else
        <option  value="">Any</option>
        @endif
        </select>
        </div>
    </div>
@endif

    @if (in_array('year', json_decode($categories->filters)))
    <div class="col-lg-4">
            <div class="form-group">
            <label>{{ __('Year') }} </label>
                <input type="text" class="form-control"  value="@if($draft_ad == true && !empty($draft_ad->year)) {{$draft_ad->year}} @else @if(isset($check_post->year)) {{$check_post->year}} @endif @endif  "  onfocusout="saveDraftData(this , 'year')"   placeholder="Enter Year" oninput="checkYearAgo(this)" name="year"/>
            </div>
        </div>
    @endif

    @if (in_array('fuel_types', json_decode($categories->filters)))
    <div class="col-lg-4">
        <div class="form-group">
        @php
            $fuel_types = App\Models\Car\FuelType::where('status', 1)->get();
        @endphp

        <label>{{ __('Fuel Type') }} </label>
        <select name="fuel_type_id" id="fuelType" class="form-control" onchange="changeVal()">
            <option value="" >Please Select Fuel Type</option>

            @foreach ($fuel_types as $fuel_type)

            @if($catID == 48 || $catID == 62)

             @if( $fuel_type->name != 'Diesel')
                <option value="{{ $fuel_type->id }}"
                @if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id) selected @endif
                @php if(isset($check_post->fuel_type)) { if (strcasecmp($check_post->fuel_type, $fuel_type->name) == 0) { echo "selected";} } @endphp>
                {{ $fuel_type->name }}
                </option>
             @endif

            @else
            <option value="{{ $fuel_type->id }}"
             @if($draft_ad == true && !empty($draft_ad->fuel) && $draft_ad->fuel == $fuel_type->id) selected @endif
            @php if(isset($check_post->fuel_type)) {  if (strcasecmp($check_post->fuel_type, $fuel_type->name) == 0){ echo "selected";} } @endphp>
            {{ $fuel_type->name }}
            </option>
            @endif

            @endforeach
        </select>
        </div>
    </div>
    @endif


    @if (in_array('engine', json_decode($categories->filters)))

    @if($draft_ad == true  )


     @if($catID == 48 || $catID == 62 )
        <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
                <label>Engine size (cc)  </label>
                <input type="number" class="form-control" id="addCapacity" name="engineCapacity" value="{{$draft_ad->engine}}"  onfocusout="addnsjfjdfj(this)" />
            </div>
        </div>
    @else

            @if(!empty($draft_ad->fuel) && in_array($draft_ad->fuel , [14,15]) )

            <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
            @php
                $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
            @endphp
            <label>{{ __('Engine size (litres)') }} </label>
                    <select name="engineCapacity" id="engine_sizes" class="form-control" onchange="saveDraftData(this , 'engine')"  >
                        <option value="" >Please Select Engine</option>
                        @foreach ($engine_sizes as $engine)
                            <option  value="{{ $engine->name }}"  @if($draft_ad->engine == $engine->name) selected @endif  >{{ ($engine->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @else
                <div class="col-lg-4" id="new_engine_caacity">
                    <div class="form-group">
                        <label>Engine size (KW) </label>
                        <input type="number" class="form-control" id="addCapacity" name="engineCapacity" value="{{$draft_ad->engine}} "  onfocusout="addnsjfjdfj(this)" />
                    </div>
                </div>
            @endif
    @endif

    @else

        <div class="col-lg-4" id="new_engine_caacity">
            <div class="form-group">
            @php
                $engine_sizes = App\Models\Car\EngineSize::where('status', 1)->get();
            @endphp
            <label>{{ __('Engine size (litres)') }} </label>
            <select name="engineCapacity" id="engine_sizes" class="form-control" onchange="saveDraftData(this , 'engine')"  >
                <option value="" >Please Select Engine</option>
                @foreach ($engine_sizes as $engine)
                 <option  value="{{ $engine->name }}"  >{{ ($engine->name) }}</option>
                @endforeach
                </select>
            </div>
        </div>

     @endif

   @endif

@if (in_array('transmision_type', json_decode($categories->filters)))
<div class="col-lg-4" id="trsmisn_type"   @if($draft_ad == true && !empty($draft_ad->fuel) && !in_array($draft_ad->fuel , [14,15]))  style="display:none;" @endif  >
    <div class="form-group">
        @php
        $transmission_types = App\Models\Car\TransmissionType::where('status', 1)
            ->get();
        @endphp

        <label>{{ __('Transmission Type') }} </label>
        <select name="transmission_type_id" class="form-control" id="transmissionType" onchange="saveDraftData(this , 'transmission')" >
        <option value="" >Please Select Transmission Type</option>

        @foreach ($transmission_types as $transmission_type)
            <option value="{{ $transmission_type->id }}"  @if($draft_ad == true && !empty($draft_ad->transmission) && $draft_ad->transmission == $transmission_type->id) selected @endif  @php if(isset($check_post->transmission)) {  if (strcasecmp($check_post->transmission, $transmission_type->name) == 0) { echo "selected";} } @endphp>{{ $transmission_type->name }}
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
         $body_types = App\Models\Car\BodyType::where('status', 1)->where('cat_id' , $catID)->orderBy('serial_number', 'asc')->get();

         if($body_types->count() == 0)
         {
            $body_types =  App\Models\Car\BodyType::where('status', 1)->orderBy('serial_number', 'asc')->get();
         }
        @endphp
        <label>{{ __('Body Type') }} </label>
        <select name="body_type_id" id="bodyType" class="form-control" onchange="saveDraftData(this , 'body')" >
            <option value="" >Please Select Body Type</option>
        @foreach ($body_types as $body_type)

            <option value="{{ $body_type->id }}" @if($draft_ad == true && !empty($draft_ad->body) && $draft_ad->body == $body_type->id) selected @endif   @php if(isset($apiarray['BodyType'])) { if(ucfirst(strtolower($apiarray['BodyType'])) == $body_type->name){ echo "selected";} } @endphp)>{{ $body_type->name }}
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
    <select name="car_colour_id" class="form-control" id="carColour" onchange="saveDraftData(this , 'color')" >
        <option value="">Please Select Colour</option>

        @foreach ($colour as $colour)
        <option value="{{ $colour->id }}" @if($draft_ad == true && !empty($draft_ad->color) && $draft_ad->color == $colour->id) selected @endif  @php if(isset($check_post->color)) {  if (strcasecmp($check_post->color, $colour->name) == 0) { echo "selected";} } @endphp>{{ $colour->name }}</option>
        @endforeach
    </select>
    </div>
</div>
@endif
@if (in_array('doors', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
    <label>Please Select Doors </label>
    <select name="doors"  class="form-control" id="carDoors" onchange="saveDraftData(this , 'doors')" >
    <option value="">Please Select</option>
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
@if (in_array('seat_count', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group">
    <label>Please Select Seats</label>
    @php
    // Determine the selected value
    $selectedSeats = !empty($draft_ad->seats) ? $draft_ad->seats : ($check_post->seats ?? '');
@endphp

<select name="seats" id="seats" class="form-control" onchange="saveDraftData(this , 'seats')">
    <option value="">Please select...</option>
    <option value="2" {{ $selectedSeats == 2 ? 'selected' : '' }}>2</option>
    <option value="3" {{ $selectedSeats == 3 ? 'selected' : '' }}>3</option>
    <option value="4" {{ $selectedSeats == 4 ? 'selected' : '' }}>4</option>
    <option value="5" {{ $selectedSeats == 5 ? 'selected' : '' }}>5</option>
    <option value="6" {{ $selectedSeats == 6 ? 'selected' : '' }}>6</option>
    <option value="7" {{ $selectedSeats == 7 ? 'selected' : '' }}>7</option>
    <option value="8" {{ $selectedSeats == 8 ? 'selected' : '' }}>8</option>
</select>
    </div>
</div>
@endif
@if (in_array('power', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">
    @php
        $engine_power = App\Models\Car\CarPower::where('status', 1)->get();
    @endphp

    <label>{{ __('Power') }} BHP</label>

      <input type="number" class="form-control"  value="@if($draft_ad == true && !empty($draft_ad->power)){{$draft_ad->power}}@endif"  onfocusout="saveDraftData(this , 'power')"   placeholder="Enter Power"  name="power"/>

    </div>
</div>
@endif
@if (in_array('battery', json_decode($categories->filters)))
<div class="col-lg-4" id="betry_dropdown" @if($draft_ad == true && !empty($draft_ad->fuel) && in_array($draft_ad->fuel , [14,15]))  style="display:none;" @endif>
    <div class="form-group ">

    <label>Battery Range  </label>

    <select name="battery" class="form-control" id="battery" onchange="saveDraftData(this , 'bettery')" >
        <option value=""> Select Range  </option>
        <option value="">{{ __('Any') }}</option>
        <option value="100" @if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 100 ) selected @endif  >100+ M</option>
        <option value="200" @if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 200 ) selected @endif >200+ M</option>
        <option value="300" @if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 300 ) selected @endif >300+ M</option>
        <option value="400" @if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 400 ) selected @endif >400+ M</option>
        <option value="500" @if($draft_ad == true && !empty($draft_ad->bettery) && $draft_ad->bettery == 500 ) selected @endif  >500+ M</option>
    </select>
    </div>
</div>
@endif
@if (in_array('owners', json_decode($categories->filters)))
<div class="col-lg-4">
    <div class="form-group ">

    <label>Please Select Owners</label>
    <select id="owners" class="form-select form-control"  name="owners"  onchange="saveDraftData(this , 'owners')" >
        <option value="">Please Select</option>
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
<div class="col-lg-4">
    <div class="form-group ">

    <label>{{ __('Annual Road Tax') }} </label>

  @php
    // Determine the value to display
    $taxValue = !empty($draft_ad->tax) ? $draft_ad->tax : (isset($check_post->tax_fee) ? $check_post->tax_fee : '');
@endphp

<input type="number" class="form-control"
       value="{{ $taxValue }}"
       onfocusout="saveDraftData(this , 'tax')"
       step="any"
       placeholder="Enter Annual Road Tax"
       name="road_tax"/>


    </div>
</div>
@endif
@if (in_array('verification', json_decode($categories->filters)))
<!-- <div class="col-lg-4">
    <div class="form-group ">

    <label>{{ __('Verification') }} </label>
    <select id="verification" class="form-select form-control"  name="verification">
        <option value="">{{ __('Any') }}</option>
        <option value="manufacture">Manufacturer Approved</option>
        <option value="greenlight" >Greenlight Verified</option>
        <option value="trusted" >Trusted Dealer</option>
    </select>
    </div>
</div> -->
@endif
@if (in_array('warranty', json_decode($categories->filters)))
<div class="col-lg-4" style="display:none;">
    <div class="form-group ">

    <label>Please Select Warranty </label>
    <select id="warranty" class="form-select form-control"  name="warranty">
        <option value="">{{ __('Any') }}</option>
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
@endif
@if (in_array('mot', json_decode($categories->filters)))
<div class="col-lg-4" style="display:none;">
    <div class="form-group ">

    <label>Please Select Mot</label>
    <select id="valid_test" class="form-select form-control"  name="valid_test">
    <option value="">{{ __('Any') }}</option>
    <option value="3" >More than 3 Months</option>
    <option value="6" >More than 6 Months</option>
    <option value="9" >More than 9 Months</option>
    <option value="12" > 12 Months</option>
    <option value="">Not Applicable</option>

    </select>
    </div>
</div>
@endif
