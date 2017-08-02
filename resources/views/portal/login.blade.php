@extends('layout.master-login')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop

@section('content')


    <div class="accountbg"></div>
    <div class="wrapper-page">
        <div class="panel panel-color panel-primary panel-pages">

            <div class="panel-body">
                <h3 class="text-center m-t-0 m-b-15">
                    <a href="{{URL::to('/')}}/" class="logo logo-admin"><img src="{{URL::to('/')}}/images/head-logo-new.png" height="28" alt="logo"></a>
                </h3>
                <h4 class="text-muted text-center m-t-0"><b>Sign In</b></h4>

                @if (session()->has('message'))
                    <div style="padding-bottom: 5px; margin-left: -14px;">
                                <span style="color:red; margin:4px; padding: 4px;">
                                    <b>{{session('message')}}</b>
                                </span>
                    </div>
                @endif

                {!! Form::open( array( 'route' => array('user.dologin') ,'role' => 'form' ,'method'=>'POST', 'files'=>true,'class'=>'form-horizontal m-t-20') ) !!}

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" id="email" name="email" required="" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" id="password" name="password" required="" placeholder="Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup">
                                    Remember me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit" name="submit" value="submit">Log In</button>
                        </div>
                    </div>

                    <div class="form-group m-t-30 m-b-0 hidden">
                        <div class="col-sm-7">
                            <a href="pages-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                        </div>
                        <div class="col-sm-5 text-right">
                            <a href="pages-register.html" class="text-muted">Create an account</a>
                        </div>
                    </div>
                </form>
                {!! Form::close() !!}

                <strong><a href="#" style="font-size: 12px;">Powered by Daiwik Business Solutions Private Limited</a></strong>

            </div>

        </div>
    </div>

    <style>
        html, body {
            min-height: auto !important;
        }
    </style>
<div class="login-box">
    <div class="login-logo">
        <a href="index.html"><img src="images/head-logo-new.png"></a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        @if (session()->has('message'))
            <div style="padding-bottom: 5px; margin-left: -14px;">
                                <span style="color:red; margin:4px; padding: 4px;">
                                    <b>{{session('message')}}</b>
                                </span>
            </div>
        @endif

        {!! Form::open( array( 'route' => array('user.dologin') ,'role' => 'form' ,'method'=>'POST', 'files'=>true,'class'=>'form-horizontal nobottommargin') ) !!}

            <div class="form-group has-feedback">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" />
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div><!-- /.col -->
            </div>
        </form>



        <a href="#" style="display:none;">I forgot my password</a><br>

        <strong><a href="#" style="font-size: 12px;">Powered by Daiwik Business Solutions Private Limited</a></strong>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection

@section('scripts')
@stop
