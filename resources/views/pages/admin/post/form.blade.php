@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\Post $post */
        $action = empty($post) ? route('admin.post.store') : route('admin.post.update', ['post' => $post->id]);
    @endphp

    <div id="post-form" class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @empty($post)
                        @method('POST')
                    @else
                        @method('PUT')
                    @endempty

                    <div class="mb-3">
                        <label for="title" class="form-label">{{__('Title')}}</label>
                        <input type="text" name="title" class="form-control" id="title"
                               value="{{$post->title ?? old('title')}}" required>

                        <x-alerts.invalid-field field="title"/>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">{{__('Subtitle')}}</label>
                        <textarea class="form-control" name="subtitle" id="subtitle" rows="3"
                                  required>{{$post->subtitle ?? old('subtitle') }}</textarea>

                        <x-alerts.invalid-field field="subtitle"/>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Thumbnail')}}</label>

                        @if(!empty($post))
                            <img src="{{asset('storage/'.$post->thumbnail)}}" alt="Thumbnail" class="mb-3"
                                 style="width: 100%"/>
                        @endif

                        <input type="file" name="thumbnail"/>

                        <x-alerts.invalid-field field="thumbnail"/>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Article')}}</label>

                        <div id="article-root"></div>

                        <input type="hidden" id="article" name="article" value="{{$post->article ?? old('article')}}"/>

                        <x-alerts.invalid-field field="article"/>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Category')}}</label>
                        <x-category-selection name="category" multiple="true"/>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-secondary">{{__('Go Back')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
