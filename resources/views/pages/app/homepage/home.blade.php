@extends('layouts.app')

@section('content')
    <div>
        <x-full-banner-carousel/>
    </div>

    <div class="container pt-5 bg-light">
        <x-posts.listing-post title="Últimos artigos" :items="$response->items()"/>
    </div>
@endsection
