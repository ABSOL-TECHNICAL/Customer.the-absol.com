@php
    $data = $data ?? []; // Ensure $data is an array
    $count = count($data);
@endphp

<x-filament-panels::page>
    <div class="filament-page">
        <x-filament::card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CUSTOMER_NAME', 'BALANCE', 'PDC_BUCKET', 'OPEN_BUCKET', 'CURRENT_BUCKET', '1_30_DAYS', '31_60_DAYS', '61_90_DAYS','91_120_DAYS','121_180_DAYS','181_365_DAYS','1_2_YEARS','2_3_YEARS','ABOVE_3_YEARS'] as $column)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($data as $key => $value)
                            <tr>
                                @foreach (['COMPANY_ID', 'COMPANY_NAME', 'CUSTOMER_ID', 'CUSTOMER_NUMBER', 'CUSTOMER_NAME', 'BALANCE', 'PDC_BUCKET', 'OPEN_BUCKET', 'CURRENT_BUCKET', '1_30_DAYS', '31_60_DAYS', '61_90_DAYS', '91_120_DAYS', '121_180_DAYS', '181_365_DAYS', '1_2_YEARS', '2_3_YEARS', 'ABOVE_3_YEARS'] as $column)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $value[$column] ?? '' }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                    No data available
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::card>
    </div>
</x-filament-panels::page>
