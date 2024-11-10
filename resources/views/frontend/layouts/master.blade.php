<!DOCTYPE html>
<html lang="ENG">
@php
    $settings = DB::table('settings')->get()->first();
@endphp

<head>
    @include('frontend.layouts.head')
    {!! $settings->seo !!}

    @stack('stylesheets')
</head>

<body class="js" id="body">
    {!! $settings->analytics !!}
    <!-- Header -->
    @include('frontend.layouts.header')
    <!--/ End Header -->
    @yield('main-content')

    @include('frontend.layouts.footer')

    @stack('scripts')


</body>

</html>
