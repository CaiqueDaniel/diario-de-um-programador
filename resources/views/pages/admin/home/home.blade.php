@php
    /**
    * @var \App\Models\User $loggedUser
    */
    $loggedUser = auth()->user();
@endphp

@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Welcome back') }}, {{$loggedUser->name}}
                    </div>
                </div>

                <div class="row mt-4">
                    <x-shortcut href="{{route('admin.post.create')}}">
                        <i class="fa-regular fa-newspaper" style="font-size: 50px;"></i>
                        {{__('Create new article')}}
                    </x-shortcut>

                    <x-shortcut href="{{route('admin.category.create')}}">
                        <i class="fa-regular fa-object-group" style="font-size: 50px;"></i>
                        {{__('Create new category')}}
                    </x-shortcut>

                    <x-shortcut href="{{route('admin.fullbanner.create')}}">
                        <i class="fa-regular fa-image" style="font-size: 50px;"></i>
                        {{__('Create new fullbanner')}}
                    </x-shortcut>
                </div>
            </div>
        </div>
    </div>
@endsection
