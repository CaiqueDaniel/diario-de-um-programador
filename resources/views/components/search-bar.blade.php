<nav class="navbar navbar-expand-lg bg-light border rounded mb-5">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between w-100">
            <form class="d-flex" role="search" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="{{__('Search')}}"
                       aria-label="{{__('Search')}}">
                <button class="btn btn-outline-success" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <a href="{{$add}}" class="text-decoration-none p-2 p-md-0" style="margin-left: 8px">
                <div class="d-flex flex-column align-items-center">
                    <i class="fa-regular fa-plus"></i>
                    <span class="d-none d-md-block">{{__('Add')}}</span>
                </div>
            </a>
        </div>
    </div>
</nav>
