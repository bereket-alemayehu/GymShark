<?php

namespace App\Filament\Admin\Widgets;

use App\Models\CartItem;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class Chart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 2;

    protected function getData(): array
    {

        $cartItems = CartItem::select(DB::raw('DATE_FORMAT(created_at,"%M-%D") as month'),  DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $labels = $cartItems
            ->pluck('month')
            ->toArray();
        $data = $cartItems
            ->pluck('count')
            ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Cart Items',
                    'data' => $data,
                    'backgroundColor' => '#25a7d5',
                    'borderColor' => '#25a7d5',
                    'borderWidth' => 1,
                ],

            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
