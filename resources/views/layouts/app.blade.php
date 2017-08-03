<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Styles -->
    @include('../partials._styles')

</head>
<body>
    <div id="app">
        @include('../partials._navbar')

        @yield('content')
    </div>

    <!-- Scripts -->
    @include('../partials._javascript')

    @yield('scripts')
</body>
</html>
