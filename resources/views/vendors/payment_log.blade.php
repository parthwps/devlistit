@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Payment History') }}
  @else
    {{ __('Payment History') }}
  @endif
@endsection
@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keywords_vendor_signup }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_vendor_signup }}
  @endif
@endsection

@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => $bgImg->breadcrumb,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Payment History'),
  ])
  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
      
  
      
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
   

    
    <div class="col-md-9">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Payment Log') }}</div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              <form action="{{ url()->current() }}" class="d-inline-block float-right">
                <input class="form-control" type="text" name="search"
                  placeholder="{{ __('Search by Transaction ID') }}"
                  value="{{ request()->input('search') ? request()->input('search') : '' }}">
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($memberships) == 0)
                <h3 class="text-center">{{ __('No Record Found') }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                      <th scope="col">{{ __('Title') }}</th>
                        <th scope="col">{{ __('Transaction Id') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                        <th scope="col">{{ __('Payment Status') }}</th>
                        
                        <th scope="col">{{ __('Download Receipt') }}</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($memberships as $key => $membership)
                           @php
                            $tranTitle = App\Models\Car::where('order_id', $membership->order_id)->first();
                          @endphp
                        @if($tranTitle)
                        <tr>
                        <td>
                          
                        <b>{{$tranTitle->car_content->title}}</b><br>
                       
                        {{format_price($tranTitle->price)}}
                        </td>
                          <td>
                            
                            {{ strlen($membership->transaction_id) > 30 ? mb_substr($membership->transaction_id, 0, 30, 'UTF-8') . '...' : $membership->transaction_id }}
                          </td>
                          @php
                            $bex = json_decode($membership->settings);
                          @endphp
                          <td>
                            @if ($membership->price == 0)
                              {{ __('Free') }}
                            @else
                              {{ format_price($membership->price) }}
                            @endif
                          </td>
                          <td>
                            @if ($membership->status == 1)
                              <h3 class="d-inline-block badge badge-success">{{ __('Success') }}</h3>
                            @elseif ($membership->status == 0)
                              <h3 class="d-inline-block badge badge-warning">{{ __('Pending') }}</h3>
                            @elseif ($membership->status == 2)
                              <h3 class="d-inline-block badge badge-danger">{{ __('Rejected') }}</h3>
                            @endif
                          </td>
                          
                          <td>
                            
                              <a class="btn btn-sm btn-info" href="{{ asset('assets/front/invoices/')}}/{{$membership->order_id}}-{{$membership->transaction_id}}.pdf" download>{{ __('Download') }}</a>
                         
                          </td>
                         <!--  <td>
                            @if (!empty($membership->name !== 'anonymous'))
                              <a class="btn btn-sm btn-info" href="#" data-toggle="modal"
                                data-target="#detailsModal{{ $membership->id }}">{{ __('Detail') }}</a>
                            @else
                              -
                            @endif
                          </td> -->
                        </tr>
                        @endif
                        <div class="modal fade" id="receiptModal{{ $membership->id }}" tabindex="-1" role="dialog"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Receipt Image') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                @if (!empty($membership->receipt))
                                  <img src="{{ asset('assets/front/img/membership/receipt/' . $membership->receipt) }}"
                                    alt="Receipt" width="100%">
                                @endif
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal fade" id="detailsModal{{ $membership->id }}" tabindex="-1" role="dialog"
                          aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('Owner Details') }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <h3 class="text-warning">{{ __('Member details') }}</h3>
                                <label>{{ __('Name') }}</label>
                                <p>{{ $membership->vendor->first_name . ' ' . $membership->vendor->last_name }}</p>
                                <label>{{ __('Email') }}</label>
                                <p>{{ $membership->vendor->email }}</p>
                                <label>{{ __('Phone') }}</label>
                                <p>{{ $membership->vendor->phone_number }}</p>
                                <h3 class="text-warning">{{ __('Payment details') }}</h3>
                                <p><strong>{{ __('Package Price') }}: </strong> {{ $membership->price }}
                                </p>
                                <p><strong>{{ __('Currency') }}: </strong> {{ $membership->currency }}
                                </p>
                                <p><strong>{{ __('Method') }}: </strong> {{ $membership->payment_method }}
                                </p>
                                <h3 class="text-warning">{{ __('Package Details') }}</h3>
                                <p><strong>{{ __('Title') }}:
                                  </strong>{{ !empty($membership->package) ? $membership->package->title : '' }}
                                </p>
                               
                                <p><strong>{{ __('Start Date') }}: </strong>
                                  @if (\Illuminate\Support\Carbon::parse($membership->start_date)->format('Y') == '9999')
                                    <span class="badge badge-danger">{{ __('Never Activated') }}</span>
                                  @else
                                    {{ \Illuminate\Support\Carbon::parse($membership->start_date)->format('M-d-Y') }}
                                  @endif
                                </p>
                               
                                <p>
                                  <strong>{{ __('Purchase Type') }}: </strong>
                                  @if ($membership->is_trial == 1)
                                    {{ __('Trial') }}
                                  @else
                                    {{ $membership->price == 0 ? 'Free' : 'Regular' }}
                                  @endif
                                </p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                  {{ __('Close') }}
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
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
              {{ $memberships->links() }}
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </div>
</div>
@endsection
