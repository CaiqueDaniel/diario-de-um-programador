<div id="fullbanner" class="carousel slide">
    <div class="carousel-inner">
        @foreach($fullbanners as $index => $banner)
            <div class="carousel-item {{$index==0 ? 'active' : ''}}">
                <img src="{{asset("storage/{$banner->image}")}}" class="d-block w-100" loading="lazy"
                     alt="{{$banner->name}}" style="max-height: 400px; object-fit: cover;">
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
