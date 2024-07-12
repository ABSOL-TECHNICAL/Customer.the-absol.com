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
    <h1 style="text-align:center;">Cheque Status Details</h1>
    <p style="text-align:right; font-weight:bold;">Date : {{ $date }}</p>
    <div class="table-responsive">
    <table >
        <thead style="border: 1px solid black">
            <tr>    
                <th style="border: 0.5px solid black; text-align:center;">No</th>
                <th style="border: 0.5px solid black; text-align:center;">Company ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Company Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Number</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Cheque Number</th>
                <th style="border: 0.5px solid black; text-align:center;">Cheque Date</th>
                <th style="border: 0.5px solid black; text-align:center;">Gl Date</th>
                <th style="border: 0.5px solid black; text-align:center;">Maturity Date</th>
                <th style="border: 0.5px solid black; text-align:center;">Currency Code</th>
                <th style="border: 0.5px solid black; text-align:center;">Cheque Amount</th>
                <th style="border: 0.5px solid black; text-align:center;">Cheque Status</th>
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
                        <td style="border: 0.5px solid black">{{$value['COMPANY_ID'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['COMPANY_NAME'] ?? ''}}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_ID'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NUMBER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CUSTOMER_NAME'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CHEQUE_NUMBER'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CHEQUE_DATE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['GL_DATE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['MATURITY_DATE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CURRENCY_CODE'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CHEQUE_AMOUNT'] ?? '' }}</td>
                        <td style="border: 0.5px solid black">{{ $value['CHEQUE_STATUS'] ?? '' }}</td>
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