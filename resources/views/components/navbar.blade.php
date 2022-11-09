<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">
            <img src="/images/picwish.png" alt="Logo" width="120" height="36" class="d-inline-block align-text-top">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                @foreach($navbarItems as $navbarItem)
                    <li class="nav-item">
                        <a class="nav-link" href="{{$navbarItem['url']}}">{{$navbarItem['title']}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>