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

@section('style')

<style>
    #payplans {
    padding: 15px 15px 15px 15px;
}

.card-pricing-vendor {
    padding-bottom: 10px;
    background: #fff !important;
    text-align: center;
    overflow: hidden;
    position: relative;
    border-radius: 5px;
    -webkit-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    -moz-box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    box-shadow: rgba(51, 51, 51, 0.24) 0px 1px 4px;
    min-height: 400px;
}

.pricing-content-align {
    min-height: 133px;
}

.price-rcomm {
    background-color: rgb(0, 170, 255);
    padding: 5px;
    color: #fff;
    font-size: 14px;
}
</style>
@endsection
@section('content')
  @includeIf('frontend.partials.breadcrumb', [
      'breadcrumb' => 123,
      'title' => !empty($pageHeading) ? $pageHeading->vendor_signup_page_title : __('Signup'),
  ])

  <div class="user-dashboard pt-20 pb-60">
    <div class="container">
        
  <div class="row gx-xl-5">
  
       @includeIf('vendors.partials.side-custom')
   <div class="col-md-9">
    <div class="row">
    <div class="col-md-12">
    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
    </div>
  @endif
  
    <form id="my-checkout-form" action="{{ route('vendor.plan.checkout') }}" method="post"
          enctype="multipart/form-data">
          @csrf
          
          
         
          <div class="row">
            @if(count($data) > 0)
            <h4 class="mb-5">Choose your ad option</h4>  
              @foreach ($data as $data)  
              @if ($loop->index == 1)      
                <div class="col-md-3 pr-md-0 mb-2">
              @else
              <div class="col-md-3 pr-md-0 mb-2 mt-4">
              @endif    
                <div class="card-pricing-vendor">
                    @if ($loop->index == 1)
                    <div class="price-rcomm">Boost</div>
                    
                    @endif
                    <div class="pricing-header">
                      <h4 class=" d-inline-block mt-4">
                      {{$data->title}}
                      </h4>
                    </div>
                    <div class="price-value">
                      <div class="value">
                          <h2>{{ symbolPrice($data->price) }}</h2>
                      </div>
                    </div>
                    <div class="px-3 clearfix">
                      <table class="table">
                          <thead>
                            <tr>
                                <td style="width: 5rem;"> Ad views </td>
                                <td>
                                @if ($loop->index == 0)  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-warning" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  @endif
                                  @if ($loop->index == 1)  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bggrey" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  @endif
                                  @if ($loop->index == 2)  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                  </div>
                                  @endif
                                </td>
                            </tr>
                          </thead>
                      </table>
                    </div>
                    <ul class="pricing-content p-2">
                     @if ($data->days_listing > 0)
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;{{$data->days_listing}} day listing</li>
                      @endif
                      @if ($data->photo_allowed > 0)
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Up to {{$data->photo_allowed}} photos</li>
                      @endif
                      @if ($data->ad_views > 0)
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;{{$data->ad_views}}x more ad views</li>
                      @endif
                      @if ($data->priority_placement > 0)
                      <li><span class="c_check"><i class="fal fa-check"></i></span> &nbsp;Priority placement</li>
                      @endif
                    </ul>
                    
                    <div class="px-4 mt-3">
                      <a href="{{ route('vendor.package.boost_package',  [$data->id,request()->route('ad_id')])}}"
                          class="choosepackage btn btn-primary btn-block btn-lg mb-3 w-100" data-id = "{{$data->id}}">{{ __('Choose') }}</a>
                    </div>
                </div>
              </div>
              @endforeach
              @endif
            
              </div>
       
      </form>
        <div class="card-footer">
          
        </div>
      </div>
    </div>
  </div>  </div>
  </div>
</div>
@endsection
