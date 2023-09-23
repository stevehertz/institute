<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="keywords" content="@yield('meta_keywords', '')">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--===============================================================================================-->
    <link rel="shortcut icon" href="{{ asset('storage/logo/favicon.ico') }}" type="image/x-icon">
    <!--===============================================================================================-->
    @include('frontend.components.styles')
</head>

<body class="animsition">

    <!-- Header -->
    @include('frontend.components.header')

    @include('frontend.layouts.modals.loginModal')

    <!-- Cart -->
    @include('frontend.components.cart')

    @yield('content')

    @include('frontend.components.footer')

    @stack('modals')
    <!--===============================================================================================-->
    @include('frontend.components.scripts')

    @stack('scripts')

    @stack('after-scripts')

    <script>
        @if (request()->has('user') && request('user') == 'admin')
            $('#myModal').modal('show');
            $('#loginForm').find('#email').val('admin@lms.com')
            $('#loginForm').find('#password').val('secret')
        @elseif (request()->has('user') && request('user') == 'student')
            $('#myModal').modal('show');
            $('#loginForm').find('#email').val('student@lms.com')
            $('#loginForm').find('#password').val('secret')
        @elseif (request()->has('user') && request('user') == 'teacher')
            $('#myModal').modal('show');
            $('#loginForm').find('#email').val('teacher@lms.com')
            $('#loginForm').find('#password').val('secret')
        @endif
    </script>

</body>

</html>
