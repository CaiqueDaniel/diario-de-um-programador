<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\{Component, View};

class CategorySelection extends Component
{
    private bool $isFirstLevel, $multiple;
    private string $name;
    private Collection $items, $selected;

    public function __construct(Collection $items, Collection $selected, string $name, bool $multiple = false)
    {
        $this->name = $name;
        $this->multiple = $multiple;
        $this->isFirstLevel = $items->isEmpty();
        $this->items = $this->isFirstLevel ? Category::with('children')->whereNull('parent')->get() : $items;
        $this->selected = $selected;
    }

    public function render(): View
    {
        $parameters = [
            'name' => $this->name,
            'items' => $this->items,
            'selected' => $this->selected,
            'multiple' => $this->multiple,
            'isFirstLevel' => $this->isFirstLevel
        ];

        return view('components.category-selection', $parameters);
    }
}
