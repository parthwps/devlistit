<div class="autocomplete-suggestions">
    @foreach($cars as $car)
    <div class="autocomplete-suggestion pt-2 pb-2">{{$searchTerm}} <a href="{{route('frontend.cars', ['title' => $searchTerm, 'category'=>$car->category->slug])}}"> in {{$car->category->name}}</a></div>
    @endforeach
</div>