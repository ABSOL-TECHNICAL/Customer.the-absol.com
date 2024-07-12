@php
    $flag = 0;
    $isFilter=0;
    $data = $data ?? [];
    // Initialize $data to an empty array if it's null
    if (is_array($data) && array_key_exists('COMPANY_ID', $data)) {
        $count = count($data['COMPANY_ID']);
    }
    elseif($data!==null) 
    {
        $flag=1;
        $isFilter=1;
    } 
    else {
        $flag = 2;
        $count = 0; // Set count to 0 if $data['COMPANY_ID'] doesn't exist
    }
@endphp

<x-filament-panels::page>
    <div class="filament-page">
        <x-filament::card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CURRENCY_CODE', 'CHEQUE_AMOUNT', 'REVERSED', 'CONFIRMED', 'CLEARED', 'REMITTED', 'LAST_UPDATED_DATE', 'CH_YEAR'] as $column)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($flag == 0 && $count > 0)
                            @for ($i = 0; $i < $count; $i++)
                                <tr>
                                    @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CURRENCY_CODE', 'CHEQUE_AMOUNT', 'REVERSED', 'CONFIRMED', 'CLEARED', 'REMITTED', 'LAST_UPDATED_DATE', 'CH_YEAR'] as $column)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $data[$column][$i] }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endfor
                        @elseif($isFilter==1)
                            @foreach($data as $key=>$value)
                            <tr>
                                    @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CURRENCY_CODE', 'CHEQUE_AMOUNT', 'REVERSED', 'CONFIRMED', 'CLEARED', 'REMITTED', 'LAST_UPDATED_DATE'] as $column)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $value[$column]}}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="12" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    No data available
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page>
