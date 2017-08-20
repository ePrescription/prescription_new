<html>
<head>
    <title>Pharmacy - @yield('title')</title>
    @section('meta')
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta content="@yield('meta_description')" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        @show

        <!-- STYLES -->
        @include('layout.style-pharmacy-inner')
        <!-- STYLES -->

</head>
<body class="fixed-left">

<!-- CONTENT-->
@yield('content')
<!-- CONTENT-->

<!-- SCRIPTS -->
@include('layout.script-pharmacy-inner')
<!-- SCRIPTS -->

</body>
</html>