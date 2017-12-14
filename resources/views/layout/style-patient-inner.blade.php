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
@yield('styles')
