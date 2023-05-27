@extends('layouts.admin')

@section('content')
    <div class="container">
        <x-alerts.success/>

        <div class="listing">
            <ul class="list-group list-group-horizontal header mb-3 d-none d-md-flex sticky-top">
                <li class="list-group-item col-5">{{__('Title')}}</li>
                <li class="list-group-item col-3">{{__('Author')}}</li>
                <li class="list-group-item col-2">{{__('Published At')}}</li>
                <li class="list-group-item col-2">{{__('Actions')}}</li>
            </ul>

            @foreach($response->items() as $item)
                <ul class="list-group list-group-horizontal-md mb-1">
                    <li class="list-group-item col-md-5">
                        <b class="d-md-none">{{__('Title')}}: </b>{{$item->title}}
                    </li>

                    <li class="list-group-item col-md-3">
                        <b class="d-md-none">{{__('Author')}}: </b>{{$item->getRelation('author')->name}}
                    </li>

                    <li class="list-group-item col-md-2">
                        <b class="d-md-none">{{__('Published At')}}: </b>{{$item->created_at}}
                    </li>

                    <li class="list-group-item col-md-2 d-flex align-items-center justify-content-evenly">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"/>
                        </div>

                        <a class="btn btn-sm btn-outline-warning" href="{{route('admin.post.edit', $item->id)}}">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </li>
                </ul>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {!! $response->links() !!}
        </div>
    </div>
@endsection
