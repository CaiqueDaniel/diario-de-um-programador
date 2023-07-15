@extends('layouts.admin')

@php
    /** @var \Illuminate\Database\Eloquent\Collection $items */
    $items = $response->items();
@endphp

@section('content')
    <div class="container">
        <x-alerts.success/>
        <x-search-bar add="{{route('admin.fullbanner.create')}}"/>

        <div class="listing">
            @empty($items)
                <x-alerts.empty-list/>
            @else
                <ul class="list-group list-group-horizontal header mb-3 d-none d-md-flex sticky-top">
                    <li class="list-group-item col-5">{{__('Title')}}</li>
                    <li class="list-group-item col-5">{{__('Position')}}</li>
                    <li class="list-group-item col-2">{{__('Actions')}}</li>
                </ul>

                @foreach($items as $item)
                    @php
                        /** @var \App\Models\FullBanner $item */
                    @endphp

                    <ul class="list-group list-group-horizontal-md mb-1">
                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Title')}}: </b>{{$item->getTitle()}}
                        </li>

                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Position')}}: </b>{{$item->getPosition()}}
                        </li>

                        <li class="list-group-item col-md-2 d-flex align-items-center justify-content-evenly">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    data-restore="{{route('admin.fullbanner.restore', ['fullbanner' => $item->getId()])}}"
                                    data-trash="{{route('admin.fullbanner.trash', ['fullbanner' => $item->getId()])}}"
                                    role="switch" {{$item->trashed()?'':'checked'}}
                                />
                            </div>

                            <a class="btn btn-sm btn-outline-warning"
                               href="{{route('admin.fullbanner.edit', $item->getId())}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('admin.fullbanner.destroy', $item) }}" method="POST">
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
