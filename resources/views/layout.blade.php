<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Udemy App</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('css')
</head>
<body>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Laravel Blog</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="{{ route('home') }}">{{__('Home') }}</a>
        <a class="p-2 text-dark" href="{{ route('contact') }}">{{ __('Contact') }}</a>
        <a class="p-2 text-dark" href="{{ route('posts.index') }}">{{ __('Blog Posts') }}</a>
        <a class="p-2 text-dark" href="{{ route('posts.create') }}">{{ __('Add') }} {{ __('Post') }}</a>
        @guest
            @if(Route::has('register'))
                <a class="p-2 text-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            <a class="p-2 text-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
        @else
            <form style="display: none;" id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
            <a onclick="event.preventDefault();document.getElementById('logout-form').submit()" class="p-2 text-dark" href="{{ route('login') }}">{{ __('Logout') }} ({{ Auth::user()->name }})</a>
        @endguest
    </nav>
</div>

<div class="container">
    @if(session()->has('status'))
        <p style="color:green">
            {{  session()->get('status')  }}
        </p>
    @endif

    @yield('content')
</div>

@yield('js')
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
