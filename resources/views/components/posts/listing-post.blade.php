<h3>{{$title}}</h3>

<div class="d-flex justify-content-center">
    <div class="listing row col-12 @if(count($items)>=3) justify-content-center justify-content-md-start @endif">
        @foreach($items as $item)
            <x-posts.item-post :item="$item"/>
        @endforeach
    </div>
</div>
