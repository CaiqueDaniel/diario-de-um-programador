<ul class="bg-light border rounded p-2 list-group" style="min-height: 100px;">
    @if($items->isEmpty())
        <x-alerts.empty-list/>
    @endempty

    @foreach($items as $i)
        @php
            /** @var \App\Models\Category $i */
            if(empty($i->getRelations()))
                $children = $i->children()->get();
            else
                $children = $i->getRelation('children');

            $hasChildren = $children->isNotEmpty();
        @endphp

        <li class="list-group-item" style="min-height: 50px;">
            <div class="row align-items-center">
                <div class="form-check col-11">
                    <input class="form-check-input" type="radio" name="parent" id="{{$i->permalink}}"
                           value="{{$i->id}}">
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
                    <x-category-selection :items="$children"/>
                @endif
            </div>
        </li>
    @endforeach
</ul>
