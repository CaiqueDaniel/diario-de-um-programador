@extends('layouts.app')

@section('content')
    <div>
        <div id="fullbanner" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://dummyimage.com/1400x400/000/fff.png" class="d-block w-100" loading="lazy"
                         alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://dummyimage.com/1400x400/000/fff.png" class="d-block w-100" loading="lazy"
                         alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://dummyimage.com/1400x400/000/fff.png" class="d-block w-100" loading="lazy"
                         alt="...">
                </div>
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
    </div>

    <div class="container pt-5">
        <x-posts.listing-post title="Últimos artigos">
            @foreach($response->items() as $item)
                <x-posts.item-post title="{{$item->title}}" subtitle="{{$item->subtitle}}"/>
            @endforeach
        </x-posts.listing-post>
    </div>
@endsection
