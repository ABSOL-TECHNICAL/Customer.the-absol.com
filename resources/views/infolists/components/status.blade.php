<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <!-- <div> -->
        <!-- {{ $getState() }}
    </div> -->
    <table class="w-full table-auto divide-y divide-gray-200 dark:divide-white/5">
    <thead>
        <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
            <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">Status</th>
            <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">Updated by</th>
            <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">Update DateTime</th>
            <th scope="col" class="px-3 py-2 text-start text-sm font-medium text-gray-700 dark:text-gray-200">Comments</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 font-mono text-base dark:divide-white/5 sm:text-sm sm:leading-6">
        @foreach ($this->getTableData() as $row)
            <tr class="divide-x divide-gray-200 dark:divide-white/5 rtl:divide-x-reverse">
                <td class="px-3 py-1.5">{{ $row['status'] }}</td>
                <td class="px-3 py-1.5">{{ $row['updated_by'] }}</td>
                <td class="px-3 py-1.5">{{ $row['updated_at'] }}</td>
                <td class="px-3 py-1.5">{{ $row['comment'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</x-dynamic-component>
