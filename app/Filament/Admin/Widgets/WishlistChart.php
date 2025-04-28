<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Wishlist;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class WishlistChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {

        $wishlist = Wishlist::select(DB::raw('DATE_FORMAT(created_at,"%M-%D") as month'),  DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $wishlist
            ->pluck('month')
            ->toArray();
        $data = $wishlist
            ->pluck('count')
            ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Wishlist',
                    'data' => $data,
                    'backgroundColor' => '#35A92B',
                    'borderColor' => '#35A92B',
                    'borderWidth' => 1
                ],
            ],
            'labels' => $labels
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
