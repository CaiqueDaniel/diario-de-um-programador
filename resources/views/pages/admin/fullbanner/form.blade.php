@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\FullBanner $fullbanner */

        $action = empty($fullbanner) ? route('admin.fullbanner.store') : route('admin.fullbanner.update', ['fullbanner' => $fullbanner->id]);
    @endphp

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @empty($fullbanner)
                        @method('POST')
                    @else
                        @method('PUT')
                    @endempty

                    <div class="mb-3">
                        <label for="title" class="form-label">{{__('Title')}}*</label>
                        <input type="text" name="title" class="form-control" id="title"
                               value="{{$fullbanner->title ?? old('title')}}" required>

                        <x-alerts.invalid-field field="title"/>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">{{__('Link')}}*</label>
                        <input type="text" name="link" class="form-control" id="link"
                               value="{{$fullbanner->link ?? old('link')}}" required>

                        <x-alerts.invalid-field field="link"/>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Image')}}*</label>

                        @if(!empty($fullbanner))
                            <img src="{{asset('storage/'.$fullbanner->image)}}" alt="Image" class="mb-3"
                                 style="width: 100%"/>
                        @endif

                        <input type="file" name="image"/>

                        <x-alerts.invalid-field field="image"/>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-secondary">{{__('Go Back')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
