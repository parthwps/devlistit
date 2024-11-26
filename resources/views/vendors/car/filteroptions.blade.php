          
                        @if (in_array('verification', json_decode($cat->filters))) 
                        <!-- <div class="col-lg-4">
                            <div class="form-group">
                            <label>{{ __('Verification') }} *</label>
                                <select id="verification" class="form-select form-control" onchange="updateUrl()" name="verification">
                                  <option value="">{{ __('Any') }}</option>
                                  <option value="manufacture" >Manufacturer Approved</option>
                                  <option value="greenlight" >Greenlight Verified</option>
                                  <option value="trusted">Trusted Dealer</option>
                              </select>
                          
                          </div>
                        </div> -->
                         
                        @endif
                        @if (in_array('colour', json_decode($cat->filters))) 
                        <div class="col-lg-4">
                              <div class="form-group ">
                                @php
                                  $colour = App\Models\Car\CarColor::where('status', 1)
                                      ->get();
                                @endphp

                                <label>{{ __('Colour') }} *</label>
                                <select name="en_car_condition_id" class="form-control" id="carColour">
                                  <option value="">{{ __('Select Colour') }}</option>

                                  @foreach ($colour as $colour)
                                    <option value="{{ $colour->id }}">{{ $colour->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                            @if (in_array('make', json_decode($cat->filters))) 
                            <div class="row" >
                                <div class="col-lg-8 ">
                                    <div class="form-group">
                                    <h3>{{ __('Vehicle Details') }} </h3>
                                    <label>Get all your vehicle details instantly</label>
                                
                                    </div>
                                </div>
                                
                                </div>
                                <div class="row " >
                            <div class="col-lg-8 ">
                              <div class="form-group">
                                <label>{{ __('Enter vehicle registration') }} *</label>
                                <div class="input-group mb-3">
                                  <input type="text" class="form-control" placeholder="Vehicle registrtion" aria-label="vehicle registrtion" aria-describedby="basic-addon2" name="vregNo" id="vregNo">
                                  <div class="input-group-append">
                                    <button id="getVehData" class="btn btn-secondary" type="button">Find</button>
                                  </div>
                                </div>
                            
                              </div>
                            </div>
                            
                          </div>


                            @endif
            
            