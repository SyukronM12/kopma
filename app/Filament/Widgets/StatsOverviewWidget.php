<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Models\Loan;
use App\Models\Saving;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Members', Member::count())
                ->description('Total active members')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('secondary'),

            Stat::make('Total Loans', 'Rp' . number_format(Loan::where('status', 'approved')->sum('amount')))
                ->description('Total active loans')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Total Savings', 'Rp' . number_format(Saving::where('status', 'approved')->sum('amount')))
                ->description('Total saving')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),
        ];
    }
}
