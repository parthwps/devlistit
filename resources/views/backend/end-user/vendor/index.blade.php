@extends('backend.layout')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Registered Sellers') }}</h4>
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
        <a href="#">{{ __('Sellers Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Registered Sellers') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title">{{ __('All Sellers') }}</div>
            </div>

            <div class="col-lg-8">
              <button class="btn btn-danger btn-sm float-right d-none bulk-delete mr-2 ml-3 mt-1"
                data-href="{{ route('admin.vendor_management.bulk_delete_vendor') }}">
                <i class="flaticon-interface-5"></i> {{ __('Delete') }}
              </button>

              <form class="float-right" style="display: flex;width: 100%;" action="{{ route('admin.vendor_management.registered_vendor') }}" method="GET">

                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;border-radius: 0;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                <input type="hidden" name="dateRange" id="dateRange"/>
                &nbsp;&nbsp;&nbsp;
                <input name="info" type="text" class="form-control min-230"
                  placeholder="Search By Username or Email ID"
                  value="{{ !empty(request()->input('info')) ? request()->input('info') : '' }}">

                 &nbsp; &nbsp;&nbsp;<input type="submit" class="btn btn-success"  value="Search"/>
              </form>
            </div>


          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($vendors) == 0)
                <h3 class="text-center">{{ __('NO Sellers FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                        <th scope="col">
                          <input type="checkbox" class="bulk-check" data-val="all">
                        </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Phone Number</th>
                         <th scope="col">Account Created</th>
                        <th scope="col">{{ __('Account Status') }}</th>
                        <th scope="col">{{ __('Email Status') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($vendors as $vendor)
                        <tr>
                          <td>
                            <input type="checkbox" class="bulk-check" data-val="{{ $vendor->id }}">
                          </td>
                          <td>{{ ucwords($vendor->username) }}</td>
                          <td>{{ ucwords($vendor->email) }}</td>
                          {{-- <td>{{ empty($vendor->phone) ? '-' : $vendor->phone }}</td> --}}
                          <td>
                            @if (empty($vendor->phone))
                                -
                            @else
                            {{ strpos($vendor->phone, '7624') === 0 ? '0' . $vendor->phone : $vendor->phone }}
                            @php
                                    $isIsleOfMan = Str::startsWith($vendor->phone, '07624') || Str::startsWith($vendor->phone, '7624');
                                    // Check if the phone starts with 07624
                                @endphp

                                <!-- Inline Verification Status -->
                                @if ($isIsleOfMan)
                                    <!-- Green Status for Isle of Man -->
                                    <br/>
                                    <span style="color: green; font-weight: bold; margin-left: 10px;display:contents;font-size:13px;">
                                        ✅ Isle of Man
                                    </span>
                                @else($vendor->phone_verified == 1)
                                    <!-- Orange Status for Verified -->
                                    <br/>
                                    <span style="color: orange; font-weight: bold; margin-left: 10px;display:contents;font-size:13px;">
                                      🟧 Verified
                                    </span>
                                @endif
                            @endif
                        </td>

                          <td style="width: 150px;">{{ date('d F,Y' , strtotime($vendor->created_at)) }}</td>
                          <td>
                            <form id="accountStatusForm-{{ $vendor->id }}" class="d-inline-block"
                              action="{{ route('admin.vendor_management.vendor.update_account_status', ['id' => $vendor->id]) }}"
                              method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $vendor->status == 1 ? 'bg-success' : 'bg-danger' }}"
                                name="account_status"
                                onchange="document.getElementById('accountStatusForm-{{ $vendor->id }}').submit()">
                                <option value="1" {{ $vendor->status == 1 ? 'selected' : '' }}>
                                  {{ __('Active') }}
                                </option>
                                <option value="0" {{ $vendor->status == 0 ? 'selected' : '' }}>
                                  {{ __('Deactive') }}
                                </option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <form id="emailStatusForm-{{ $vendor->id }}" class="d-inline-block"
                              action="{{ route('admin.vendor_management.vendor.update_email_status', ['id' => $vendor->id]) }}"
                              method="post">
                              @csrf
                              <select
                                class="form-control form-control-sm {{ $vendor->email_verified_at != null ? 'bg-success' : 'bg-danger' }}"
                                name="email_status"
                                onchange="document.getElementById('emailStatusForm-{{ $vendor->id }}').submit()">
                                <option value="1" {{ $vendor->email_verified_at != null ? 'selected' : '' }}>
                                  {{ __('Verified') }}
                                </option>
                                <option value="0" {{ $vendor->email_verified_at == null ? 'selected' : '' }}>
                                  {{ __('Unverified') }}
                                </option>
                              </select>
                            </form>
                          </td>
                          <td>
                            <div class="dropdown">
                              <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Select') }}
                              </button>

                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.vendor_management.vendor_details', ['id' => $vendor->id, 'language' => $defaultLang->code]) }}"
                                  class="dropdown-item">
                                  {{ __('Details & Package') }}
                                </a>

                                <a href="{{ route('admin.edit_management.vendor_edit', ['id' => $vendor->id]) }}"
                                  class="dropdown-item">
                                  {{ __('Edit') }}
                                </a>

                                <a href="{{ route('admin.vendor_management.vendor.change_password', ['id' => $vendor->id]) }}"
                                  class="dropdown-item">
                                  {{ __('Change Password') }}
                                </a>

                                <form class="deleteForm d-block"
                                  action="{{ route('admin.vendor_management.vendor.delete', ['id' => $vendor->id]) }}"
                                  method="post">
                                  @csrf
                                  <button type="submit" class="deleteBtn">
                                    {{ __('Delete') }}
                                  </button>
                                </form>
                                <a target="_blank"
                                  href="{{ route('admin.vendor_management.vendor.secret_login', ['id' => $vendor->id]) }}"
                                  class="dropdown-item">
                                  {{ __('View Dealer Account') }}
                                </a>
                              </div>
                            </div>
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
          <div class="row">
            <div class="d-inline-block mx-auto">
              {{ $vendors->appends(['info' => request()->input('info')])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@if(!empty(request()->dateRange))
<input type="hidden" value="{{$startdate}}" id="startdate" />
<input type="hidden" value="{{$enddate}}" id="enddate" />
@endif


@endsection



<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

<script type="text/javascript">

$(function() {

    var startDate = $('#startdate').val();
    var endDate = $('#enddate').val();

    // Default format for start and end dates
    var dateFormat = 'YYYY-MM-DD'; // Format from PHP

    // Ensure valid dates
    if (!startDate || !moment(startDate, dateFormat, true).isValid()) {
        startDate = moment().subtract(29, 'days');
    } else {
        startDate = moment(startDate, dateFormat);
    }

    if (!endDate || !moment(endDate, dateFormat, true).isValid()) {
        endDate = moment();
    } else {
        endDate = moment(endDate, dateFormat);
    }


    function cb(selectedStart, selectedEnd) {
        $('#reportrange span').html(selectedStart.format('MMMM D, YYYY') + ' - ' + selectedEnd.format('MMMM D, YYYY'));
        $('#dateRange').val(selectedStart.format('MMMM D, YYYY') + ' - ' + selectedEnd.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function(selectedStart, selectedEnd) {
        cb(selectedStart, selectedEnd);
    });

    cb(moment(startDate), moment(endDate));

});



</script>

