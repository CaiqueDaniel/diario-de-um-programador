@extends('layouts.admin')

@section('content')
    @php
        /**
        * @var \Illuminate\Pagination\LengthAwarePaginator $response
        * @var \App\Models\User[] $items
        */
        $items = $response->items();
    @endphp

    <div class="container">
        <x-alerts.success/>
        <x-search-bar add="{{route('admin.user.create')}}"/>

        <div class="listing">
            @empty($items)
                <x-alerts.empty-list/>
            @else
                <ul class="list-group list-group-horizontal header mb-3 d-none d-md-flex sticky-top">
                    <li class="list-group-item col-5">{{__('Name')}}</li>
                    <li class="list-group-item col-5">{{__('E-mail')}}</li>
                    <li class="list-group-item col-2">{{__('Actions')}}</li>
                </ul>

                @foreach($items as $item)
                    <ul class="list-group list-group-horizontal-md mb-1">
                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Name')}}: </b>{{$item->getName()}}
                        </li>

                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('E-mail')}}: </b>{{$item->getEmail()}}
                        </li>

                        <li class="list-group-item col-md-2 d-flex align-items-center justify-content-evenly item-actions">
                            <a class="btn btn-sm btn-outline-warning"
                               href="{{route('admin.user.edit', $item->getId())}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            @if(auth()->user()->getAuthIdentifier()!=$item->getId())
                                <form action="{{ route('admin.user.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </li>
                    </ul>
                @endforeach
            @endempty
        </div>

        <div class="d-flex justify-content-center">
            {!! $response->links() !!}
        </div>
    </div>
@endsection
