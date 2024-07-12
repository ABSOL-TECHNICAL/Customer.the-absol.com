<x-filament-panels::page>
    <div class="filament-page">
        <x-filament::card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" style="background-color: #222; color: #fff;">
                    <thead class="bg-gray-800">
                        <tr>
                            @foreach (['TRX_DATE', 'TRANSACTION_TYPE', 'TRX_NUMBER', 'PURCHASE_ORDER', 'SHIP_TO_SITE', 'DUE_DATE', 'DUE_DAYS', 'PDC_AMOUNT', 'CREDITED_AMOUNT', 'BALANCE'] as $column)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-gray-700 divide-y divide-gray-200">
                        @php
                            $flag = 0;
                            $data = $data ?? [];

                            if (!empty($data) && is_array($data)) {
                                $count = count($data);
                            } else {
                                $flag = 1;
                                $count = 0; 
                            }
                        @endphp

                        @if ($flag == 0 && $count > 0)
                            @foreach ($data as $value)
                                <tr style="background-color: #444;">
                                    @foreach (['TRX_DATE', 'TRANSACTION_TYPE', 'TRX_NUMBER', 'PURCHASE_ORDER', 'SHIP_TO_SITE', 'DUE_DATE', 'DUE_DAYS', 'PDC_AMOUNT', 'CREDITED_AMOUNT', 'BALANCE'] as $column)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ $value[$column] }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 text-center">
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
