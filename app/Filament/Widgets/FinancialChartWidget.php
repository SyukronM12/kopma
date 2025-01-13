<?php

namespace App\Filament\Widgets;

use App\Models\Loan;
use App\Models\Saving;
use Filament\Widgets\ChartWidget;

class FinancialChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Financial Chart';
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect(range(1, 6))->map(function($month) {
            return now()->subMonths($month-1)->format('M');
        })->reverse()->values();

        $loans = Loan::where('status', 'approved')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', '>=', now()->subMonths(6)->month)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $savings = Saving::where('status', 'approved')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', '>=', now()->subMonths(6)->month)
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('month')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Loan',
                    'data' => array_values($loans),
                    'borderColor' => '#f59e0b',
                ],
                [
                    'label' => 'Saving',
                    'data' => array_values($savings),
                    'borderColor' => '#10b981',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
