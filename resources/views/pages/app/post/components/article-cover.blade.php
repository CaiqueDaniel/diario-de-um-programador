@php
    /** @var \App\Models\Post $post */
@endphp

<div class="col-12 position-relative" id="article-cover">
    <img src="{{asset("storage/{$post->thumbnail}")}}" class="d-block w-100" loading="lazy"
         alt="{{$post->title}}">

    <div class="
            hud-cover
            position-absolute top-0
            w-100 h-100
            d-flex flex-column justify-content-center align-items-center
            px-2
        ">
        <h1 class="text-white">{{$post->title}}</h1>
        <h3 class="text-white">{{$post->subtitle}}</h3>
    </div>
</div>
