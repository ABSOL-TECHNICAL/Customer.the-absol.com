<div>
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/companytypes' => 'Companytypes',
        '' => 'List',
    ]" />
    <div class="flex justify-between mt-1">
        <div class="font-bold text-xl">Company Types

        @if(session()->has('success'))
                <div class="bg-green-200 text-green-400 p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-200 text-red-400 p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div>
            {{$data}}
        </div>
    </div>

    <div>

        <form wire:submit="save" class="w-full max-w-sm flex mt-2">
            <div class="mb-4">
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700
                leading-tight focus:outline-none focus:shadow-outline"
                id="fileInput" type="file" wire:model='file'>
            </div>
            
            <div class="flex items-right justify-between mb-1 py-4 px-4 ">
                    <x-filament::button type="submit" color="warning"  size="sm">
                         Import
                    </x-filament::button>
            </div>
           
        </form>
    </div>
</div>



