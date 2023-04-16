<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>


    @include('layouts.common.header_style');
    @include('layouts.common.style')
    @yield('custom_style')
</head>

<body>
    <div id="wrapper">
        @include('layouts.common.sidebar')
        @include('layouts.common.navbar')


        <div class="content-wrapper">
            <div class="container-fluid">
                @yield('main')
            </div>
        </div>

        @include('layouts.common.footer')
    </div>


    @include('layouts.common.script')
    @yield('custom_script')

</body>

</html>