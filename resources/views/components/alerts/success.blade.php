@if($message = session()->get('message'))
    <div class="alert alert-success d-flex justify-content-center">
        {{$message}}
    </div>
@endif
