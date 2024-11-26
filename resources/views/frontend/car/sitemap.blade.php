@php
  $version = $basicInfo->theme_version;
@endphp
@extends("frontend.layouts.layout-v$version")
@section('pageHeading')
  {{ __('Ads') }}
@endsection

@section('metaKeywords')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_keyword_cars }}
  @endif
@endsection

@section('metaDescription')
  @if (!empty($seoInfo))
    {{ $seoInfo->meta_description_cars }}
  @endif
@endsection

@section('content')
 


  <div class="listing-grid-area pt-40 pb-40">
    <div class="container">
      <div class="row gx-xl-5" style="margin-top: 3.5rem;">
          
          <div class="col-md-12 mb-30" style="padding-left: 13px;" >
              <h3>Listit Sitemap</h3>
          </div>
          
          @foreach($categories as $category)
            <div class="col-md-12 mb-30" style="padding-left: 13px;">
                 <b> <a href="{{route('frontend.cars' , ['category' => $category->slug])}}">{{$category->name}}</a></b>
            </div>
            
            @if($category->children)
                @include('frontend.car.category-list', ['categories' => $category->children  ])
            @endif
            
          @endforeach
      </div>
    </div>
  </div>
  
@endsection
@section('script')
<script>

  'use strict';

  const baseURL = "{{ url('/') }}";
  
  
</script>
@endsection