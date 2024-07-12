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
    <h1 style="text-align:center;">Statement Of Accounts</h1>
    <p style="text-align:right; font-weight:bold;">Date : {{ $date }}</p>
    <div class="table-responsive">
    <table >
        <thead style="border: 1px solid black">
            <tr>    
                <th style="border: 0.5px solid black; text-align:center;">No</th>
                <th style="border: 0.5px solid black; text-align:center;">COMPANY ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Company NAME</th>
                <th style="border: 0.5px solid black; text-align:center;">CUSTOMER ID</th>
                <th style="border: 0.5px solid black; text-align:center;">CUSTOMER NUMBER</th>
                <th style="border: 0.5px solid black; text-align:center;">CUSTOMER NAME</th>
                <th style="border: 0.5px solid black; text-align:center;">TYPE</th>
                <th style="border: 0.5px solid black; text-align:center;">TRX NO</th>
                <th style="border: 0.5px solid black; text-align:center;">PURCHASE ORDER</th>
                <th style="border: 0.5px solid black; text-align:center;">SO NUMBER</th>
                <th style="border: 0.5px solid black; text-align:center;">SHIP TO SITE</th>
                <th style="border: 0.5px solid black; text-align:center;">DUE DATE</th>
                <th style="border: 0.5px solid black; text-align:center;">TRX DATE</th>
                <th style="border: 0.5px solid black; text-align:center;">AMOUNT</th>
                <th style="border: 0.5px solid black; text-align:center;">DUE DAYS</th>
                <th style="border: 0.5px solid black; text-align:center;">PDC AMOUNT</th>
                <th style="border: 0.5px solid black; text-align:center;">BALANCE</th>
                <th style="border: 0.5px solid black; text-align:center;">CREDITED AMOUNT</th>
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
                        <td style="border: 0.5px solid black">{{   $value['COMPANY_ID'] ?? ''  }}</td>
                        <td style="border: 0.5px solid black">{{   $value['COMPANY_NAME'] ?? ''  }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_ID'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NUMBER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NAME'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['TRANSACTION_TYPE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['TRX_NUMBER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['PURCHASE_ORDER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['SO_NUMBER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['SHIP_TO_SITE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['DUE_DATE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['TRX_DATE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['AMOUNT'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['DUE_DAYS'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['PDC_AMOUNT'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['BALANCE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CREDITED_AMOUNT'] ?? '' }}</td>
                    </tr>
                
            @endforeach
            @else
    <tr style="border: 0.5px solid black; text-align: center;">
        <td colspan="18" style="border: 0.5px solid black; text-align: center;">
            No data available
        </td>
    </tr>
@endif
        </tbody>
    </table>
    </div>
</body>
</html>