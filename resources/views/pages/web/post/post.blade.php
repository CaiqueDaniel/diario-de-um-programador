@php
    /** @var \App\Models\Post $post */
@endphp

@extends('layouts.web', [
    'title'=>$post->title,
    'description'=>$post->subtitle,
    'thumbnail'=>$post->thumbnail,
    'pagename'=>'posts',
])

@section('content')
    @include('pages.web.post.components.article-cover', ['post'=>$post])

    <div class="container mt-4 w-md-50 px-3 px-md-5">
        <div>
            <b>Por: {{$post->getRelation('author')->name}}</b><br/>
            <time datetime="{{$post->created_at}}">Em: @datetime($post->created_at)</time>
        </div>

        <article class="mt-4" style="text-align: justify">
            {!! $post->article !!}
        </article>
    </div>
@endsection
