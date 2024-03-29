@extends('layouts.admin')

@section('content')
    @php
        /** @var \App\Models\Category $category */

        $action = empty($category) ? route('admin.category.store') : route('admin.category.update', ['category' => $category->getId()]);
    @endphp

    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @empty($category)
                        @method('POST')
                    @else
                        @method('PUT')
                    @endempty

                    <div class="mb-3">
                        <label for="name" class="form-label">{{__('Category')}}</label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="{{!empty($category) ? $category->getName() : old('name')}}" required>

                        <x-alerts.invalid-field field="name"/>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{__('Parents')}}</label>

                        @empty($category)
                            <x-category-selection name="parent"/>
                        @else
                            <x-category-selection name="parent" :selected="$category->parent()->get()"/>
                        @endempty

                        <x-alerts.invalid-field field="parent"/>
                    </div>

                    <x-form-action-buttons/>
                </form>
            </div>
        </div>
    </div>
@endsection
