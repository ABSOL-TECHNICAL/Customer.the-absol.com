@php
    $data = $data ?? [];
    $count = count($data);
@endphp

<x-filament-panels::page>
    <div class="filament-page">
        <x-filament::card>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['CUSTOMER_NUMBER', 'CUSTOMER_NAME', 'CHEQUE_NUMBER', 'CHEQUE_DATE', 'GL_DATE', 'MATURITY_DATE', 'CHEQUE_AMOUNT', 'CHEQUE_STATUS'] as $column)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ $column }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($data as $item)
                            <tr>
                                @foreach (['CUSTOMER_NUMBER', 'CUSTOMER_NAME', 'CHEQUE_NUMBER', 'CHEQUE_DATE', 'GL_DATE', 'MATURITY_DATE', 'CHEQUE_AMOUNT', 'CHEQUE_STATUS'] as $column)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item[$column] }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
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
