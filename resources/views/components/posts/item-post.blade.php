@php
    /**
    * @var \App\Models\Post $item
    * @var \Illuminate\Support\Collection $categories
    */
    $categories = $item->getCategories();
@endphp

<div class="col-md-4 row justify-content-center mb-2 mt-2">
    <div class="card col-md-11 p-0">
        <a href="{{route('web.post.view',['slug' => $item->getPermalink()])}}" class="text-decoration-none">
            @empty($item->getThumbnail())
                <img src="{{asset("assets/default-post-cover-list.png")}}" class="card-img-top" alt="{{$item->getTitle()}}"
                     loading="lazy" style="min-height:300px; object-fit: cover">
            @else
                <img src="{{asset("storage/{$item->getThumbnail()}")}}" class="card-img-top" alt="{{$item->getTitle()}}"
                     loading="lazy" style="min-height:300px; object-fit: cover">
            @endempty
            <div class="card-body">
                @if($categories->isNotEmpty())
                    <span class="badge rounded-pill text-bg-secondary mb-2">
                        {{$categories->last()->getName()}}
                    </span>
                @endif

                <h5 class="card-title">{{$item->getTitle()}}</h5>
                <p class="card-text">{{$item->getSubtitle()}}</p>
            </div>
        </a>
    </div>
</div>
