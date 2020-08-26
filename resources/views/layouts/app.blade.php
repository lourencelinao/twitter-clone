<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- jQuery CDN --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="app" class="bg-white">
        <div class="row">
            {{-- left side --}}
            <div class="col-lg-3 col-md-3 col-2" style="border-right: 1px solid rgba(0,0,0,.25);">
                 <div class="d-flex align-items-center flex-column" style="height: 100vh;">
                    <div class="p-2">
                        <a href="/home" class="btn">
                            <img src="{{asset('uploads/twitter.png')}}" 
                            width="30" height="30" 
                            alt="">
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="/home">
                            <i class="fa fa-home fa-2x custom-text-color"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-hashtag fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-bell fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-envelope fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-bookmark fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-list-alt fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="/users/{{Auth::id()}}">
                            <i class="fa fa-user fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="">
                            <i class="fa fa-ellipsis-h fa-2x text-dark"></i>
                        </a>
                    </div>
                    <div class="p-2">
                        <button class="btn btn-lg btn-block custom-background-color pl-5 pr-5 text-white" style="border-radius: 25px;">
                            Tweet
                        </button>
                    </div>
                    <div class="p-2 mt-auto">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-lg" 
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                            style="border-radius: 35px;" id="logout-btn">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle mr-2"
                                    style="max-height: 60px" 
                                    src="https://i.pravatar.cc/200?u={{Auth::user()->email}}" 
                                    alt="profile_picture">
                                    <div class="font-weight-bold">
                                        {{Auth::user()->name}}
                                    </div>
                                    <div class="pl-2 ml-auto">
                                        <i class="fa fa-chevron-up"></i>
                                    </div>
                                </div>
                            </button>
                            <div class="dropdown-menu">
                                <!-- Dropdown menu links -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                     {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- middle sidee --}}
            <div class="col-lg-5 col-md-3 col-10" style="height: 100vh;" id="middle">
                @yield('middle-content')
            </div>

            {{-- right side --}}
            <div class="col-lg-4 col-md-3" style="border-left: 1px solid rgba(0,0,0,.25);">
                @yield('right-content')
            </div>
        </div>
    </div>
    {{-- custom script --}}
        <script src="{{ asset('js/custom.js') }}" defer></script>
</body>
</html>
