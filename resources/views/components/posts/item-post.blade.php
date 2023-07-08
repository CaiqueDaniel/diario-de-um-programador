<div class="col-md-4 row justify-content-center mb-2 mt-2">
    <div class="card col-md-11 p-0">
        <a href="{{route('web.post.view',['slug' => $item->permalink])}}" class="text-decoration-none">
            <img src="{{asset("storage/{$item->thumbnail}")}}" class="card-img-top" alt="{{$item->title}}"
                 loading="lazy" style="min-height:300px; object-fit: cover">
            <div class="card-body">
                {{--<span class="badge rounded-pill text-bg-secondary mb-2">Tutorial</span>--}}
                <h5 class="card-title">{{$item->title}}</h5>
                <p class="card-text">{{$item->subtitle}}</p>
            </div>
        </a>
    </div>
</div>
