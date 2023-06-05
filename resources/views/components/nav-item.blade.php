<li class="nav-item">
    <a class="nav-link {{url()->current() == $href ? 'active link-primary' : ''}}" href="{{$href}}">{{$slot}}</a>
</li>
