<h3>{{$title}}</h3>

<div class="listing row col-12 ms-0 @if(count($items)>=3) justify-content-center justify-content-md-between @endif">
    @foreach($items as $item)
        <x-posts.item-post :item="$item"/>
    @endforeach
</div>
