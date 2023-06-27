<?php

namespace App\View\Components;

use App\Models\FullBanner;
use Illuminate\View\Component;
use Illuminate\View\View;

class FullBannerCarousel extends Component
{
    public function render(): View
    {
        $limitFullBanners = 5;
        $fullbanners = FullBanner::query()->limit($limitFullBanners)->get();

        return view('components.full-banner-carousel', compact('fullbanners'));
    }
}
