@extends('backend.layout')

{{-- this style will be applied when the direction of language is right-to-left --}}
@includeIf('backend.partials.rtl_style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Cars') }}</h4>
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
        <a href="#">{{ __('Cars Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Cars') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-3">
              <div class="card-title d-inline-block">{{ __('Cars') }}</div>
            </div>

            <div class="col-lg-6">
              <form action="{{ route('admin.car_management.car') }}" method="get" id="carSearchForm">
                <div class="row">
                    
                <input type="hidden" name="status" value="{{request()->status}}" />
                
                <div class="@if(!empty(request()->status)) col-lg-4 @else col-lg-6  @endif">
                <select name="vendor_id" id="" class="select2"
                  onchange="document.getElementById('carSearchForm').submit()">
                    <option value="" disabled>Choose vendor</option>
                  <option value="" >{{ __('All') }}</option>
                  <option value="admin" @selected(request()->input('vendor_id') == 'admin')>{{ __('Admin') }}</option>
                  @foreach ($vendors as $vendor)
                    <option @selected($vendor->id == request()->input('vendor_id')) value="{{ $vendor->id }}">{{ $vendor->username }}</option>
                  @endforeach
                </select>
                </div>
                
                @if(!empty(request()->status))
                
                <div class="col-lg-4">
                <select name="rating" id="" class="select2"
                  onchange="document.getElementById('carSearchForm').submit()">
                  <option value="" selected>Choose rating</option>
                  @for($i=1; $i<=10; $i++)
                    <option @selected($i == request()->input('rating')) value="{{ $i }}">{{$i }}</option>
                  @endfor
                </select>
                </div>
                
                @endif
                
                <div class="@if(!empty(request()->status)) col-lg-4 @else col-lg-6  @endif">
                <input type="text" name="title" value="{{ request()->input('title') }}" class="form-control"  placeholder="Title">
                </div>
                  
                </div>
              </form>
            </div>

            <div class="col-lg-3 mt-2 mt-lg-0">
              <a href="{{ route('admin.cars_management.create_car') }}" class="btn btn-primary btn-sm float-right"><i
                  class="fas fa-plus"></i> {{ __('Add Car') }}</a>

              <button class="btn btn-danger btn-sm float-right mr-2 d-none bulk-delete"
                data-href="{{ route('admin.car_management.bulk_delete.car') }}"><i class="flaticon-interface-5"></i>
                {{ __('Delete') }}</button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($cars) == 0)
                <h3 class="text-center">{{ (empty(request()->status)) ?  __('NO CARS ARE FOUND!') : __('NO REVIEWS FOUND!') }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Vendor') }}</th>
                        <th scope="col">{{ __('Brand') }}</th>
                        <th scope="col">{{ __('Model') }}</th>
                        <th scope="col">{{ __('Featured') }}</th>
                        <th scope="col">{{ __('Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($cars as $car)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $car->id }}">
                          </td>
                          <td>
                            @php
                              $car_content = $car->car_content;
                              if (is_null($car_content)) {
                                  $car_content = $car->car_content()->first();
                              }
                            @endphp
                            @if (!empty($car_content))
                              <a href=" {{ route('frontend.car.details', ['cattitle' => catslug($car_content->category_id),'slug' => $car_content->slug, 'id' => $car->id]) }}"
                                target="_blank">
                                {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                              </a>
                            @endif
                          </td>
                          <td>
                              @if($car->vendor)
                              
                            @if ($car->vendor_id != 0)
                              <a
                                href="{{ route('admin.vendor_management.vendor_details', ['id' => @$car->vendor->id, 'language' => $defaultLang->code]) }}">{{ @$car->vendor->username }}</a>
                            @else
                              <span class="badge badge-success">{{ __('Admin') }}</span>
                            @endif
                            
                            @else
                             Deleted
                            @endif
                          </td>
                          <td>
                            @php
                              if ($car->car_content) {
                                  $brand = $car->car_content->brand()->first();
                              } else {
                                  $brand = null;
                              }
                            @endphp
                            {{ $brand != null ? $brand['name'] : '-' }}
                          </td>
                          <td>
                            @php
                              if ($car->car_content) {
                                  $model = $car->car_content->model()->first();
                              } else {
                                  $model = null;
                              }
                            @endphp
                            {{ $model != null ? $model['name'] : '-' }}
                          </td>
                          <td>
                            @if ($car->vendor_id == 0)
                              <form id="featureForm{{ $car->id }}" class="d-inline-block"
                                action="{{ route('admin.cars_management.update_featured_car') }}" method="post">
                                @csrf
                                <input type="hidden" name="carId" value="{{ $car->id }}">

                                <select
                                  class="form-control {{ $car->is_featured == 1 ? 'bg-success' : 'bg-danger' }} form-control-sm"
                                  name="is_featured"
                                  onchange="document.getElementById('featureForm{{ $car->id }}').submit();">
                                  <option value="1" {{ $car->is_featured == 1 ? 'selected' : '' }}>
                                    {{ __('Yes') }}
                                  </option>
                                  <option value="0" {{ $car->is_featured == 0 ? 'selected' : '' }}>
                                    {{ __('No') }}
                                  </option>
                                </select>
                              </form>
                            @else
                              {{ '-' }}
                            @endif
                          </td>

                          <td>
                            
                            @if(request()->status === 'sold')
                            <span class="text-info">Sold</span>
                            @elseif(request()->input('status') === 'removed')
                            <span class="text-warning">Removed</span>
                            @else

                            <form id="statusForm{{ $car->id }}" class="d-inline-block"
                            action="{{ route('admin.cars_management.update_car_status') }}" method="post">
                            @csrf
                            <input type="hidden" name="carId" value="{{ $car->id }}">
                            
                            <select
                            class="form-control {{ $car->status == 1 ? 'bg-success' : 'bg-danger' }} form-control-sm"
                            name="status"
                            onchange="document.getElementById('statusForm{{ $car->id }}').submit();">
                            <option value="1" {{ $car->status == 1 ? 'selected' : '' }}>
                            {{ __('Active') }}
                            </option>
                            <option value="0" {{ $car->status == 0 ? 'selected' : '' }}>
                            {{ __('Deactive') }}
                            </option>
                            </select>
                            </form>
                            
                            @endif
                            
                          </td>

                          <td>
                              @if(empty(request()->input('status')))
                              
                              @if($car->support_tickets->count() > 0 )
                              <a class="btn btn-info  mt-1 btn-sm mr-1"
                              href="{{ route('admin.support_tickets', ['ad_id' => $car->id]) }}">
                              <span class="btn-label">
                                <i class="fas fa-file"></i>
                              </span>
                            </a>
                              @endif
                              
                            <a class="btn btn-secondary  mt-1 btn-sm mr-1"
                              href="{{ route('admin.cars_management.edit_car', $car->id) }}">
                              <span class="btn-label">
                                <i class="fas fa-edit"></i>
                              </span>
                            </a>
                            
                            @else
                            
                            <a class="btn btn-info  mt-1 btn-sm mr-1" href="javascript:void(0);" title="Read user Remarks" data-remark="{{$car->remove_option}}" data-recommendation="{{$car->recommendation}}" data-remove_remarks="{{$car->remove_remarks}}" onclick="remarksRead(this)">
                              <span class="btn-label">
                                <i class="fas fa-file"></i>
                              </span>
                            </a>
                            
                            @endif

                            <form class="deleteForm d-inline-block"
                              action="{{ route('admin.cars_management.delete_car') }}" method="post">
                              @csrf
                              <input type="hidden" name="car_id" value="{{ $car->id }}">

                              <button type="submit" class="btn btn-danger  mt-1 btn-sm deleteBtn">
                                <span class="btn-label">
                                  <i class="fas fa-trash"></i>
                                </span>
                              </button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              @endif
            </div>
          </div>
        </div>

        <div class="card-footer">
          {{ $cars->appends([
                  'vendor_id' => request()->input('vendor_id'),
                  'title' => request()->input('title'),
                  'status' => request()->input('status'),
                  'language' => request()->input('language'),
              ])->links() }}
        </div>

      </div>
    </div>
  </div>




@endsection
