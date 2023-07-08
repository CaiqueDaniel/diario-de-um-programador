<?php

namespace App\View\Components\Web\Layouts;

use App\Models\Category;
use Illuminate\View\{Component, View};

class NavbarCategories extends Component
{
    private ?Category $parent;

    public function __construct($parent = null)
    {
        $this->parent = $parent;
    }

    public function render(): View
    {
        $sublevel = false;

        if ($this->parent) {
            $sublevel = true;
            $categories = $this->parent->children()->with('children')->get();
        } else
            $categories = Category::query()->whereNull('parent')->with('children')->get();

        return view('components.web.layouts.navbar-categories', compact('categories', 'sublevel'));
    }
}
