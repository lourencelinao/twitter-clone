<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        {{-- font awesome --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    </head>
    <body style="background-color: #1DA1F2;">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color: white;">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="color: white;">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="color: white;">Register</a>
                        @endif
                    @endauth
                </div>
            @endif



            <div class="content" style="color: white;">
                <div class="title m-b-md text-white">
                    Twitter
                </div>
                    <p>made by Lourence Linao</p>
                <div class="links" >
                    <a href="https://github.com/lourencelinao/twitter-clone.git" target="_blank" style="color: white;">
                        <i class="fab fa-github fa-3x"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/lourence-linao-124150177/" target="_blank" style="color: white;">
                        <i class="fab fa-linkedin fa-3x"></i>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
