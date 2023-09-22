<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon.ico') }}" type="image/x-icon">
    <!--===============================================================================================-->
    @include('frontend.components.styles')
</head>

<body class="animsition">

    <!-- Header -->
    @include('frontend.components.header')

    <!-- Cart -->
    @include('frontend.components.cart')

    @yield('content')

    @include('frontend.components.footer')

    @stack('modals')
    <!--===============================================================================================-->
    @include('frontend.components.scripts')

    @stack('scripts')

</body>

</html>
