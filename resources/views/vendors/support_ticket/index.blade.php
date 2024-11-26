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

        <div class="user-dashboard pt-20 pb-60" style="margin-top: 5rem;">
        <div class="container">
        <div class="row gx-xl-5">
        @includeIf('vendors.partials.side-custom')
        <div class="col-12 col-lg-9">
        <div class="row">
        <div class="col-md-12"  style="padding:0px;">
        <div class="card">
        <div class="card-header">
        <div class="row">
        <div class="col-lg-12"  style="padding:0px;">
        <div class="card-title d-inline-block" style="    width: 100%;">
        <span style="font-size: 15px;font-weight: 600;"> {{ __('Messages') }}</span>
        <button class="btn btn-info btn-sm" onclick="submitFormBtn()" style="padding: 10px 20px;float:right;">Remove</button>
        <span class="us_checkbox_zoom" style="background: white;display: flex;padding: 5px;border-radius: 2px;border: 1px solid lightgrey;float:right;    margin-right: 5px;">
        <input type="checkbox"  id="parentCheckbox"/> 
        <div style="font-size: 8px;margin-left: 5px;">Select All</div>
        </span> 
        </div>
        </div>
        </div>
        </div>

        <div class="card-body" style="padding:0px;">
          <div class="row">
            <div class="col-lg-12">

              @if (session()->has('course_status_warning'))
                <div class="alert alert-warning">
                  <p class="text-dark mb-0">{{ session()->get('course_status_warning') }}</p>
                </div>
              @endif

              @if (count($collection) == 0)
                 <h3 class="text-center mt-2">
                     <i class='far fa-comments' style='font-size: 10rem;color: gray;'></i> <br> <span style="color: gray;font-size: 14px;font-weight: 200;">You have no new messges at the moment.</span> <br> <b style="font-size: 14px;">Why not contact a seller?</b></h3> 
                     
                 <center><a href="{{url('ads')}}" class="btn btn-info mt-3">Browse ads</a></center>
              @else

                @php
                 $counter = 0;
                @endphp
                
                <div class="table-responsive">
                  <table class="table  "style="border-collapse: separate; " >
                   
                    <tbody>
                       
                        <form method="get" id="submitForm" action="{{route('vendor.support_tickets.multi.delete')}}">
                            @foreach ($collection as $item)
                            @php
                                $carDetail = App\Models\Car::find($item->ad_id);
                            @endphp
                            
                            @if($carDetail)
                            <tr style="padding:10px; cursor:pointer;" >
                                
                            <td class="" style=" padding-right: 0px !important;padding-left: 10px !important;" >
                                <input type="checkbox" value="{{$item->id}}" name="removemesages[]" class="us_removeboxes"/>
                            </td>
                            
                              <td  class="us_td_img" style=" padding-right: 0px !important;padding-left: 0px !important;" onclick="window.location.href='{{ route('vendor.support_tickets.message', $item->id) }}'">
                              @if ($carDetail->feature_image != null)
                              <img class = "mb-1 img-thumbnail us_img_cust" style="height: 70px;width: 70px;border-radius: 50%;" width="70" src="{{ asset('assets/admin/img/car-gallery/'. $carDetail->feature_image) }}" >
                              @endif
                              
                            
                            </td>
                              <td   style="padding-left: 10px !important;"  onclick="window.location.href='{{ route('vendor.support_tickets.message', $item->id) }}'">
                                  
                                <h5  class="us_mrgn_td" >
                                 @php
                                  $vedr = addUserName($item->user_id , $item->admin_id);
                                 @endphp
                                     <span style="font-size: 15px;">  {{$vedr[0] }}</span>
                                  <span class="us_timings"> {{date('d F h:i a' , strtotime($item->messages()->latest()->first()->created_at))}} </span>
                                    </h5>
                                      <div>
                                      <a class="" href="{{ route('vendor.support_tickets.message', $item->id) }}" class="dropdown-item" style="font-weight: bold;color: gray;font-size: 13px;">
                                          
                                        @if(isOnline($vedr[1])[0] )
                                            <i class="fa fa-circle" aria-hidden="true" title="online" style="margin-right: 5px;font-size: 12px;color: #08c27d;"></i>   
                                        @else
                                            <i class="fa fa-circle" aria-hidden="true" title="offline" style="margin-right: 5px;font-size: 12px;color: gray;" ></i>
                                        @endif
                                   
                                        {{$item->subject}}   
                                        
                                        @if($item->messages->where('message_seen' , 0)->where('message_to' , Auth::guard('vendor')->user()->id )->count() > 0)
                                            <span style="background: #ca00ca;
                                            color: white;
                                            padding: 1px 10px 3px;
                                            border-radius: 10px;
                                            font-family: sans-serif;
                                            margin-left: 5px;"> new </span> 
                                        @endif
                                    </a> 
                                     
                                     </div>
                                <div class="us_mrgn_btm_td"  style="margin-top: 3px;">
                                {!!$item->messages()->latest()->first()->reply ?? 'No messages found' !!}  <br>
                                
                                </div>
                              </td>
                             
                              <td  class="us_hide_td" onclick="window.location.href='{{ route('vendor.support_tickets.message', $item->id) }}'" >
                               @if($carDetail->is_sold == 1 || $carDetail->status == 2 )
                               <a href="{{ route('vendor.support_tickets.message', $item->id) }}" style="color: orange;font-size: 17px;">Sold</a>
                               @else
                                <a href="{{ route('vendor.support_tickets.message', $item->id) }}" style="color: #3838c1;" > Reply <i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                               @endif
                              </td>
                            </tr>
                            
                            @php
                             $counter ++;
                            @endphp
                            
                            @endif
                          @endforeach
                        </form>
                      
                    </tbody>
                  </table>
                </div>
                
                
                @if($counter == 0)
                  <h3 class="text-center mt-2">
                     <i class='far fa-comments' style='font-size: 10rem;color: gray;'></i> <br> <span style="color: gray;font-size: 14px;font-weight: 200;">You have no new messges at the moment.</span> <br> <b style="font-size: 14px;">Why not contact a seller?</b>
                  </h3> 
                 <center><a href="{{url('ads')}}" class="btn btn-info mt-3">Browse ads</a></center>
                @endif
                
                
              @endif

             
            </div>
          </div>
        </div>

        <div class="card-footer">
          {{ $collection->links() }}
        </div>
      </div>
    </div>
  </div>  </div>
  </div>
</div>
@endsection
