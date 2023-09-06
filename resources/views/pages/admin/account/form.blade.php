@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\User $user */
    @endphp

    <div id="post-form" class="container">
        <div class="card">
            <div class="card-body">
                <x-alerts.success/>

                <form action="{{route('admin.account.update',['user'=>$user->getId()])}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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

                    <div class="mb-3">
                        <label for="password" class="form-label">{{__('Password')}}</label>
                        <input type="password" class="form-control" name="password" id="password"
                               value="{{ old('password') }}">

                        <x-alerts.invalid-field field="password"/>
                    </div>

                    <x-form-action-buttons/>
                </form>
            </div>
        </div>
    </div>
@endsection
