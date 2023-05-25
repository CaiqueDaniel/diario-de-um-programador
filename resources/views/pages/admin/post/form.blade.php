@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.post.store')}}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="title" class="form-label">{{__('Title')}}</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label">{{__('Subtitle')}}</label>
                        <textarea class="form-control" name="subtitle" id="subtitle" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">{{__('Article')}}</label>
                        <textarea class="form-control" name="article" id="article" rows="3" required></textarea>
                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-secondary">Voltar</a>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
