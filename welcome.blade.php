<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

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
                position: absolute;
                top: 50px;
                text-align: center;
            }

            .title {
                font-size: 40px;
            }
            p{
                color: #636b6f;
                font-size: 20px;
                font-weight: 600;
            }
            p b{
                color: #000000;
                font-size: 25px;
                font-weight: 600;
            }
            .peragrapg p{
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
            }
            .peragrapg strong{
                color: #000000;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
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

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height container">
            @if (Route::has('login'))
                <div class="top-right links row">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="jumbotron">
                    <div class="title m-b-md">
                        Demo Account - for practice.
                    </div>
                    <div class="peragrapg">
                        <p>Use the email and password that given below to login the Demo Account, You can see the preview of this application before sign up. </p>
                        <p>Demo Email: <strong>raihansarkar1@gmail.com</strong></p>
                        <p>Demo Password: <strong>12345678</strong></p>
                    </div>
                    
                </div>

                <div class="title m-b-md">
                    GetStart || Doc || Instalation
                </div>
                <div>
                    <p>Step 1: If you are new and you have no account here then very first you have to Registration, Click <b>REGISTER</b> Button</p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/register.png')}}" alt="Register image">

                    <p>Step 2: If you want you can <b>Submit</b> your friends reference code or click <b>Skip</b>,</p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/reference.png')}}" alt="Reference image">
                    <p>Step 3: Yor account is ready, your can add your all product, click <b>Add</b></p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/empty_home.png')}}" alt="Reference image">

                    <p>Step 4: Add your Product with giving your all products details</p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/add_product.png')}}" alt="Add Product image">
                    <p>Step 5: Make your Admin Account for admin panael</p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/click_deshboard.png')}}" alt="Add Product image">
                    <img class="img-responsive" src="{{ URL::to('img/demo/admin_signup.png')}}" alt="Add Product image">
                    <img class="img-responsive" src="{{ URL::to('img/demo/deshboard.png')}}" alt="Add Product image">
                    <p>Step 6: Start Business</p>
                    <img class="img-responsive" src="{{ URL::to('img/demo/home.png')}}" alt="Add Product image">
                </div>
                

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
