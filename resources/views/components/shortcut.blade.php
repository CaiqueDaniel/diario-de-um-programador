@php
    /**
     * @var string $href
     * @var mixed $slot
     */
@endphp

<a href="{{$href}}" class="text-decoration-none col-md-4 mb-2">
    <div class="card">
        <div class="card-body d-flex flex-column align-items-center">
            {{$slot}}
        </div>
    </div>
</a>
