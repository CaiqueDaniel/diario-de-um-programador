@extends('layouts.admin')

@section('content')
    @php
        /**
        * @var \Illuminate\Pagination\LengthAwarePaginator $response
        * @var \App\Models\Post[] $items
        */
        $items = $response->items();
    @endphp

    <div class="container">
        <x-alerts.success/>
        <x-search-bar add="{{route('admin.post.create')}}"/>

        <div class="listing">
            @empty($items)
                <x-alerts.empty-list/>
            @else
                <ul class="list-group list-group-horizontal header mb-3 d-none d-md-flex sticky-top">
                    <li class="list-group-item col-5">{{__('Title')}}</li>
                    <li class="list-group-item col-3">{{__('Author')}}</li>
                    <li class="list-group-item col-2">{{__('Published At')}}</li>
                    <li class="list-group-item col-2">{{__('Actions')}}</li>
                </ul>

                @foreach($items as $item)
                    <ul class="list-group list-group-horizontal-md mb-1">
                        <li class="list-group-item col-md-5">
                            <b class="d-md-none">{{__('Title')}}: </b>{{$item->title}}
                        </li>

                        <li class="list-group-item col-md-3">
                            <b class="d-md-none">{{__('Author')}}: </b>{{$item->getRelation('author')->name}}
                        </li>

                        <li class="list-group-item col-md-2">
                            <b class="d-md-none">{{__('Published At')}}: </b>@datetime($item->created_at)
                        </li>

                        <li class="list-group-item col-md-2 d-flex align-items-center justify-content-evenly">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    data-restore="{{route('admin.post.restore', ['post' => $item->id])}}"
                                    data-trash="{{route('admin.post.trash', ['post' => $item->id])}}"
                                    role="switch" {{$item->trashed()?'':'checked'}}
                                />
                            </div>

                            <a class="btn btn-sm btn-outline-warning" href="{{route('admin.post.edit', $item->id)}}">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </a>

                            <form action="{{ route('admin.post.destroy', $item) }}" method="POST">
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

        <div class="d-flex justify-content-center">
            {!! $response->links() !!}
        </div>
    </div>
@endsection
