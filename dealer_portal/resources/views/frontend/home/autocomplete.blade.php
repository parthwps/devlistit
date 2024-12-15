<div class="autocomplete-suggestions">
    @foreach($cars as $car)
    @if(!empty($car->category))
    <div class="autocomplete-suggestion pt-2 pb-2">{{$searchTerm}} <a href="{{route('frontend.cars', ['title' => $searchTerm, 'category'=>$car->category->slug])}}"> in {{$car->category->name}}</a></div>
    @endif
    @endforeach
</div>