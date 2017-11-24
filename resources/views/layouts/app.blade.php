<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include ('layouts.navbar')

        <div class="container">
            <div class="row">

                <div class="blog-header">
                    <h1 class="blog-title">The Bootstrap Blog</h1>
                    <p class="lead blog-description">The official example template of creating a blog with Bootstrap.</p>
                </div>

                @yield ('content')
                
                @if ( ! (Request::path() === 'login' || Request::path() === 'register') )
                    @include ('layouts.sidebar')
                @endif

            </div><!-- /.row -->
        </div>

        @include ('layouts.footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield ('scripts')
</body>
</html>
