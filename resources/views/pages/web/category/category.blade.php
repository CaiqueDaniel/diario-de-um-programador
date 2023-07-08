@php
    /**
     * @var \App\Models\Category $category
     * @var  \Illuminate\Contracts\Pagination\LengthAwarePaginator $response
     */
@endphp

@extends('layouts.web', [
    'title' => $category->name,
    'description' => $category->name,
    'pagename' => 'categories',
])

@section('content')
    <div class="container pt-5 bg-light">
        <x-posts.listing-post title="{{$category->name}}" :items="$response->items()"/>
    </div>

    <div class="d-flex justify-content-center">
        {!! $response->links() !!}
    </div>
@endsection
