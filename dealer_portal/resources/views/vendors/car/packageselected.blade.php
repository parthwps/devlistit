@if ($data->promo_price > 0)
            <div class="col-md-12 pr-md-0 mb-1">
              <div class="card">
              <div class="m-3 d-flex justify-content-between">
                  <h4 class="card-text">Select Add-Ons </h4>
                 
                </div>
                <div class="m-3 d-flex justify-content-between">
                  <div class=""><strong>Spotlight for {{symbolPrice($data->promo_price)}} </strong>
                <br>
               <small> Rotate in top promo spot for 5 days</small></div>
                  <div class=""><input @checked(request()->get('promo') == 1)  data-id = "{{$data->id}}" class = "choosepromo" value="1" style=" top: .8rem; width: 1.55rem; height: 1.55rem;" type="checkbox" name="promoPrice"></div>
                </div> 
                
                </div>
            </div>  
        @endif
        <div class="col-md-12 pr-md-0 mb-3">
              <div class="card">
              <div class="m-2 d-flex justify-content-between">
                  <h4 class="card-text">Summary </h4>
                  <input id ="packageId" type="hidden" name="id" value="{{ $data->id }}">
                </div>
                @if( request()->get('promo')==1 )
                <div class="m-3 d-flex justify-content-between"  >
                @else
                <div class="m-3 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                @endif
                  <div class=""><strong>{{$data->title}} Ad </strong>Listed for {{$data->days_listing}} days</div>
                        <div ><strong>@if ($data->price == 0)
                              {{ __('Free') }}
                            @else {{symbolPrice($data->price)}}  @endif</strong>
                        </div>
                       
                       
                </div>
               
                @if( request()->get('promo')==1 )
                <div class="m-3 d-flex justify-content-between"  style="border-bottom:2px solid #F1F1F1">
                        <div class=""></div>
                        <div ><strong> {{symbolPrice($data->promo_price)}} </strong>
                        </div>
                        </div>
                @endif

                <div class="m-3 d-flex justify-content-between" >
                  <div class=""><strong >Total</strong></div>
                        <div id="totalPrice"><strong>
                                @if( request()->get('promo')==1 )
                                
                                {{symbolPrice($data->promo_price+$data->price)}} 
                                @else 
                                @if ($data->price == 0)
                              {{ __('Free') }}
                            @else {{symbolPrice($data->price)}}  @endif
                            @endif
                        </strong>
                        </div>
                </div>
                
              </div>
        </div>    