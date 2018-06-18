<link rel="shortcut icon" href="{{URL::to('/')}}/theme/assets/images/favicon.ico">
{!!  Html::style(asset('theme/assets/plugins/morris/morris.css')) !!}
{!!  Html::style(asset('theme/assets/css/bootstrap.min.css')) !!}
{!!  Html::style(asset('theme/assets/css/icons.css')) !!}
{!!  Html::style(asset('theme/assets/css/style.css')) !!}
<style>
    a.logo img, a.logo-sm img {
        height: 68px !important;
        padding-top: 1px !important;
    }
</style>

<style>
    .dropbtn {
        background-color: #3498DB;
        color: White;
        padding: 5px;
        width: 100px;
        font-size: 16px;
        /*border: none;*/


    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color:white;
        min-width: 20px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
        border: 1px solid black;
        overflow: hidden;
        white-space: nowrap;
        line-height: 3px;
    }

    .dropdown-content a {
        color: black;
        padding: 8px 8px;
        text-decoration: none;
        display: block;

    }

    .dropdown-content a:hover {background-color: #ddd}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #848484;
    }
</style>
@yield('styles')
