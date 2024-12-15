
    @foreach ($cars as $car)
                             @php
                              $car_content = $car->car_content;
                              if (is_null($car_content)) {
                                  $car_content = $car->car_content()->first();
                              }
                             
                            @endphp
                            @if($car_content)
  <div class="card ">
      <div class="card-header">
      <div class="d-flex justify-content-between">
      <div class=" d-inline-block text-left">
      @php
      $forExpired ="";
      $forExpired = noDaysLeftByAd($car->package_id,$car->created_at);
       
      @endphp
      @if($car->status==2)
      {{ 'Withdrawn' }} 
      @endif
      @if($car->status==0)
        Needs Payment (Not Listed)
      @elseif($car->status==1)
      {{ noDaysLeftByAd($car->package_id,$car->created_at) }}
     @endif
    </div>
        <h5 class="text-right">
          
        <div class="dropdown">
    <a style="color:#1572E8; font-weight:100; font-size:15px;" class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Manage
  </a>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    @if($car->status==0 && $forExpired !="Expired")
    <a class="dropdown-item mb-2" href = "{{ route('vendor.package.payment_method',  $car->package_id) }}">Pay Now</a>
    @endif
    @if($car->status==1 && $forExpired !="Expired")
    <a class="dropdown-item mb-2" href = "{{ route('vendor.cars_management.ad_status', ['withdraw',$car->id]) }}">Withdraw</a>
    @endif
    @if($forExpired=="Expired")
    <a class="dropdown-item mb-2"  href = "{{ route('vendor.package.payment_method',  $car->package_id) }}">Republish</a>
    @endif
    @if($forExpired!="Expired")
   <a class="dropdown-item mb-2" href="{{  route('vendor.cars_management.edit_car', $car->id)  }}">Edit</a>
   @endif   
   <form class="deleteForm d-inline-block"
                              action="{{ route('vendor.cars_management.delete_car') }}" method="post">
                              @csrf
                              <input type="hidden" name="car_id" value="{{ $car->id }}">
                              <button type="submit" class="deleteBtn-messages">
                               Remove
                              </button>
       </form>
      

                              
                           
      
    </div>
  </div></h5>
      </div>
      </div>
      <div class="card-body">  
    <div class="row no-gutters">
      <div class="col-md-2 col-sm-*"> 
      <img class=" wf-130"  src="{{ asset('assets/admin/img/car-gallery/' . $car->feature_image) }}" alt="Ad Image">
      </div>
      <div class="col-md-10 col-sm-*">
        
          <label class="card-title">
                          
                            <a href="{{ route('frontend.car.details', [catslug($car_content->category_id), 'slug' => $car_content->slug, 'id' => $car->id]) }}"
                              target="_blank">
                              {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                            </a></label>
          
        </div>
      </div>
    </div>
    @if( !empty($car->package_id))
    <div style="text-align:right;" class="card-footer text-right">
    @if($car->status==0)
    <a href = "{{ route('vendor.package.payment_method',  $car->id) }}" style="color:#1572E8; font-weight:300; font-size:17px; margin-right:20px;">Pay Now</a>
    @endif 
    @if($car->status==1)
    <a href = "{{ route('vendor.package.payment_boost',  [$car->car_content->main_category_id,$car->id]) }}" style="color:#EE2C7B; font-weight:400; font-size:17px; margin-right:30px;"><i class="fal fa-paper-plane"></i> Boost</a>
    @endif
  </div> @endif  
  
  </div>
  @endif
@endforeach
