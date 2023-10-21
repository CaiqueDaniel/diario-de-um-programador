@php
    /** @var \App\Models\Post $post */
@endphp

@extends('layouts.web', [
    'title'=>$post->getTitle(),
    'description'=>$post->getSubtitle() ?? $post->getTitle(),
    'thumbnail'=>$post->getThumbnail(),
    'pagename'=>'posts',
])

@section('content')
    @include('pages.web.post.components.article-cover', ['post'=>$post])

    <div class="container mt-4 w-md-50 px-3 px-md-5">
        <div>
            <b>Por: {{$post->getRelation('author')->name}}</b><br/>
            @php($publishedAt = $post->getPublishedAt())
            <time datetime="{{$post->getPublishedAt()}}">Em: @datetime($publishedAt)</time>
        </div>

        <article class="mt-4">
            {!! $post->getArticle() !!}
        </article>
    </div>
@endsection
