<ul class="rounded p-2 list-group @if($isFirstLevel) bg-light border @endif" id="category-selection"
    style="min-height: 100px;">
    @if($items->isEmpty())
        <x-alerts.empty-list/>
    @endempty

    @foreach($items as $i)
        @php
            /**
            * @var \App\Models\Category $i
            * @var \Illuminate\Support\Collection $selected
            */
            if(empty($i->getRelations()))
                $children = $i->children()->get();
            else
                $children = $i->getRelation('children');

            $hasChildren = $children->isNotEmpty();
        @endphp

        <li class="list-group-item" style="min-height: 50px;">
            <div class="row align-items-center">
                <div class="form-check col-11 m-0">
                    <input class="form-check-input" type="{{$multiple ? 'checkbox' : 'radio'}}" name="{{$name}}"
                           id="{{$i->permalink}}"
                           value="{{$i->id}}"
                        {{$selected->contains('id','=',$i->id) ? 'checked' : ''}}
                    >
                    <label class="form-check-label" for="{{$i->permalink}}">{{$i->name}}</label>
                </div>

                @if($hasChildren)
                    <button class="btn btn-link btn-sm col-1" type="button" data-bs-toggle="collapse"
                            data-bs-target="#cat-{{$i->id}}">
                        <i class="fa-sharp fa-solid fa-chevron-down"></i>
                    </button>
                @endif
            </div>

            <div class="collapse" id="cat-{{$i->id}}">
                @if($hasChildren)
                    <x-category-selection name="{{$name}}" multiple="{{$multiple}}" :items="$children" :selected="$selected"/>
                @endif
            </div>
        </li>
    @endforeach

    @if($isFirstLevel)
        <button type="button" id="btn-clear-category-selection" class="btn btn-outline-danger btn-sm mt-2">
            Limpar
        </button>
    @endif
</ul>
