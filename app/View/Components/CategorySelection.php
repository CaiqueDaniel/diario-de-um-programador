<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\{Component, View};

class CategorySelection extends Component
{
    private Collection $items;

    public function __construct(Collection $items)
    {
        $this->items = $items->isEmpty() ? Category::with('children')->whereNull('parent')->get() : $items;
    }

    public function render(): View
    {
        return view('components.category-selection', ['items' => $this->items]);
    }
}
