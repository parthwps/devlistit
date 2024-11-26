<div class="row " >
    @foreach($categories as $key => $category)
       
            @if($category->children->isNotEmpty())
             <div class="col-md-12 mb-30 " >
                 <b> <a href="{{route('frontend.cars' , ['category' => $category->slug])}}">{{$category->name}}</a></b>
                </div>
            @else
             <div class="col-md-3 mb-10">
               <a href="{{route('frontend.cars' , ['category' => $category->slug])}}">{{$category->name}}</a>
                 </div>
            @endif
       
            @if($category->children->isNotEmpty())
                    @include('frontend.car.category-list', ['categories' => $category->children])
            @endif
            
    @endforeach
</div>

          
