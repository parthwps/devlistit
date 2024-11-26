@extends('backend.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Add Dealer') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{ route('admin.dashboard') }}">
          <i class="flaticon-home"></i>
        </a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Dealer Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Add Dealer') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-12">
              <div class="card-title">{{ __('Add Dealer') }}</div>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <form id="ajaxEditForm" action="{{ route('admin.vendor_management.save-vendor') }}" method="post">
                @csrf
                <div class="row">
                  <div class="col-lg-12">
                    <div class="form-group">
                      <label for="">{{ __('Photo') }}</label>
                      <br>
                      <div class="thumb-preview">
                        <img src="{{ asset('assets/img/noimage.jpg') }}" alt="..." class="uploaded-img">
                      </div>
                      <div class="mt-3">
                        <div role="button" class="btn btn-primary btn-sm upload-btn">
                          {{ __('Choose Photo') }}
                          <input type="file" class="img-input" name="photo">
                        </div>
                        <p id="editErr_photo" class="mt-1 mb-0 text-danger em"></p>
                      </div>
                    </div>
                  </div>

                <input type="hidden" name="vendor_type" value="dealer" />
              
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Username*') }}</label>
                      <input type="text" value="" class="form-control"  autocomplete="new-username" name="username"
                        placeholder="{{ __('Enter Username') }}">
                      <p id="editErr_username" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Password *') }}</label>
                      <input type="password" value="" class="form-control"  autocomplete="new-password" name="password"
                        placeholder="{{ __('Enter Password') }} ">
                      <p id="editErr_password" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Email*') }}</label>
                      <input type="text" value="" class="form-control"  autocomplete="new-email" name="email"
                        placeholder="{{ __('Enter Email') }}">
                      <p id="editErr_email" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="form-group">
                      <label>{{ __('Phone') }}</label>
                      <input type="tel" value="" class="form-control"  name="phone"
                        placeholder="{{ __('Enter Phone') }}">
                      <p id="editErr_phone" class="mt-1 mb-0 text-danger em"></p>
                    </div>
                  </div>

                </div>
                
                
                <div class="col-lg-12">
                        <div class="form-group">
                                <label style="width: 100%;
                                background: #9f9b9b;
                                padding: 15px;
                                text-align: center;
                                color: white !important;
                                border-radius: 5px;
                                margin-bottom: 2rem;">
                                    Opening Hours
                                </label>
                            
                            <table style='width: 100%;'>
                                    <tr>
                                        <th>Day</th>
                                        <th>Opening Time</th>
                                        <th>Closing Time</th>
                                        <th>Closed</th>
                                    </tr>
                                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                    <tr>
                                        <td style="margin-right:150px;">{{ $day }}</td>
                                        <td>
                                        <input type="time" name="opening_hours[{{ strtolower($day) }}][open_time]" value="" style="margin-top: 1rem;" class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="time" name="opening_hours[{{ strtolower($day) }}][close_time]" value="" style="margin-top: 1rem;    margin-left: 1rem;"  class="form-control" required>
                                        </td>
                                        <td>
                                        <input type="checkbox" name="opening_hours[{{ strtolower($day) }}][holiday]"   style="margin-top: 10px;margin-left: 1rem;zoom: 2;"  value="1">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        
                        
                        </div>
                    </div>
                    
                    
                    
                <div id="accordion" class="mt-5">
                  @foreach ($languages as $language)
                    <div class="version">
                      <div class="version-header" id="heading{{ $language->id }}">
                        <h5 class="mb-0">
                          <button type="button"
                            class="btn btn-link {{ $language->direction == 1 ? 'rtl text-right' : '' }}"
                            data-toggle="collapse" data-target="#collapse{{ $language->id }}"
                            aria-expanded="{{ $language->is_default == 1 ? 'true' : 'false' }}"
                            aria-controls="collapse{{ $language->id }}">
                            {{ $language->name . __(' Language') }} {{ $language->is_default == 1 ? '(Default)' : '' }}
                          </button>
                        </h5>
                      </div>

                      <div id="collapse{{ $language->id }}"
                        class="collapse {{ $language->is_default == 1 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $language->id }}" data-parent="#accordion">
                        <div class="version-body">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>{{ __('Name*') }}</label>
                                <input type="text" value="" class="form-control"
                                  name="{{ $language->code }}_name" placeholder="{{ __('Enter Name') }}">
                                <p id="editErr_{{ $language->code }}_name" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>{{ __('Country') }}</label>
                                <input type="text"  class="form-control"
                                  name="{{ $language->code }}_country" readonly value="Isle of Man" placeholder="{{ __('Enter Country') }}">
                                <p id="editErr_{{ $language->code }}_country" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                             <div class="col-lg-4">
                              <div class="form-group">
                                <label>Area</label>
                                
                                    <select name="{{ $language->code }}_city" id="" class="form-control">
                                        <option value="">Please select...</option>
                                        @foreach ($countryArea as $area)
                                            <option value="{{ $area->slug }}" >{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                    
                                <p id="editErr_{{ $language->code }}_city" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Established Year</label>
                                
                                   <select name="est_year" class="form-control" id="yearpicker" ></select>
                                    
                                <p id="est_year" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Website Url</label>
                                <input type="text" value="" class="form-control"
                                  name="website_link" placeholder="{{ __('Enter Website Url') }}">
                                <p id="website_link" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Customer ID For Google Review</label>
                                <input type="text" value="" class="form-control"
                                  name="google_review_id" placeholder="{{ __('Enter Customer ID For Google Review') }}">
                              </div>
                            </div>
                            
                            
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>{{ __('Address') }}</label>
                                <textarea name="{{ $language->code }}_address" class="form-control" placeholder="{{ __('Enter Address') }}"></textarea>
                                <p id="editErr_{{ $language->code }}_email" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="form-group">
                                <label>{{ __('About Us') }}</label>
                                <textarea name="{{ $language->code }}_details" class="form-control" rows="5"
                                  placeholder="{{ __('Enter Details') }}"></textarea>
                                <p id="editErr_{{ $language->code }}_details" class="mt-1 mb-0 text-danger em"></p>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-lg-12">
                              @php $currLang = $language; @endphp

                              @foreach ($languages as $language)
                                @continue($language->id == $currLang->id)

                                <div class="form-check py-0">
                                  <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox"
                                      onchange="cloneInput('collapse{{ $currLang->id }}', 'collapse{{ $language->id }}', event)">
                                    <span class="form-check-sign">{{ __('Clone for') }} <strong
                                        class="text-capitalize text-secondary">{{ $language->name }}</strong>
                                      {{ __('language') }}</span>
                                  </label>
                                </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" id="updateBtn" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
