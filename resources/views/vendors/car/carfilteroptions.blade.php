@if (in_array('make', json_decode($categories->filters)))
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mb-3">
                <h3>{{ __('Vehicle Details') }}</h3>
                <label>{{ __('Get all your vehicle details instantly') }}</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group" id="car_registration_section">
                <label>{{ __('Enter vehicle registration') }} *</label>
                <div class="input-group mb-3">
                    <!-- Full-width text input -->
                    <input
                            type="text"
                            class="form-control w-auto"
                            placeholder="Vehicle registration no"
                            aria-label="Vehicle registration"
                            name="vregNo"
                            id="vregNo">

                    <!-- Inline buttons -->
                    <button id="getVehData" class="btn btn-secondary p-2" type="button">
                        Find
                    </button>
                    <button id="getVehDataManual" class="btn btn-primary p-2" type="button">
                        Enter Manually
                    </button>
                </div>
            </div>
        </div>
    </div>


@endif
            
            