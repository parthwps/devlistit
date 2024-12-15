@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Signup') }}
  @else
    {{ __('Signup') }}
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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
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
              <div class="card-title d-inline-block">
                  Payment History For invoice # <b>1000{{$invoice->id}}</b>
              </div>
            </div>
            <div class="col-lg-3">
            </div>
            
          </div>
        </div>
           <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($deposits) == 0)
                <h3 class="text-center">{{ __('NO Data FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="dealer_report_table">
                    <thead>
                      <tr>
                        <th scope="col">
                          ID#
                        </th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                         <th scope="col">Remarks</th>
                       <th scope="col">Datetime</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($deposits as $key => $deposit)
                        <tr>
                          <td>
                            {{$key+1}}
                          </td>
                          <td>{{$currency_symbol}}{{ number_format($deposit->amount , 2) }}</td>
                          <td><?= ($invoice->status == 1) ? '<span class="text-primary">Paid</span>' : '<span class="text-danger">Unpaid</span>' ?></td>
                          <td>{{ $deposit->short_des }}</td>
                          <td>{{ date('d F,Y h:i:s' , strtotime($deposit->created_at)) }}</td>
                        
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
           {{ $deposits->links() }}

            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </div>
</div>
@endsection
