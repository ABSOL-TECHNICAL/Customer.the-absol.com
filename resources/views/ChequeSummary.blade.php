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
    <h1 style="text-align:center;">Cheque Status Summary Details</h1>
    <p style="text-align:right; font-weight:bold;">Date : {{ $date }}</p>
    <div class="table-responsive">
    <table >
        <thead style="border: 1px solid black">
            <tr>    
                <th style="border: 0.5px solid black; text-align:center;">Company ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Company Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer ID</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Number</th>
                <th style="border: 0.5px solid black; text-align:center;">Customer Name</th>
                <th style="border: 0.5px solid black; text-align:center;">Currency Code</th>
                <th style="border: 0.5px solid black; text-align:center;">Cheque Amount</th>
                <th style="border: 0.5px solid black; text-align:center;">Reversed</th> 
                <th style="border: 0.5px solid black; text-align:center;">Confirmed</th>
                <th style="border: 0.5px solid black; text-align:center;">Cleared</th>
                <th style="border: 0.5px solid black; text-align:center;">Remitted</th>  
                <th style="border: 0.5px solid black; text-align:center;">Last Update Date</th>
                <th style="border: 0.5px solid black; text-align:center;">Ch Year</th>    
            </tr>
        </thead>
        <tbody >
        @php
    $flag = 0;
    $user = $user ?? [];

    if (is_array($user) && array_key_exists('COMPANY_ID', $user)) {
        $count = count($user['COMPANY_ID']);
    } else {
        $flag = 1;
        $count = 0; 
    }
@endphp

@if ($flag == 0 && $count > 0)
    @for ($i = 0; $i < $count; $i++)
        <tr>
            @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CUSTOMER_NAME', 'CURRENCY_CODE', 'CHEQUE_AMOUNT', 'REVERSED', 'CONFIRMED', 'CLEARED', 'REMITTED', 'LAST_UPDATED_DATE', 'CH_YEAR'] as $column)
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" style="border: 0.5px solid black;">
                    {{ $user[$column][$i] }}
                </td>
            @endforeach
        </tr>
    @endfor
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