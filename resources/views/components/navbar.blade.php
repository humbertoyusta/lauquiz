<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">
            <img src="/images/picwish.png" alt="Logo" width="120" height="36" class="d-inline-block align-text-top">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="container-fluid d-flex justify-content-between">
                <ul class="navbar-nav">
                    @foreach($navbarItems as $navbarItem)
                        <li class="nav-item">
                            <a class="nav-link" href="{{$navbarItem['url']}}">{{$navbarItem['title']}}</a>
                        </li>
                    @endforeach
                </ul>

                <div>
                    @if(\Illuminate\Support\Facades\Auth::user())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    @else
                        <a href="{{route('login')}}" class="btn btn-outline-dark">{{ __('Log In') }}</a>
                        <a href="{{route('register')}}" class="btn btn-outline-dark">{{ __('Register') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>