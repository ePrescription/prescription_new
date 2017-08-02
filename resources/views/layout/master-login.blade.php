<html>
<head>
    <title>Login - @yield('title')</title>
    @section('meta')

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    @show

<!-- STYLES -->
    @include('layout.style-login')
<!-- STYLES -->

</head>
<body class="login-page">

    <!-- CONTENT-->
        @yield('content')
    <!-- CONTENT-->

<!-- SCRIPTS -->
    @include('layout.script-login')
<!-- SCRIPTS -->

</body>
</html>




