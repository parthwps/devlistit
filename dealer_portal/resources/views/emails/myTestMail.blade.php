<!DOCTYPE html>
<html>
<head>
    <title>ItsolutionStuff.com</title>
</head>
<body>
<table class="table table-bordered mt-3" id="">
                    <thead>
                      <tr>
                  
                        <th scope="col">{{ __('Year') }}</th>
                        <th scope="col">{{ __('Make') }}</th>
                        <th scope="col">{{ __('Model') }}</th>
                        <th scope="col">{{ __('Engine size') }}</th>
                        <th scope="col">{{ __('Fuel Type') }}</th>
                        <th scope="col">{{ __('Trans-mission') }}</th>
                        <th scope="col">{{ __('ODO-Meter') }}</th>
                        <th scope="col">{{ __('Price') }}</th>
                     
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($messageContent['cars'] as $car)
                        <tr>
                       
                           
                           {{ $car->year }}
                         </td>

                         <td>
                            @php
                              if ($car->car_content) {
                                  $brand = $car->car_content->brand()->first();
                              } else {
                                  $brand = null;
                              }
                            @endphp
                            {{ $brand != null ? $brand['name'] : '-' }}
                          </td>
                            

                          <td>
                            @php
                              if ($car->car_content) {
                                  $model = $car->car_content->model()->first();
                              } else {
                                  $model = null;
                              }
                            @endphp
                            {{ $model != null ? $model['name'] : '-' }}
                          </td>
                        
                          <td>
                              {{$car->engineCapacity }}
                          </td>

                          <td>
                            @php
                              if ($car->car_content) {
                                  $fuel_type = $car->car_content->fuel_type()->first();
                              } else {
                                  $fuel_type = null;
                              }
                            @endphp
                            {{ $fuel_type != null ? $fuel_type['name'] : '-' }}
                          </td>


                          <td>
                            @php
                              if ($car->car_content) {
                                  $transmission_type = $car->car_content->transmission_type()->first();
                              } else {
                                  $transmission_type = null;
                              }
                            @endphp
                            {{ $transmission_type != null ? $transmission_type['name'] : '-' }}
                          </td>

                          
                          <td>
                              {{number_format($car->mileage )}}
                          </td>

                          <td>
                              {{number_format($car->price , 2)}}
                          </td>

                        </tr>
                      @endforeach
                    </tbody>
                  </table>
            
</body>
</html>