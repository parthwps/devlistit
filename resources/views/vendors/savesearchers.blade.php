@extends("frontend.layouts.layout-v$settings->theme_version")
@section('pageHeading')
  @if (!empty($pageHeading))
    {{ $pageHeading->vendor_signup_page_title ? $pageHeading->vendor_signup_page_title : __('Save Searches') }}
  @else
    {{ __('Save Searches') }}
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
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Save Searches'),
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
              <div class="card-title d-inline-block">{{ __('Your Save Searches') }}</div>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
              
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              @if (count($savesearchers) == 0)
                <h3 class="text-center">{{ __('No Record Found') }}</h3>
              @else
                <div class="table-responsive">
                  <table class="table table-striped mt-3">
                    <thead>
                      <tr>
                      <th scope="col">{{ __('Search Name') }}</th>
                        <th scope="col">{{ __('Last Check By You') }}</th>
                        <th scope="col">Alert Category</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($savesearchers as $key => $savesearcher)
                           
                        <tr>
                        <td>
                            <b>{{$savesearcher->save_search_name}}</b>
                        </td>
                        
                         <td>
                             {{date('F , d Y h:i:a' , strtotime($savesearcher->last_save_date))}}
                        </td>
                         
                          <td>
                              @if($savesearcher->selectedAlertType == 0)
                                {{'No Alerts'}}
                              @elseif($savesearcher->selectedAlertType == 1)
                                {{'Yes, instant alert'}}
                              @else
                                {{'Yes, daily alert'}}
                              @endif
                          </td>
                        
                          <td>
                            
                             <a class="btn btn-sm btn-danger" href="{{ route('vendor.delete.save.searches', [$savesearcher->id]) }}" onclick="return confirm('Are you sure you want to delete this?')">
    <i class="fa fa-trash" aria-hidden="true"></i>
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
              {{ $savesearchers->links() }}
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
  </div>
</div>
@endsection
