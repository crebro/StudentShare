<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href=" {{ asset('css/style.css') }} ">
    <title> StudentShare | Share anything you want | School Projects, Homeworks </title>

    @yield('title')
</head>
<body>
    <nav class="navigation">
        <div class="navLogo">
            <h1> <a href=" {{route('home')}} " style="text-decoration: none; color: white; "> StudentShare </a> </h1>

        </div>
        <div class="navItems">
            <ul class="nav__items">
            <li> <a class="nav__item" href=" {{ route('home') }} "> Home</a> </li>
                <li> <a href=" {{ route('mygroups') }} " class="nav__item">  My Groups </a> </li>
            <li>   <a href="{{ route('groups.create') }}"  class="nav__item"> Create </a>  </li>
                <li > <a class="nav__item">  GitHub</a>  </li>
                @auth
            <li style="display: flex; flex-direction: column;" class="nav__item">
                <a style="color: white;" class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                 {{ __('Logout') }}
             </a>
            <span style="font-size: 15px;">  {{ substr(Auth::user()->email, 0, 10) }} .. </span>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
            @csrf 
            </form> </li>

                @endauth
            </ul>
        </div>
    </nav>
    @yield('content')

</body>
</html>