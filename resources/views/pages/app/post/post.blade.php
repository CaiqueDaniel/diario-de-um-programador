@extends('layouts.app', ['pagename'=>'posts'])

@php
    /** @var \App\Models\Post $post */
@endphp

@section('content')
    @include('pages.app.post.components.article-cover', ['post'=>$post])

    <div class="container mt-4 w-md-50">
        <div>
            <b>Por: {{$post->getRelation('author')->name}}</b><br/>
            <time datetime="{{$post->created_at}}">Em: @datetime($post->created_at)</time>
        </div>

        <article class="mt-4" style="text-align: justify">
            {!! $post->article !!}
        </article>
    </div>
@endsection
