@extends('backend.layout')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __(' Dealers Payments') }}</h4>
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
        <a href="#">{{ __('Payments Management') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Payment History</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      
            
      <div class="card">
        <div class="card-header">
            
           
          <div class="row">
              
              
            <div class="col-lg-4">
              <div class="card-title">Payment History For invoice # 1000{{$invoice->id}}</div>
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
