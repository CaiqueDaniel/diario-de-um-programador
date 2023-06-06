@extends('layouts.app')

@php
    /** @var \App\Models\Post $post */
@endphp

@section('content')
    <div class="container mt-4 w-md-50">
        <h1>{{$post->title}}</h1>
        <h3>{{$post->subtitle}}</h3>

        <div class="col-12">
            <img src="{{asset("storage/{$post->thumbnail}")}}" class="d-block w-100" loading="lazy"
                 alt="{{$post->title}}">
        </div>

        <article class="mt-4" style="text-align: justify">
            {!! $post->article !!}
        </article>
    </div>
@endsection
