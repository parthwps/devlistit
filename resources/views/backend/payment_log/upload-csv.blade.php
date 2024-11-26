@extends('backend.layout')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Upload CSV') }}</h4>
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
        <a href="#">{{ __('Upload CSV') }}</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">{{ __('Upload CSV Page') }}</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-4">
              <div class="card-title d-inline-block">{{ __('Upload CSV File') }}</div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0 justify-content-end">
             
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
                 @if($counter > 0 )
                    <center><h4 class="text-warning">One File Is Under Progress. Please Wait For complete.</h4></center>
                 @else
                        <form action="{{ route('admin.payment-log.upload.csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv_file" class="form-control" accept=".csv">
                        <center>   <button 
                        type="submit" 
                        class="btn btn-success" 
                        style="margin-top: 2rem;" 
                        onclick="this.disabled = true; this.innerHTML = 'Processing, please wait...'; this.form.submit();"
                        >
                        Upload CSV
                        </button></center>
                        </form>
                 @endif
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
