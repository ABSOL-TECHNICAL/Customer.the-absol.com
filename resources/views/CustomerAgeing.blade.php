<!DOCTYPE html>
<html>
<head>
    <title>Dummy</title>
    <style>
        table{
            border: 1px solid black;
            margin: 0 auto;
            width: 100%;
            table-layout: fixed;  
        }
        th, td {
           
            text-align: center;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
            font-size: xx-small;
        }
        body{
            padding: 0.5%;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 style="text-align:center;">Customer Ageing</h1>
    <p style="text-align:right; font-weight:bold;">Date : {{ $date }}</p>
    <div class="table-responsive">
    <table >
        <thead style="border: 1px solid black">
            <tr>    
                <th style="border: 0.5px solid black; text-align:center;">No</th>
                <th style="border: 0.5px solid black; text-align:center;">Company ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Company Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Number</th>
                <th style="border: 0.5px solid black; text-align:center;">Balance</th>
                <th style="border: 0.5px solid black; text-align:center;">PDC Bucket</th>
                <th style="border: 0.5px solid black; text-align:center;">Open Bucket</th>
                <th style="border: 0.5px solid black; text-align:center;">Current Bucket</th>
                <th style="border: 0.5px solid black; text-align:center;">1-30 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">31-60 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">61-90 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">91-120 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">121-180 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">181-365 Days</th>
                <th style="border: 0.5px solid black; text-align:center;">1-2 Years</th>
                <th style="border: 0.5px solid black; text-align:center;">2-3 Years</th>
                <th style="border: 0.5px solid black; text-align:center;">> 3 Years</th>

            </tr>
        </thead>
        <tbody >
        @php
                $no = 1;

                $user = $user ?? [];

    if (is_array($user)) {
        $count = 1;
    } else {
        $count = 0; 
    }
            
            @endphp

            @if ($count > 0)
@foreach ($user as $key => $value)
    <tr>
        <td style="border: 0.5px solid black">{{ $no++ }}</td>
        <td style="border: 0.5px solid black">{{ $value['COMPANY_ID'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['COMPANY_NAME'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NAME'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NUMBER'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['BALANCE'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['PDC_BUCKET'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['OPEN_BUCKET'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['CURRENT_BUCKET'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['1_30_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['31_60_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['61_90_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['91_120_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['121_180_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['181_365_DAYS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['1_2_YEARS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['2_3_YEARS'] ?? '' }}</td>
        <td style="border: 0.5px solid black">{{ $value['ABOVE_3_YEARS'] ?? '' }}</td>
    </tr>
@endforeach

@else
    <tr>
        <td colspan="13" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center" style="border: 0.5px solid black;">
            No data available
        </td>
    </tr>
@endif
        </tbody>
    </table>
    </div>
</body>
</html>