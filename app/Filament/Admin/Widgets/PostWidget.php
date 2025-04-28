<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PostWidget extends BaseWidget
{


    protected function getStats(): array
    {

        return [
            Stat::make('Total Blogs', Blog::count())
                ->description('Blogs')
                ->color('primary')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->url(route('filament.admin.resources.blogs.index'))
                ->openUrlInNewTab(false),
            Stat::make('Total Subscribers', Subscriber::count())
                ->description('Subscribers')
                ->descriptionIcon('heroicon-o-user-plus')
                ->color('primary')
                ->url(route('filament.admin.resources.subscribers.index'))
                ->openUrlInNewTab(false),
            Stat::make('Total Product', Product::count())
                ->description('Products')
                ->descriptionIcon('heroicon-o-cube')
                ->color('primary')
                ->url(route('filament.admin.resources.products.index'))
                ->openUrlInNewTab(false),
            Stat::make('Total User', User::count())
                ->description('Users')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary')
                ->url(route('filament.admin.resources.users.index'))
                ->openUrlInNewTab(false),

        ];
    }
}
