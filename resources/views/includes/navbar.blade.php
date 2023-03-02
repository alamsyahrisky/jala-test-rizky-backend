<!-- Navbar -->
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-white">
        <div class="container">
            <a href="{{route('home')}}" class="navbar-brand">
                <img src="{{url('backend/dist/assets/media/logos/jala.png')}}" alt="Logo Nomads">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-3 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}#product">Product</a>
                    </li>
                    @auth
                    @if ($cart['total'] >0)
                        <li class="nav-item">
                            <a href="{{route('checkout',$cart['id'])}}" class="nav-link position-relative">
                                Cart
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{$cart['total']}}
                                <span class="visually-hidden">cart total</span>
                                </span>
                            </a>
                        </li>
                    @endif
                    @endauth
                </ul>

                @guest
                    <!-- mobile login -->
                    <form class="form-inline d-sm-block d-md-none">
                        <button class="btn btn-login my-2 my-sm-0" type="button" onclick="event.preventDefault();location.href='{{url('login');}}'">
                            Masuk
                        </button>
                    </form>

                    <!-- desktop login -->
                    <form class="form-inline my-2 my-lg-0 d-none d-md-block">
                        <button class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="button" onclick="event.preventDefault();location.href='{{url('login');}}'">
                            Masuk
                        </button>
                    </form>
                @endguest

                @auth
                    
                    <!-- mobile login -->
                    <div class="form-inline d-sm-block d-md-none">
                        @csrf
                        <button onclick="event.preventDefault();location.href='{{url('profile');}}'" class="btn btn-login my-2 my-sm-0" type="button">
                            {{Auth::user()->name}}
                        </button>
                    </div>

                    <!-- desktop login -->
                    <div class="form-inline my-2 my-lg-0 d-none d-md-block">
                        @csrf
                        <button onclick="event.preventDefault();location.href='{{url('profile');}}'" class="btn btn-login btn-navbar-right my-2 my-sm-0 px-4" type="button">
                            {{Auth::user()->name}}
                        </button>
                    </div>
                @endauth

            </div>
        </div>
    </nav>
</div>