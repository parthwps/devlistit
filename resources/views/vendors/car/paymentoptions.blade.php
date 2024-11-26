            @if(count($data) > 0)
            <h4 class="mb-5">Choose your ad option</h4>  
              @foreach ($data as $data)  
              @if ($loop->index == 1)      
                <div class="col-lg-4 col-md-4 col-sm-12 pr-md-0 mb-2 custom-col-ad">
              @else
              <div class="col-lg-4 col-md-4 col-sm-12 pr-md-0 mb-2 mt-4 custom-col-ad">
              @endif    
                <div class="card-pricing-vendor">
                    @if ($loop->index == 1)
                    <div class="price-rcomm">Recommended</div>
                    
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
                    @if ($loop->index == 1)
                     <div class="px-3 clearfix" style="margin-top: -7px;">
                    @else
                    <div class="px-3 clearfix">
                        @endif
                      <table class="table">
                          <thead>
                            <tr>
                                <td style="width: 5rem;"> Ad views </td>
                                <td>
                                @if ($loop->index == 0)  
                                  <div class="progress align-baseline">
                                      <div class="progress-bar bg-success" role="progressbar" style="width: 33%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
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
                    @if ($loop->index == 0 || $loop->index == 2)
                    <ul class="pricing-content p-2">
                    @endif
                    @if ($loop->index == 1)
                    <ul class="pricing-content p-2">
                    @endif
                    
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
                     @if ($loop->index == 0 )
                      <div class="px-4  mt-4"> 
                      @elseif ($loop->index == 1)
                      <div class="px-4" style="margin-top: 15px !important;"> 
                     @else
                    <div class="px-4  mt-3">
                        @endif
                      <a href="javascript:void(0)"
                          class="choosepackage btn btn-primary btn-block btn-lg mb-3 w-100" data-id = "{{$data->id}}" onclick="scroll_to_bottom()">{{ __('Choose') }}</a>
                    </div>
                </div>
              </div>
              @endforeach
              @endif
            