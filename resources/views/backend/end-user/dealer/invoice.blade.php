@extends('backend.layout')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __(' Dealers Invoices') }}</h4>
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
        <a href="#">{{ __('Invoices Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Invoices</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
        
        <div class="row" style="padding: 1rem 2rem 0rem;background: #f9f9f9;margin: 1rem 0;border-radius: 10px;box-shadow: 0px 0px 10px #d4d4d4;">
            
              <div class="col-md-6">
                  <b style="font-size: 1.4rem;">Total Paid</b>
                  <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($paidSum , 2)}}</p>
              </div>
              
              <div class="col-md-6">
                  <b  style="font-size: 1.4rem;">Total UnPaid</b>
                  <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($unpaidSum , 2)}}</p>
              </div>
              
        </div>
            
            
      <div class="card">
        <div class="card-header">
            
           
          <div class="row">
              
              
            <div class="col-lg-4">
              <div class="card-title">All Invoices</div>
            </div>
            
            <div class="col-lg-8 " >
                
              <!--   <button class="btn btn-secondary btn-sm float-right  mr-2 ml-3 mt-1"   id="downloadPdfButton">-->
              <!--   PDF-->
              <!--</button>-->
              
            </div>
            
             <div class="col-lg-12 ">
                 <hr>
                 </div>
            <div class="col-lg-12 ">
                
              <form  action="{{route('admin.edit_management.invoice')}}" method="GET" style="display: flex;margin: 10px 0px;">
                
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;border-radius: 0;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                
                <input type="hidden" name="id" value="{{$vendor_id}}" />
                
                <input type="hidden" name="dateRange" id="dateRange"/>
                
                <select class="form-control" name="status">
                    <option value="" >Select Payment Status</option>
                    <option value="any" @if(request()->status == 'any')  selected @endif >Any</option>
                    <option value="paid" @if(request()->status == 'paid')  selected @endif>Paid</option>
                    <option value="unpaid" @if(request()->status == 'unpaid')  selected @endif >Unpaid</option>
                </select>
               
               <input type="text" placeholder="Search by username or invoice no" value="{{request()->search_query}}" class="form-control" name="search_query" />
               
                <button type="submit" style="margin-left: 1rem;" class="btn btn-primary">Filter</button>
                
                @if(!empty(request()->type) || !empty(request()->dateRange))
                    <a href="{{route('admin.edit_management.invoice' , ['id' => $vendor_id])}}" style="    margin-left: 1rem;" class="btn btn-info">Clear</a>
                @endif
                
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
                        <th scope="col">Dealer</th>
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
                          <td class="text-primary">
                            {{$invoice->vendor ? $invoice->vendor->username : 'Deleted'}}
                          </td>
                          
                          <td>{{$currency_symbol}} {{ $invoice->history->sum('amount') }}</td>
                          <td>{{$invoice->history->count()}}</td>
                          <td>
                              <?= ($invoice->status == 1) ? '<span class="text-primary"><b>Paid </b><br> '.date('d M Y h:i:s', strtotime($invoice->paid_at)).'</span>' : '<span class="text-danger">Unpaid</span>' ?>
                           </td>
                          <td>{{ date('d F', strtotime($invoice->created_at)) }} &nbsp;<b>to</b>&nbsp; {{ date('7 F', strtotime('+1 month', strtotime($invoice->created_at))) }}</td>
                          <td>
                              @if($invoice->status == 0)
                              <a title="mark as paid"  class="btn btn-sm btn-primary"  href="javascript:void(0);" onclick="changeStatusInvoice({{$invoice->id}} , 1)" >
                                  <i class="fa fa-check"></i>
                              </a>
                              @else
                              <a title="mark as unpaid"  class="btn btn-sm btn-primary"  href="javascript:void(0);" onclick="changeStatusInvoice({{$invoice->id}} , 0)" >
                                  <i class="fa fa-ban"></i>
                              </a>
                              @endif
                              
                               <a title="View Payment Logs"  class="btn btn-sm btn-info" href="{{ route('admin.edit_management.deposit', ['id' => $invoice->id]) }}">
                                  <i class="fa fa-eye"></i>
                              </a>
                              
                              
                              <a title="Delete" class="btn btn-sm btn-danger " href="javascript:void(0);" onclick="removeInvoice({{$invoice->id}})">
                                  <i class="fa fa-times"></i>
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
  
  
    
@if(!empty(request()->dateRange))
<input type="hidden" value="{{$startdate}}" id="startdate" /> 
<input type="hidden" value="{{$enddate}}" id="enddate" /> 
@endif


@endsection
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>



<script type="text/javascript">
    
    function changeStatusInvoice(invoice_id , status)
    {
        if(status == 1)
        {
           $msg = 'Are you sure you want to mark this invoice as paid?' 
        }
        else
        {
            $msg = 'Are you sure you want to mark this invoice as unpaid?' 
        }
        
        if(confirm($msg))
        {
            window.location.href="invoice/status/change/"+invoice_id+"/"+status
        }
        
        
    }
    
    function removeInvoice(invoice_id)
    {
        if(confirm('Are you sure you want to delete all data?'))
        {
            window.location.href="invoice/delete/"+invoice_id
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('downloadPdfButton').addEventListener('click', function() {
        var element = document.getElementById('dealer_report_table');
    
        // Generate a file name with the current date and time
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().split('T')[0];
        var formattedTime = currentDate.toTimeString().split(' ')[0].replace(/:/g, '-'); // Replace colons with dashes
        var fileName = 'dealer_report_' + formattedDate + '_' + formattedTime + '.pdf';
    
        // Use html2pdf to generate the PDF with the customized file name
        html2pdf(element, {
            filename: fileName,
            margin: 10, // Adjust margin as needed
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
            pagebreak: { mode: 'avoid-all' },
            tableExtraCSS: 'border-collapse: collapse; width: 100%;', // Ensure table layout is correct
            tableWidth: 'auto' // Specify the table width
        });
    });
    });
    
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


