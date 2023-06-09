@extends('layouts.admin')

@php
    /** @var \Illuminate\Database\Eloquent\Collection $items */
@endphp

@section('content')
    <div class="container">
        <x-alerts.success/>
        <x-search-bar add="{{route('admin.category.create')}}"/>

        <div class="listing">
            @if($items->isEmpty())
                <x-alerts.empty-list/>
            @else
                <ul class="list-group list-group-horizontal header mb-3 d-none d-md-flex sticky-top">
                    <li class="list-group-item col-5">{{__('Category')}}</li>
                    <li class="list-group-item col-5">{{__('Permalink')}}</li>
                    <li class="list-group-item col-2">{{__('Actions')}}</li>
                </ul>

                @foreach($items as $item)
                    @php
                        /** @var \App\Models\Category $item */
                    @endphp

                    <ul class="list-group list-group-horizontal-md mb-1">
                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Category')}}: </b>{{$item->getName()}}
                        </li>

                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Permalink')}}: </b>{{$item->getPermalink()}}
                        </li>

                        <li class="list-group-item col-md-2 d-flex align-items-center justify-content-evenly">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    data-restore="{{route('admin.category.restore', ['category' => $item->getId()])}}"
                                    data-trash="{{route('admin.category.trash', ['category' => $item->getId()])}}"
                                    role="switch" {{$item->trashed()?'':'checked'}}
                                />
                            </div>

                            <a class="btn btn-sm btn-outline-warning"
                               href="{{route('admin.category.edit', $item->getId())}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('admin.category.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                @endforeach
            @endempty
        </div>
    </div>
@endsection
