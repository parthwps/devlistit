<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        /* Add inline CSS for table styling */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000; /* Black border */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #000; /* Black background for header */
            color: #fff; /* White text for header */
        }
    </style>
</head>
<body>

<h3>From {{date('d F, Y' , strtotime($sevenDaysAgoDate)) }} To {{date('d F, Y' , strtotime($todayDate)) }}
    <table class="table table-striped mt-3" id="myTable2">
        <thead>
            <tr>
                <th scope="col">{{ __('Title') }}</th>
                <th scope="col">{{ __('Day Live') }}</th>
                <th scope="col">{{ __('Price') }}</th>
                <th scope="col">{{ __('Impression') }}</th>
                <th scope="col">{{ __('Views') }}</th>
                <th scope="col">{{ __('Saves') }}</th>
                <th scope="col">{{ __('CTR') }}</th>
                <th scope="col">{{ __('Leads') }}</th>
                <th scope="col">{{ __('Bump') }}</th>
                <th scope="col">{{ __('Spotlight') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td>{{$impressions}}</td>
                <td>{{$visitors}}</td>
                <td>{{$saves}}</td>
                <td>{{($visitors > 0 && $impressions > 0) ? round(($visitors/$impressions) * 100, 2) : 0}}</td>
                <td>{{$leads}}</td>
                <td></td>
                <td></td>
            </tr>

            @foreach ($messageContent['cars'] as $car)
                <tr>
                    <td>
                        @php
                            $car_content = $car->car_content;
                            if (is_null($car_content)) {
                                $car_content = $car->car_content()->first();
                            }
                            $ad_stats = \App\Http\Controllers\Vendor\CarController::getAdStats($car->id);
                        @endphp
                        {{ strlen(@$car_content->title) > 50 ? mb_substr(@$car_content->title, 0, 50, 'utf-8') . '...' : @$car_content->title }}
                    </td>
                    <td><?= (new DateTime($car->bump_date))->diff(new DateTime())->format('%a') ?></td>
                    <td>{{number_format($car->price , 2)}}</td>
                    <td>{{$ad_stats['impressions']}}</td>
                    <td>{{$ad_stats['visitors']}}</td>
                    <td>{{$ad_stats['saves']}}</td>
                    <td>{{($ad_stats['visitors'] > 0 && $ad_stats['impressions'] > 0) ? round(($ad_stats['visitors']/$ad_stats['impressions']) * 100, 2) : 0}}</td>
                    <td>{{$ad_stats['leads']}}</td>
                    <td>{{$car->bump}}</td>
                    <td>{{($car->is_featured == 1) ? 'yes' : 'no'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
