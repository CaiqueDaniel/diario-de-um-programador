@php
    /**
     * @var bool $sublevel
     * @var \Illuminate\Support\Collection $categories
     * @var \App\Models\Category $category
     */
@endphp

@empty($sublevel)
    <ul class="navbar-nav me-auto">
        @foreach($categories as $category)
            @if(empty($category->children()->count()))
                <x-nav-item href="{{route('web.category.view', ['category'=>$category->permalink])}}">
                    {{$category->name}}
                </x-nav-item>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="{{route('web.category.view', ['category'=>$category->permalink])}}">
                        {{$category->name}}
                    </a>

                    <x-web.layouts.navbar-categories :parent="$category"/>
                </li>
            @endif
        @endforeach
    </ul>
@elseif($categories->isNotEmpty())
    <ul class="dropdown-menu">
        @foreach($categories as $category)
            <li>
                <a class="dropdown-item" href="{{route('web.category.view', ['category'=>$category->permalink])}}">
                    {{$category->name}}
                </a>

                @if(!empty($category->getRelations()))
                    <x-web.layouts.navbar-categories :parent="$category"/>
                @endif
            </li>
        @endforeach
    </ul>
@endempty
