@php
    /**
     * @var \Illuminate\Support\Collection<int,\App\Models\FullBanner> $fullbanners
     * @var \App\Models\FullBanner $banner
     */
@endphp

<div id="fullbanner" class="carousel slide">
    <div class="carousel-inner">
        @foreach($fullbanners as $index => $banner)
            <div class="carousel-item {{$index==0 ? 'active' : ''}}">
                <a href="{{$banner->getLink()}}" title="{{$banner->getTitle()}}" class="text-decoration-none">
                    <img src="{{asset("storage/{$banner->getImage()}")}}" class="d-block w-100" loading="lazy"
                         alt="{{$banner->getTitle()}}" style="height: 400px; object-fit: cover;">

                    <div class="
                        hud-cover
                        position-absolute top-0
                        w-100 h-100
                        d-flex flex-column justify-content-center align-items-center
                        px-2
                    ">
                        <h3 class="text-white" style="font-size: 30px;">{{$banner->getTitle()}}</h3>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#fullbanner" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#fullbanner" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
