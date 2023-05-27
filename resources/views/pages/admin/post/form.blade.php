@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\Post $post */
        $action = empty($post) ? route('admin.post.store') : route('admin.post.update', ['post' => $post->id]);
    @endphp

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{$action}}" method="POST">
                    @csrf

                    @empty($post)
                        @method('POST')
                    @else
                        @method('PUT')
                    @endempty

                    <div class="mb-3">
                        <label for="title" class="form-label">{{__('Title')}}</label>
                        <input type="text" name="title" class="form-control" id="title"
                               value="{{old('title') ?? $post->title}}" required>

                        <x-alerts.invalid-field field="title"/>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">{{__('Subtitle')}}</label>
                        <textarea class="form-control" name="subtitle" id="subtitle" rows="3"
                                  required>{{old('subtitle') ?? $post->subtitle}}</textarea>

                        <x-alerts.invalid-field field="subtitle"/>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Article')}}</label>
                        <textarea class="form-control" name="article" id="article" rows="3"
                                  required>{{old('article') ?? $post->article}}</textarea>

                        <x-alerts.invalid-field field="article"/>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
