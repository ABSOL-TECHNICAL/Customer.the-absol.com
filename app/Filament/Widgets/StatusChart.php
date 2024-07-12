<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CustomerSites;
use Carbon\Carbon;

class StatusChart extends ChartWidget
{
    protected static ?string $heading = 'Customer Application Status ';

    protected function getData(): array
    {
        $year = request()->input('year', Carbon::now()->year);
        $month = request()->input('month', Carbon::now()->month);

        $approvedCustomers = CustomerSites::query()->where('status', 'approved')->count();
        // $rejectedCustomers = CustomerSites::query()->where('status', 'rejected')->count();
        // $pendingCustomers = CustomerSites::query()->where('status', 'submited')->count();
        $incompleteCustomers = CustomerSites::query()->where('status', 'incompleted')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Customer Application Status',
                    'data' => [$approvedCustomers, $incompleteCustomers],
                    'backgroundColor' => [
                        'rgba(75, 192, 192, 0.2)', // Green (Approved)
                        // 'rgba(255, 99, 132, 0.2)', // Red (Rejected)
                        // 'rgba(255, 205, 86, 0.2)', // Yellow (Pending)
                        'rgba(153, 102, 255, 0.2)', // Gray (Incomplete)
                    ],
                    'borderColor' => [
                        'rgb(75, 192, 192)', // Green (Approved)
                        // 'rgb(255, 99, 132)', // Red (Rejected)
                        // 'rgb(255, 205, 86)', // Yellow (Pending)
                        'rgb(153, 102, 255)', // purple (Incomplete)
                    ],
                    'borderWidth' => 1,
                ],
            ],
            'labels' => ['Approved Applications', 'Incomplete (draft) Applications'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true, // Ensure Y-axis starts at zero
                    'grid' => [
                        'display' => false, // Hide the grid lines on the Y-axis
                    ],
                    'ticks' => [
                        'stepSize' => 1, // Show every number incrementing by 1
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false, // Hide the grid lines on the X-axis
                    ],
                ],
            ],
        ];
    }
}