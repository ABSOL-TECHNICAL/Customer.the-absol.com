<style>
    .my-custom-text h6 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }
</style>

<x-filament-panels::page class="fi-dashboard-page">
    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <!-- Add your custom text here -->
    <div class="my-custom-text">
        <h6>My Status</h6>
    </div>

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
</x-filament-panels::page>
