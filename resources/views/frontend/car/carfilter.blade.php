<div id="appendNewFilters">

    @php
        $category_filters = null;

        if(!empty($category->filters))
        {
            $category_filters = json_decode($category->filters , true );
        }
    @endphp

    @if(!empty($filters) && $category->brands()->count() == 0 &&  $category->id != 24)

        <div class="widget widget-select p-0 mb-20">
            <h5 class="title">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#select"
                        aria-expanded="true" aria-controls="select">
                    {{ __('Category') }}
                </button>
            </h5>

            <div id="select" class="collapse show">
                <div class="accordion-body  ">
                    <div class="row gx-sm-3">
                        <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <input type="hidden" name="category" id="category"/>
                                <input type="hidden" name="pid" id="pid"/>
                                <input type="hidden" name="page" value="1" id="pageno">
                                <input type="hidden" name="request_type" value="by_default" id="request_type">
                                <div class="list-group list-group-flush">
                                    @foreach ($categories as $key => $category)
                                        <select class="form-select form-control js-example-basic-single1"
                                                onchange="updatecate(this)" name="category">
                                            <option value="">{{ __('Categories') }}</option>
                                            @foreach ($categories as $categoryValue)
                                                <option value="{{ $categoryValue->slug }}"
                                                        data-category="{{$categoryValue->slug}}"
                                                        data-pid="{{$categoryValue->parent_id}}" @selected($categoryValue->slug == request()->category)>{{ $categoryValue->name }}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget widget-select p-0 mb-20">
            <h5 class="title">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                        aria-expanded="true" aria-controls="location">
                    {{ __('Location') }}
                </button>
            </h5>
            <div id="location" class="collapse show">
                <div class="accordion-body scroll-y">
                    <div class="row gx-sm-3">
                        <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="col-12 float-start">
                                    <select class="form-select form-control js-example-basic-single1"
                                            onchange="updateUrl()" name="location">
                                        <option value="">{{ __('Any') }}</option>
                                        @foreach ($carlocation as $clocation)
                                            <option value="{{ $clocation->slug }}" @selected(request()->input('location') == $clocation->slug)>{{ $clocation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($category_filters && in_array('pricing' , $category_filters))
            <div class="widget widget-price p-0 mb-20">

                <h5 class="title">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#price"
                            aria-expanded="true" aria-controls="price">
                        {{ __('Pricing') }} £
                    </button>
                </h5>

                <div id="price" class="collapse show">
                    <div class="accordion-body scroll-y mt-20">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group" style="padding:10px 0px;">
                                    @if($category->id == 24 || $category->parent_id == 24 || $category->id == 39 || $category->parent_id == 39)

                                        <div class="col-6 float-start">

                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()"
                                                    id="min" name="min">
                                                <option value="">
                                                    {{ __('Min Price') }}
                                                </option>
                                                @foreach ($adsprices as $prices)
                                                    <option value="{{ $prices->name }}" @selected(request()->input('min') == $prices->name)>
                                                        {{ symbolPrice($prices->name) }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-6 float-end">
                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()"
                                                    id="max" name="max">
                                                <option value="">{{ __('Max Price') }}</option>
                                                @foreach ($adsprices as $prices)
                                                    <option value="{{ $prices->name }}" @selected(request()->input('max') == $prices->name)>{{ symbolPrice($prices->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    @else
                                        <div class="col-6 float-start">
                                            <input type="number" name="min" onblur="updateUrl()" class="form-control"
                                                   value="{{request()->input('min')}}" placeholder="min"/>
                                        </div>
                                        <div class="col-6 float-end">
                                            <input type="number" name="max" onblur="updateUrl()" class="form-control"
                                                   value="{{request()->input('max')}}" placeholder="max"/>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="currency_symbol" value="{{ $basicInfo->base_currency_symbol }}">

                    </div>
                </div>
            </div>
        @endif
        @foreach($filters as $key => $filter)

            @php
                $key = str_replace('::'.$filter->type , '' ,  $key);
            @endphp
            <div class="widget widget-select p-0 mb-20">
                <h5 class="title">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#location"
                            aria-expanded="true" aria-controls="location">
                        {{ $key }}
                    </button>
                </h5>

                @if($filter->type == 'select' && !empty($filter->form_options) )
                    <div id="location" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="col-12 float-start">
                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()"
                                                    name="filters_select_{{ strtolower(str_replace(' ' , '_' , $key )) }}">
                                                <option value="">Choose Option</option>
                                                @foreach ($filter->form_options as $form_option)
                                                    <option value="{{ $form_option->value }}">{{ $form_option->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($filter->type == 'radio' && !empty($filter->form_options) )
                    <div id="location" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="col-12 float-start">
                                            <div class="row">
                                                @foreach ($filter->form_options as $form_option)
                                                    <div class="col-md-6 text-black">
                                                        <input type="radio"
                                                               name="filters_radio_{{ strtolower(str_replace(' ' , '_' , $key )) }}"
                                                               onchange="updateUrl()"
                                                               value="{{ $form_option->value }}"/> &nbsp;
                                                        {{ $form_option->value }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($filter->type == 'checkbox' && !empty($filter->form_options))
                    <div id="location" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="col-12 float-start">
                                            <!-- <ul> -->
                                            <!-- <div class="row"> -->
                                            {{-- @foreach ($filter->form_options as $form_option)
                                                <!-- <div class="col-md-6"> -->
                                                  <!-- <li> -->
                                                   <!-- <input type="checkbox" name="filters_checkbox_{{ strtolower(str_replace(' ' , '_' , $key )) }}[]" onchange="updateUrl()" value="{{ $form_option->value }}" />  &nbsp;  <b >{{ $form_option->value }}</b> -->
                                                  <!-- </li> -->
                                                  <!-- </div> -->
                                            @endforeach --}}
                                            <!-- </div> -->
                                            <!-- </ul> -->

                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()"
                                                    name="filters_select_{{ strtolower(str_replace(' ' , '_' , $key )) }}">
                                                <option value="">Choose Option</option>
                                                @foreach ($filter->form_options as $form_option)
                                                    <option value="{{ $form_option->value }}"
                                                            name="filters_checkbox_{{ strtolower(str_replace(' ' , '_' , $key )) }}[]"
                                                            onchange="updateUrl()">
                                                        &nbsp; {{ $form_option->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else



        @if($categories->count() > 0 )

            <div class="widget widget-select p-0 mb-20">
                <h5 class="title">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#select"
                            aria-expanded="true" aria-controls="select"
                            style="color: rgb(88, 97, 118) !important;font-size: 16px;font-family:Lato,sans-serif">
                        {{ __('Category') }}
                    </button>
                </h5>

                <div id="select" class="collapse show">
                    <div class="accordion-body  ">
                        <div class="row gx-sm-3">
                            <div class="col-12">
                                <div class="form-group" style="padding:10px 0px;">
                                    <input type="hidden" name="category" id="category"/>
                                    <input type="hidden" name="pid" id="pid"/>
                                    <input type="hidden" name="page" value="1" id="pageno">
                                    <input type="hidden" name="request_type" value="by_default" id="request_type">
                                    <div class="list-group list-group-flush" id="cat_lisitnfg">

                                        @if(empty(request()->category))

                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updatecate(this)" name="category">
                                                <option value="">{{ __('Categories') }}</option>
                                                @foreach ($categories as $categoryValue)
                                                    <option value="{{ $categoryValue->slug }}"
                                                            data-category="{{$categoryValue->slug}}"
                                                            data-pid="{{$categoryValue->parent_id}}" @selected($categoryValue->slug == request()->category)>{{ $categoryValue->name }}</option>
                                                @endforeach
                                            </select>

                                        @else

                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updatecate(this)" name="category">
                                                <option value="">{{ __('Categories') }}</option>
                                                @foreach ($categories as $categoryValue)
                                                    <option value="{{ $categoryValue->slug }}"
                                                            data-category="{{$categoryValue->slug}}"
                                                            data-pid="{{$categoryValue->parent_id}}" @selected($categoryValue->slug == request()->category)>{{ $categoryValue->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <span @if(empty(request()->category)) style="display:none;" @endif  id="carsFiltrs">
                
                
                <!-- Seller Type -->
                <div class="widget widget-select p-0 mb-20 us">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Seller Type') }}
                      </button>
                    </h5>
                    @php
                        $classSs= '';
                        $classWw= '';
                        $classWr = '';

                        if(request()->input('dealertype') == 'any')
                        {
                            $classSs ='active';
                        }
                        else if(request()->input('dealertype') == 'dealer')
                        {
                            $classWr ='active';
                        }
                        else if(request()->input('dealertype') == 'private')
                        {
                            $classWw ='active';
                        }
                    @endphp

                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                     <div class="col-4 float-start">
                                         <div class="form-check">
                                              <input class="form-check-input ms-0 dealer_type" type="checkbox"
                                                     name="dealer_type[]" value="dealer" id="dealer" @checked(is_array(request('dealer_type')) && in_array('dealer',request('dealer_type')))>
                                              <label class="form-check-label ms-4" for="dealer">
                                                Dealer
                                              </label>
                                         </div>
                                     </div>
                                    <div class="col-4 float-end">
                                      <div class="form-check">
                                              <input class="form-check-input ms-0 dealer_type" type="checkbox"
                                                     name="dealer_type[]" value="normal" id="private" @checked(is_array(request('dealer_type')) && in_array('normal',request('dealer_type')))>
                                              <label class="form-check-label ms-4" for="private">
                                                Private
                                              </label>
                                         </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
             @if($category_filters && in_array('make' , $category_filters))

                <div class="widget widget-ratings p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ratings"
                              aria-expanded="true" aria-controls="ratings">
                        {{ __('Makes') }}
                      </button>
                    </h5>
                    <div id="ratings" class="collapse show">
                      <div class="accordion-body scroll-y mt-20">
                        <ul class="list-group custom-checkbox">
                          @php
                              if (!empty(request()->input('brands'))) {
                                  $selected_brands = [];
                                  if (is_array(request()->input('brands'))) {
                                      $selected_brands = request()->input('brands');
                                  } else {
                                      array_push($selected_brands, request()->input('brands'));
                                  }
                              } else {
                                  $selected_brands = [];
                              }
                          @endphp

                        <select class="form-select form-control js-example-basic-single1 makeclickable"
                                onchange="updateUrl()" name="brands[]">

                                <option value="">{{ __('All Makes') }}</option>
                                <option disabled>-- Popular Brands --</option>
                            @foreach ($brands->sortBy('name') as $brand)
                                <option value="{{ $brand->slug }}" {{ $category_filters && in_array($brand->slug, $selected_brands) ? 'selected' : '' }} >{{ $brand->name }}</option>
                            @endforeach

                                <option disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-- Other Makes --</option>
                            @foreach ($otherBrands as $brand)
                                <option value="{{ $brand->slug }}" {{ $category_filters && in_array($brand->slug, $selected_brands) ? 'selected' : '' }} >{{ $brand->name }}</option>
                            @endforeach

                        </select>

                        </ul>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif

            @if($category_filters && in_array('model' , $category_filters))

                <div class="widget widget-ratings p-0 mb-20">
                      <h5 class="title">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#models" aria-expanded="true" aria-controls="models">
                          {{ __('Models') }}
                        </button>
                      </h5>

                      <div id="models" class="collapse show">
                        <div class="accordion-body scroll-y mt-20">
                          <ul class="list-group custom-checkbox" id="appendModels">

                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                      name="models[]">
                                <option value="">{{ __('Select Model') }}</option>

                               </select>

                          </ul>
                        </div>
                      </div>
                    </div>
                <hr/>
            @endif
            @if($category_filters && in_array('year' , $category_filters))

                <!-- Year -->
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#accordian-year" aria-expanded="true" aria-controls="select">
                        {{ __('Year') }}
                      </button>
                    </h5>
                    <div id="accordian-year" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col" float-start>
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                      id="year_min" name="year_min">
                                <option value="">{{ __('Min Year') }}</option>
                                @foreach ($caryear as $year)
                                      <option
                                              value="{{ $year->name }}" @selected(request()->input('year_min') == $year->name)>{{ $year->name }}</option>
                                  @endforeach
                              </select>


                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                id="year_max" name="year_max">
                                <option value="">{{ __('Max Year') }}</option>
                                @foreach ($caryear as $year)
                                <option
                                        value="{{ $year->name }}" @selected(request()->input('year_max') == $year->name)>{{ $year->name }}</option>
                            @endforeach
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('pricing' , $category_filters))

                <div class="widget widget-price p-0 mb-20">

                    <h5 class="title">
                          <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#price" aria-expanded="true" aria-controls="price">
                                {{ __('Pricing') }} £
                          </button>
                    </h5>

                    <div id="price" class="collapse show">
                        <div class="accordion-body scroll-y mt-20">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">

                                         @if($category->id == 24 || $category->parent_id == 24 || $category->id == 39 || $category->parent_id == 39)

                                            <div class="col-6 float-start custom_col">

                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()" name="min">
                                                        <option value="">
                                                            {{ __('Min Price') }}
                                                        </option>
                                                    @foreach ($adsprices as $prices)
                                                    <option value="{{ $prices->name }}" @selected(request()->input('min') == $prices->name)>
                                                            {{ symbolPrice($prices->name) }}
                                                        </option>
                                                @endforeach
                                            </select>

                                        </div>
                                            <div class="col-6 float-end custom_col">
                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()"
                                                    name="max">
                                                <option value="">{{ __('Max Price') }}</option>
                                                @foreach ($adsprices as $prices)
                                                    <option value="{{ $prices->name }}" @selected(request()->input('max') == $prices->name)>{{ symbolPrice($prices->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        @else
                                            <div class="col-6 float-start">
                                            <input type="number" name="min" onblur="updateUrl()" class="form-control"
                                                   value="{{request()->input('min')}}" placeholder="min"/>
                                            </div>
                                            <div class="col-6 float-end">
                                            <input type="number" name="max" onblur="updateUrl()" class="form-control"
                                                   value="{{request()->input('max')}}" placeholder="max"/>
                                             </div>
                                        @endif


                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="currency_symbol" value="{{ $basicInfo->base_currency_symbol }}">

                        </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('mileage' , $category_filters))

                <!-- Mileage -->
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#accordion-mileage" aria-expanded="true" aria-controls="select">
                        {{ __('Mileage (Miles)') }}
                      </button>
                    </h5>
                    <div id="accordion-mileage" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col" float-start>
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                      id="mileage_min" name="mileage_min">
                                <option value="">{{ __('Min ') }}</option>
                               @foreach ($adsmileage as $mileage)
                                      <option
                                              value="{{ $mileage->name }}" @selected(request()->input('mileage_min') == $mileage->name)>{{ ($mileage->name) }}</option>
                                  @endforeach
                              </select>
                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                id="mileage_max" name="mileage_max">
                                <option value="">{{ __('Max ') }}</option>
                                @foreach ($adsmileage as $mileage)
                                <option
                                        value="{{ $mileage->name }}" @selected(request()->input('mileage_max') == $mileage->name)>{{ ($mileage->name) }}</option>
                            @endforeach
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('location' , $category_filters))
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title">
                      <button class="accordion-button mb-3" type="button" data-bs-toggle="collapse"
                              data-bs-target="#location"
                              aria-expanded="true" aria-controls="location">
                        {{ __('Location') }}
                      </button>
                    </h5>
                    <div id="location" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                             <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start">
                                 <select class="form-select form-control js-example-basic-single1 mb-3" disabled>
                                <option value="">{{ __('Isle Of Man') }}</option>
                              </select>
                              <select class="form-select form-control js-example-basic-single1" onchange="updateUrl()"
                                      name="location">
                                <option value="">{{ __('Any') }}</option>
                                    @foreach ($carlocation as $clocation)
                                      <option value="{{ $clocation->slug }}" @selected(request()->input('location') == $clocation->slug)>{{ $clocation->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <hr/>
            @endif
            @if($category_filters && in_array('fuel_types' , $category_filters))

                <!-- Fuel Types -->
                <div class="widget widget-select p-0 mb-20 mt-2">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Fuel Types') }}
                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                    @foreach ($fuel_types->sortBy('name') as $fuel_type)
                                        <div class="col-12 float-start">
                                             <div class="form-check">
                                                  <input class="form-check-input ms-0 fuel_type" onchange="updateUrl()"
                                                         type="checkbox" name="fuelTypeArray[]"
                                                         value="{{ $fuel_type->slug }}" id="{{ $fuel_type->slug }}" @checked(is_array(request('fuelTypeArray')) && in_array($fuel_type->slug,request('fuelTypeArray')))>
                                                  <label class="form-check-label ms-4" for="{{ $fuel_type->slug }}">
                                                    {{ $fuel_type->name }}
                                                  </label>
                                             </div>
                                         </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('transmision_type' , $category_filters))

                <!-- Transmission Types -->
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#transmission" aria-expanded="true" aria-controls="transmission">
                        {{ __('Transmission') }}
                      </button>
                    </h5>
                    <div id="transmission" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                    @foreach ($transmission_types->sortBy('name') as $transmission_type)
                                        <div class="col-12 float-start">
                                             <div class="form-check">
                                                  <input class="form-check-input ms-0" onchange="updateUrl()"
                                                         type="checkbox" name="transmissionTypeArray[]"
                                                         value="{{ $transmission_type->slug }}" id="{{ $transmission_type->slug }}" @checked(is_array(request('transmissionTypeArray')) && in_array($transmission_type->slug,request('transmissionTypeArray')))>
                                                  <label class="form-check-label ms-4" for="{{ $transmission_type->slug }}">
                                                    {{ $transmission_type->name }}
                                                  </label>
                                             </div>
                                         </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>

            @endif
            @if($category_filters && in_array('body_type' , $category_filters))

                <!-- Body Types -->
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#body-type" aria-expanded="true" aria-controls="select">
                        {{ __('Body Types') }}
                      </button>
                    </h5>
                    <div id="body-type" class="collapse show body-type-filter">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-xl-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                    @foreach ($body_type->sortBy('name') as $bodytype)
                                        <div class="col-6 float-start">
                                             <div class="form-check">
                                                 <label for="{{ $bodytype->slug }}">
                                                      <img src="{{ $bodytype->image ? asset('assets/img/body_types/'.$bodytype->image) : asset('assets/img/noimage.jpg')  }}">
                                                 </label>
                                                  <input class="form-check-input ms-0 d-none" onchange="updateUrl()"
                                                         type="checkbox" name="bodyTypeArray[]"
                                                         value="{{ $bodytype->slug }}" id="{{ $bodytype->slug }}" @checked(is_array(request('bodyTypeArray')) && in_array($bodytype->slug,request('bodyTypeArray')))>
                                                  <label class="form-check-label body-type-filter-label mb-0" for="{{ $bodytype->slug }}">
                                                                {{ $bodytype->name }}

                                                              </label>
                                             </div>
                                        </div>
                                      @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>

            @endif
            @if($category_filters && in_array('engine' , $category_filters))

                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#engine_size"
                                aria-expanded="true" aria-controls="engine_size">
                            {{ __('Engine Size') }}
                        </button>
                    </h5>
                    <div id="engine_size" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="row">
                                            <div class="col-12 float-start">
                                                <select class="form-select form-control js-example-basic-single1"
                                                        onchange="updateUrl()" name="engine_size">
                                                    <option value="">{{ __('Any') }}</option>
                                                    @foreach ($engine_sizes as $engine_size)
                                                        <option value="{{ $engine_size }}" @selected(request()->input('engine_size') == $engine_size)>{{ $engine_size }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            @if($category_filters && in_array('power' , $category_filters))

                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#engine_power"
                                aria-expanded="true" aria-controls="engine_power">
                            {{ __('Engine Power') }}
                        </button>
                    </h5>
                    <div id="engine_power" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="row">
                                            <div class="col-12 float-start">
                                                <select class="form-select form-control js-example-basic-single1"
                                                        onchange="updateUrl()" name="engine_power">
                                                    <option value="">{{ __('Any') }}</option>
                                                    @foreach ($engine_power as $engine_power_value)
                                                        <option value="{{ $engine_power_value }}" @selected(request()->input('engine_power') == $engine_power_value)>{{ $engine_power_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if($category_filters && in_array('battery' , $category_filters))
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#accordion-battery" aria-expanded="true" aria-controls="accordion-battery">
                        {{ __('Battery Range') }}
                      </button>
                    </h5>
                    <div id="accordion-battery" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                @php
                                    $batteryArray = ['100+ M','200+ M','300+ M','400+ M','500+ M'];
                                @endphp
                                <div class="row">
                                    <div class="col-12 float-start">
                                        <select class="form-select form-control js-example-basic-single1"
                                                onchange="updateUrl()" name="battery">
                                            <option value="">{{ __('Any') }}</option>
                                            @foreach ($batteryArray as $batteryValue)
                                                <option value="{{ $batteryValue }}" @selected(request()->input('battery') == $batteryValue)>{{ $batteryValue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
               </div>
                <hr/>
            @endif
            @if($category_filters && in_array('seat_count' , $category_filters))

                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Seat count') }}
                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-6 float-start custom_col">
                              <select class="form-select form-control" onchange="updateUrl()" name="seat_min">
                                <option value="">{{ __('Min') }}</option>
                               <option value="2" @selected(request()->input('seat_min') == 2)>2</option>
                                <option value="3" @selected(request()->input('seat_min') == 3)>3</option>
                                <option value="4" @selected(request()->input('seat_min') == 4)>4</option>
                                <option value="5" @selected(request()->input('seat_min') == 5)>5</option>
                                <option value="6" @selected(request()->input('seat_min') == 6)>6</option>
                                <option value="7" @selected(request()->input('seat_min') == 7)>7</option>
                                <option value="8" @selected(request()->input('seat_min') == 8)>8</option>
                              </select>


                            </div>
                        <div class="col-6 float-end custom_col">
                        <select class="form-select form-control" onchange="updateUrl()" name="seat_max">
                                <option value="">{{ __('Max') }}</option>
                              <option value="2" @selected(request()->input('seat_max') == 2)>2</option>
                                <option value="3" @selected(request()->input('seat_max') == 3)>3</option>
                                <option value="4" @selected(request()->input('seat_max') == 4)>4</option>
                                <option value="5" @selected(request()->input('seat_max') == 5)>5</option>
                                <option value="6" @selected(request()->input('seat_max') == 6)>6</option>
                                <option value="7" @selected(request()->input('seat_max') == 7)>7</option>
                                <option value="8" @selected(request()->input('seat_max') == 8)>8</option>
                              </select>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('doors' , $category_filters))
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Number of doors') }}
                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                @php
                                    $doorsArray = [2,3,4,5,6];
                                @endphp
                                <div class="row">
                                    @foreach($doorsArray as $doorValue)
                                        <div class="col-12 float-start">
                                             <div class="form-check">
                                                  <input class="form-check-input ms-0" onchange="updateUrl()"
                                                         type="checkbox" name="doors[]"
                                                         value="{{ $doorValue  }}" id="doors-{{ $doorValue }}" @checked(is_array(request('doors')) && in_array($doorValue,request('doors')))>
                                                  <label class="form-check-label ms-4" for="doors-{{ $doorValue }}">
                                                                {{ $doorValue  }}
                                                              </label>
                                             </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
               </div>
                <hr/>
            @endif
            <!-- Colour -->
            @if($category_filters && in_array('colour' , $category_filters))

                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#colour-filter" aria-expanded="true" aria-controls="select">
                        {{ __('Colour') }}
                      </button>
                    </h5>
                    <div id="colour-filter" class="collapse show colour-filter">
                      <div class="accordion-body scroll-y">
                        <div class="row gx-sm-3">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                     @foreach ($car_conditions->sortBy('name') as $car_condition)
                                        <div class="col-6 float-start">
                                             <div class="form-check">
                                                 <label for="{{ $car_condition->slug }}">
                                                       @if(!in_array($car_condition->slug,['other-colour','any-colour']))
                                                         <div class="car-color-code" style="background-color: {{ $car_condition->hex_code  }}"></div>
                                                     @else
                                                         <div class="car-color-code" style="background-color: transparent;"></div>
                                                     @endif
                                                 </label>
                                                  <input class="form-check-input ms-0 d-none" onchange="updateUrl()"
                                                         type="checkbox" name="colourTypeArray[]"
                                                         value="{{ $car_condition->slug }}" id="{{ $car_condition->slug }}" @checked(is_array(request('colourTypeArray')) && in_array($car_condition->slug,request('colourTypeArray')))>
                                                  <label class="form-check-label colour-filter-label mb-0" for="{{ $car_condition->slug }}">
                                                    {{ $car_condition->name }}
                                                  </label>
                                             </div>
                                         </div>
                                    @endforeach
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif
            @if($category_filters && in_array('road-tax' , $category_filters))

                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#road_tax"
                                aria-expanded="true" aria-controls="road_tax">
                            {{ __('Road Tax') }}
                        </button>
                    </h5>
                    <div id="road_tax" class="collapse show">
                        <div class="accordion-body scroll-y">
                            <div class="row gx-sm-3">
                                <div class="col-12">
                                    <div class="form-group" style="padding:10px 0px;">
                                        <div class="col-12 float-start">
                                            <select class="form-select form-control js-example-basic-single1"
                                                    onchange="updateUrl()" name="road_tax">
                                                <option value="">{{ __('Any') }}</option>
                                                @foreach ($road_taxes as $road_tax)
                                                    <option value="{{ $road_tax }}" @selected(request()->input('road_tax') == $road_tax)>{{ $road_tax }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            @if($category_filters && in_array('owners' , $category_filters))
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Number of owners') }}
                      </button>
                    </h5>
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                             <div class="col-12 float-start" float-start>
                              <select class="form-select form-control" onchange="updateUrl()" name="owners">
                                <option value="">{{ __('Any') }}</option>
                                <option value="1" @selected(request()->input('owners') == 1)>1</option>
                                <option value="2" @selected(request()->input('owners') == 2)>2</option>
                                <option value="3" @selected(request()->input('owners') == 3)>3</option>
                                <option value="4" @selected(request()->input('owners') == 4)>4</option>
                                <option value="5" @selected(request()->input('owners') == 5)>5</option>
                                <option value="6" @selected(request()->input('owners') == 6)>6</option>
                                <option value="7" @selected(request()->input('owners') == 7)>7</option>
                                <option value="8" @selected(request()->input('owners') == 8)>8</option>
                                
                              </select>

                             
                            </div>
                       
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
               </div>
                <hr/>

            @endif
            <!-- Car filters end here -->
                  <!-- Aad Type -->
            @if(!empty($category->id))
                <div class="widget widget-select p-0 mb-20">
                    <h5 class="title mb-3">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                              data-bs-target="#select3" aria-expanded="true" aria-controls="select">
                        {{ __('Ad Type') }} 
                      </button>
                    </h5>
                    @php

                        $classS= '';

                        $classW= '';

                        if(request()->input('adtype') == 'sale')
                        {
                            $classS ='active';
                        }
                        else if(request()->input('adtype') == 'wanted')
                        {
                            $classW ='active';
                        }

                    @endphp
                    <div id="select3" class="collapse show">
                      <div class="accordion-body scroll-y">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group" style="padding:10px 0px;">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                              <input class="ms-0" onchange="updateUrl()"
                                                     type="radio" name="adtype"
                                                     value="sale" id="adtype-sale" @checked(request('adtype') == 'sale')>
                                              <label class="mb-0 ms-2" for="adtype-sale">Sale</label>
                                         </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                              <input class="ms-0" onchange="updateUrl()"
                                                     type="radio" name="adtype"
                                                     value="wanted" id="adtype-wanted" @checked(request('adtype') == 'wanted')>
                                              <label class="mb-0 ms-2" for="adtype-wanted">Wanted</label>
                                         </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <hr/>
            @endif


            @if( !empty($filters))

                @foreach($filters as $key => $filter)

                    @php
                        $key = str_replace('::'.$filter->type , '' ,  $key);
                    @endphp
                    <div class="widget widget-select p-0 mb-20">
                        <h5 class="title mb-3">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#location"
                                    aria-expanded="true" aria-controls="location">
                            {{ $key }}
                            </button>
                        </h5>
                        
                        @if($filter->type == 'select' && !empty($filter->form_options) )
                            <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                  <select class="form-select form-control js-example-basic-single1"
                                                          onchange="updateUrl()"
                                                          name="filters_select_{{ strtolower(str_replace(' ' , '_' , $key )) }}">
                                                    <option value="">Choose Option</option>
                                                        @foreach ($filter->form_options as $form_option)
                                                          <option value="{{ $form_option->value }}">{{ $form_option->value }}</option>
                                                      @endforeach
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($filter->type == 'radio' && !empty($filter->form_options) )
                            <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                 <div class="row">
                                                        @foreach ($filter->form_options as $form_option)
                                                         <div class="col-md-6 text-black">
                                                               <input type="radio"
                                                                      name="filters_radio_{{ strtolower(str_replace(' ' , '_' , $key )) }}"
                                                                      onchange="updateUrl()"
                                                                      value="{{ $form_option->value }}"/>  &nbsp;  {{ $form_option->value }}
                                                            </div>
                                                     @endforeach
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($filter->type == 'checkbox' && !empty($filter->form_options))
                            <div id="location" class="collapse show">
                            <div class="accordion-body scroll-y">
                                <div class="row gx-sm-3">
                                    <div class="col-12">
                                         <div class="form-group" style="padding:10px 0px;">
                                             <div class="col-12 float-start"> 
                                                 <div class="row">
                                                        @foreach ($filter->form_options as $form_option)
                                                         <div class="col-md-6 text-black">
                                                               <input type="checkbox"
                                                                      name="filters_checkbox_{{ strtolower(str_replace(' ' , '_' , $key )) }}[]"
                                                                      onchange="updateUrl()"
                                                                      value="{{ $form_option->value }}"/>  &nbsp;  {{ $form_option->value }}
                                                            </div>
                                                     @endforeach
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <hr/>
                @endforeach
            @endif
            @endif
            </span>

        <!-----------------Filter Model ------------------->

        <div class="modal fade" id="saveSearchModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 999;">

            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">

                <div class="modal-content">

                    <div class="modal-body">

                        <div class="alert alert-success" role="alert" style="display:none;" id="alertSuccess">
                            Your Searches has been saved!
                        </div>

                        <h5 style="margin-bottom: 1rem;margin-top: 1rem;"><i class="fal fa-star fa-lg"
                                                                             style="color: orange;"></i> &nbsp; Save
                            this search</h5>

                        <label class="mb-2">Name Your Search</label>

                        <input type=text name="save_search_name" required id="save_search_name" class="form-control"/>

                        <input type="hidden" name="search_url" value="" id="search_url"/>

                        <div style="margin-top: 1rem;background: #f1f1f1;padding: 1rem;border-radius: 7px;">

                            <label class="mb-2">How you want to get notify for this search?</label>

                            <p>
                                <input type="radio" name="alertType" value="2" required/> <span
                                        style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> Yes, daily alert</span>
                            </p>

                            <p>
                                <input type="radio" name="alertType" value="1" required/> <span
                                        style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> Yes, instant alert</span>
                            </p>

                            <p>
                                <input type="radio" name="alertType" value="0" required/> <span
                                        style="font-size: 13px;font-weight: 600;font-family: sans-serif;"> No alert</span>
                            </p>

                        </div>
                    </div>

                    <div class="modal-footer" style="">
                        <button type="button"
                                style="background: transparent !important;border: 1px solid gray !important;color: gray;padding-left: 1.9rem;padding-right: 1.9rem;"
                                class="btn btn-secondary" onclick="closeSaveModal()">Cancel
                        </button>
                        <button type="button" class="btn btn-info" id="searchFormBtn"
                                style="background: #0000c1 !important;color: white;" onclick="saveSearch()">Save Search
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <!-------------END--------------------------------->


</div>
<script>
    $(document).ready(function () {
        // Store all the original options of max year dropdown
        var $yearMax = $('#mileage_max');
        var originalOptions = $yearMax.find('option').clone();

        $('#mileage_min').change(function () {
            var selectedMinYear = parseInt($(this).val());

            // Reset max year dropdown
            $yearMax.empty().append('<option value="">{{ __('Max ') }}</option>');

            // Filter and add options greater than the selected min year
            originalOptions.filter(function () {
                var yearValue = parseInt($(this).val());
                return yearValue === "" || yearValue > selectedMinYear;
            }).appendTo($yearMax);

            // Trigger change event on max year dropdown to update any dependent elements
            $yearMax.trigger('change');
        });
    });

    // year limit min max
    $(document).ready(function () {
        // Store all the original options of max year dropdown
        var $yearMax = $('#year_max');
        var originalOptions = $yearMax.find('option').clone();

        $('#year_min').change(function () {
            var selectedMinYear = parseInt($(this).val());

            // Reset max year dropdown
            $yearMax.empty().append('<option value="">{{ __('Max Year') }}</option>');

            // Filter and add options greater than the selected min year
            originalOptions.filter(function () {
                var yearValue = parseInt($(this).val());
                return yearValue === "" || yearValue > selectedMinYear;
            }).appendTo($yearMax);

            // Trigger change event on max year dropdown to update any dependent elements
            $yearMax.trigger('change');
        });
    });


    function formatCurrency(number) {
        return '£' + new Intl.NumberFormat('en-GB', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // format and limit min price
    $(document).ready(function () {
        // Function to format number as currency without symbol
        function formatCurrency(number) {
            return new Intl.NumberFormat('en-GB', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        // Store all the original options of max price dropdown
        var $priceMax = $('#max');
        var originalOptions = $priceMax.find('option').clone();

        // Format initial options
        $('#min option, #max option').each(function () {
            var value = $(this).val();
            if (value !== "") {
                $(this).text(formatCurrency(parseInt(value)));
            }
        });

        $('#min').change(function () {
            var selectedMinPrice = parseInt($(this).val());
            $priceMax.empty().append('<option value="">{{ __('Max Price') }}</option>');
            originalOptions.filter(function () {
                var priceValue = parseInt($(this).val());
                return priceValue === "" || priceValue > selectedMinPrice;
            }).each(function () {
                var $option = $(this).clone();
                if ($option.val() !== "") {
                    $option.text(formatCurrency(parseInt($option.val())));
                }
                $option.appendTo($priceMax);
            });
            $priceMax.trigger('change');
        });
    });
</script>