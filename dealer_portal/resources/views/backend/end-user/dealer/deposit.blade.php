@extends('backend.layout')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __(' Dealers Deposits') }}</h4>
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
        <a href="#">{{ __('Deposits Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Deposits History</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
        
        <div class="row" style="padding: 1rem 2rem 0rem;background: #f9f9f9;margin: 1rem 0;border-radius: 10px;box-shadow: 0px 0px 10px #d4d4d4;">
            
              <div class="col-md-6">
                  <b style="font-size: 1.4rem;">Total deposit</b>
                  <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($total_deposit , 2)}}</p>
              </div>
              
              <div class="col-md-6">
                  <b  style="font-size: 1.4rem;">Total deduct</b>
                  <p style="font-size: 17px;margin-left: 5px;font-weight: 600;">{{$currency_symbol}}{{number_format($total_withdrwal , 2)}}</p>
              </div>
              
        </div>
            
            
      <div class="card">
        <div class="card-header">
            
           
          <div class="row">
              
              
            <div class="col-lg-4">
              <div class="card-title">All Deposits History</div>
            </div>
            
            <div class="col-lg-8 " >
                
                 <button class="btn btn-secondary btn-sm float-right  mr-2 ml-3 mt-1"   id="downloadPdfButton">
                 PDF
              </button>
              
              
                  <button class="btn btn-primary btn-sm float-right  mr-2 ml-3 mt-1" onclick="openDepositModal()" >
                 Deposit
              </button>
              
              <button class="btn btn-warning btn-sm float-right  mr-2 ml-3 mt-1"  onclick="openDeductModal()">
                 Deduct
              </button>
              
              
            </div>
            
             <div class="col-lg-12 ">
                 <hr>
                 </div>
            <div class="col-lg-12 ">
                
              <form  action="{{route('admin.edit_management.deposit')}}" method="GET" style="display: flex;margin: 10px 0px;">
                
                <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;border-radius: 0;">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                
                <input type="hidden" name="id" value="{{$deposit_id}}" />
                <input type="hidden" name="dateRange" id="dateRange"/>
                
                <select class="form-control" name="type"   style="    margin-left: 1rem;border:1px solid #ccc">
                    <option value="">Select Option</option>
                    <option value="deposit"  <?=(request()->type == 'deposit') ? 'selected' : ''  ?> >Deposit</option>
                    <option value="withdrawl" <?=(request()->type == 'withdrawl') ? 'selected' : ''  ?> >Deduct</option>
                    <option value="spotlight" <?=(request()->type == 'spotlight') ? 'selected' : ''  ?> >Spotlight</option>
                </select>
                
                
                <button type="submit" style="margin-left: 1rem;" class="btn btn-primary">Filter</button>
                
                @if(!empty(request()->type) || !empty(request()->dateRange))
                <a href="{{route('admin.edit_management.deposit' , ['id' => $deposit_id])}}" style="    margin-left: 1rem;" class="btn btn-info">Clear</a>
                @endif
                
              </form>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($deposits) == 0)
                <h3 class="text-center">{{ __('NO Dealers FOUND') . '!' }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3" id="dealer_report_table">
                    <thead>
                      <tr>
                        <th scope="col">
                          ID#
                        </th>
                        <th scope="col">Dealer</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Type</th>
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
                          <td>{{ $deposit->vendor->username }}</td>
                          <td>{{$currency_symbol}}{{ number_format($deposit->amount , 2) }}</td>
                          <td><?= ($deposit->deposit_type == 'deposit') ? '<span class="text-primary">Deposit</span>' : '<span class="text-danger">Deduct</span>' ?></td>
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
  
  
    <div class="modal fade" id="deposit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deposit Amount  &nbsp; &nbsp; <span style="color:black;">[ balance {{$currency_symbol}}{{number_format($vendor->amount ,2)}}] </span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>            
          <div class="modal-body">
             <form method="post" action="{{route('admin.vendor_management.save-deposit')}}">
                 @csrf
            <div class="row">
                <div class="col-md-12">
                    <label style="margin-bottom:1rem;font-weight:bold;">Amount </label>
                    <input type="number" placeholder="Enter amount e.g 100" name="amount" id="amount" class="form-control">
                </div>
                <input type="hidden" name="vendor_id" id="vendor_id" value="{{$deposit_id}}">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  
 
     <div class="modal fade" id="deduct_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Deposit Amount  &nbsp; &nbsp; <span style="color:black;">[ balance {{$currency_symbol}}{{number_format($vendor->amount ,2)}}] </span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>            
          <div class="modal-body">
             <form method="post" action="{{route('admin.vendor_management.deduct-deposit')}}">
                 @csrf
            <div class="row">
                <div class="col-md-12">
                    <label style="margin-bottom:1rem;font-weight:bold;">Amount </label>
                    <input type="number" placeholder="Enter amount e.g 100" step="any" value="1" name="amount" id="amount" class="form-control">
                </div>
                <input type="hidden" name="vendor_id" id="vendor_id" value="{{$deposit_id}}">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          </form>
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
    
    if (startDate === '' && endDate === '') {
        startDate = moment().subtract(29, 'days');
        endDate = moment();
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



<script>


    function openDepositModal()
    {
        $('#deposit_modal').modal('show')
    }
    
    function openDeductModal()
    {
         $('#deduct_modal').modal('show')
    }
</script>
