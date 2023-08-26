@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\User $user */
        $action = empty($user) ? route('admin.user.store') : route('admin.post.update', ['post' => $user->getId()]);
    @endphp

    <div id="post-form" class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @empty($user)
                        @method('POST')
                    @else
                        @method('PUT')
                    @endempty

                    <div class="mb-3">
                        <label for="email" class="form-label">{{__('E-mail')}}*</label>
                        <input type="text" name="email" class="form-control" id="email"
                               value="{{!empty($user) ? $user->getEmail() : old('email')}}" required>

                        <x-alerts.invalid-field field="email"/>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Name')}}*</label>
                        <input type="text" class="form-control" name="name" id="name"
                               value="{{!empty($user) ? $user->getName() : old('name') }}" required>

                        <x-alerts.invalid-field field="name"/>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-secondary">{{__('Go Back')}}</a>
                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
