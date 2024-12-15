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
        
        <div class="row mb-10">
            <div class="col-md-6" style="">
                    <div style="    background: white;
                    padding: 20px 10px 5px 20px;
                    border-radius: 5px;
                    box-shadow: 0px 0px 10px #dddddd;">
                    <b style="font-size: 1.4rem;">Total Paid</b>
                    <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($paidSum , 2)}}</p>
                    </div>
              </div>
              
              <div class="col-md-6">
                    <div style="    background: white;
                    padding: 20px 10px 5px 20px;
                    border-radius: 5px;
                    box-shadow: 0px 0px 10px #dddddd;">
                  <b  style="font-size: 1.4rem;">Total UnPaid</b>
                  <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($unpaidSum , 2)}}</p>
                   </div>
              </div>
        </div>
      <div class="card">
        <div class="card-header">
      
        
          <div class="row">
            
        
        
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Invoices') }}</div>
            </div>
           
            <div class="col-lg-8">
              <form action="{{ url()->current() }}" style="float: right;" class="d-inline-block float-right"  id="filterForm">
                
                 <select style="padding: 10px;color: #9d9d9d;border: 1px solid #d5d5d5;border-radius: 6px;" name="status" onchange="submitUrl(this)">
                    <option value="" >Select Payment Status</option>
                    <option value="any" @if(request()->status == 'any')  selected @endif >Any</option>
                    <option value="paid" @if(request()->status == 'paid')  selected @endif>Paid</option>
                    <option value="unpaid" @if(request()->status == 'unpaid')  selected @endif >Unpaid</option>
                </select>
                
                
              </form>
            </div>
          </div>
        </div>
          <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($invoices) == 0)
                <h3 class="text-center">{{ __('NO Data FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="dealer_report_table">
                    <thead>
                      <tr>
                        <th scope="col">
                            Invoice no
                        </th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment logs</th>
                        <th scope="col">Status</th>
                       <th scope="col">Month</th>
                       <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($invoices as $key => $invoice)
                        <tr>
                          <td>
                            1000{{$invoice->id}}
                          </td>
                        
                          
                          <td>{{$currency_symbol}} {{ $invoice->history->sum('amount') }}</td>
                          <td>{{$invoice->history->count()}}</td>
                          <td>
                              <?= ($invoice->status == 1) ? '<span class="text-primary"><b>Paid </b><br> '.date('d M Y h:i:s', strtotime($invoice->paid_at)).'</span>' : '<span class="text-danger">Unpaid</span>' ?>
                           </td>
                          <td>{{ date('d F', strtotime($invoice->created_at)) }} &nbsp;<b>to</b>&nbsp; {{ date('7 F', strtotime('+1 month', strtotime($invoice->created_at))) }}</td>
                          <td>
                            
                               <a title="View Payment Logs"  class="btn btn-sm btn-info" href="{{ route('vendor.invoice_payment_log', ['id' => $invoice->id]) }}">
                                  <i class="fa fa-eye"></i>
                              </a>
                              
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
           {{ $invoices->links() }}

            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </div>
</div>

<script>
    function submitUrl(self)
    {
      $('#filterForm').submit();
    }
</script>
@endsection
