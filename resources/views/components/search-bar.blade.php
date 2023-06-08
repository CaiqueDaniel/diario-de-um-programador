<nav class="navbar navbar-expand-lg bg-light border rounded mb-5">
    <div class="container-fluid">
        <form class="d-flex" role="search" method="GET" action="">
            <input class="form-control me-2" type="search" name="search" placeholder="{{__('Search')}}" aria-label="{{__('Search')}}">
            <button class="btn btn-outline-success" type="submit">{{__('Search')}}</button>
        </form>

        <a href="{{$add}}" class="text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <i class="fa-regular fa-plus"></i>
                <span>{{__('Add')}}</span>
            </div>
        </a>
    </div>
</nav>
