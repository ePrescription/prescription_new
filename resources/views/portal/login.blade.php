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
                    <a href="{{URL::to('/')}}/" class="logo logo-admin"><img src="{{URL::to('/')}}/images/head-logo-new.png" height="56" alt="logo"></a>
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


@endsection

@section('scripts')
@stop
