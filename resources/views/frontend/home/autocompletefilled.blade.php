<div class="autocomplete-suggestions suggestionbox">
<div class="autocomplete-suggestion pt-2 pb-2" style="border-bottom:1px solid #e8e8e8;"><i class="fal fa-search"></i> My Last Search<br>
@php
                        $lSearch = array();
                        if (Auth::guard('vendor')->check()){
                            $lastSearch = App\Models\Car\CustomerSearch::where('customer_id', Auth::guard('vendor')->user()->id)->first();
                            if($lastSearch){
                            $lSearch = $lastSearch->customer_filters;
                            }
                        } elseif(session()->has('lastSearch')) { 
                            $lSearch = Session::get('lastSearch');
                        }
                     @endphp
                     @if(!empty($lSearch))
                     
                     <a style="font-size:11px;" href="ads?{{ http_build_query(json_decode($lSearch)) }}">
                                  @foreach (json_decode($lSearch) as $key=>$value)
                                  @if($key!='_token')
                                  @if(!is_array($value))
                                    {{ Str::slug($value, ' ') }} <small style="font-size:9px;">-></small>
                                    @endif
                                    @endif
                                  @endforeach
                                </a>
                     @endif   </div>

<!-- <div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars from Trusted Dealerships  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with a Warranty  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with Greenlight History Check  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"> <a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp;Cars with Finance  <b>in Cars</b></a></div>
<div class="autocomplete-suggestion pt-2 pb-2"><a href="{{route('frontend.cars', ['category'=>'cars'])}}"><i class="fal fa-check"></i> &nbsp; New Cars  <b>in Cars</b></a></div> -->

</div>
