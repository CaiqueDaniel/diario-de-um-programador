@php
    /**
     * @var \App\Models\Category $category
     * @var  \Illuminate\Contracts\Pagination\LengthAwarePaginator $response
     */
@endphp

@extends('layouts.web', [
    'title' => $category->getName(),
    'description' => $category->getName(),
    'pagename' => 'categories',
])

@section('content')
    <div class="container pt-5 bg-light">
        <x-posts.listing-post title="{{$category->getName()}}" :items="$response->items()"/>
    </div>

    <div class="d-flex justify-content-center">
        {!! $response->links() !!}
    </div>
@endsection
