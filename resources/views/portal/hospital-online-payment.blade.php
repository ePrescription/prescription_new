@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="0";
$doctor_menu="1";
$profile_menu="0";
?>
@section('content')
<div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->
    <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')
    <!-- /.sidebar -->


    <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Online Payment</h4>
                </div>
            </div>
            <div style="float:right;padding: 10px 15px;"><button class="btn btn-info waves-effect waves-light" onclick="window.history.back()">Back</button></div>
            <div class="page-content-wrapper ">

                <div class="container">

                    @if (session()->has('message'))
                        <div class="col_full login-title">
                                <span style="color:red;">
                                    <b>{{session('message')}}</b>
                                </span>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="col_full login-title">
                                <span style="color:green;">
                                    <b>{{session('success')}}</b>
                                </span>
                        </div>
                    @endif


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-b-30 m-t-0">Online Payment</h4>

                                    <form action="{{URL::to('/')}}/fronthospital/payment/process" role="form" method="POST">

                                        <h4 class="m-t-0 m-b-30">Patient Details</h4>
                                        <div class="col-xs-12">
                                            <div class="box">
                                                <div class="box-body">

                                                    <div class="col-md-4">
                                                        Patient Name
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="firstname" value="" class="form-control"  style="margin-bottom: 8px;" required />
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                        Patient Email
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="email" value="" class="form-control"  style="margin-bottom: 8px;" required />
                                                    </div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                        Patient Mobile
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="text" name="phone" value="" class="form-control"  style="margin-bottom: 8px;" required />
                                                    </div>
                                                    <div class="col-md-1"></div>


                                                </div><!-- /.box-body -->
                                            </div><!-- /.box -->

                                        </div>

                                        <h4 class="m-t-0 m-b-30">Payment Details</h4>
                                        <div class="col-xs-12">

                                            <div class="box">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Payment For
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="productinfo" value="" class="form-control"  style="margin-bottom: 8px;" required />
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Payment Amount
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" name="amount" value="" class="form-control"  style="margin-bottom: 8px;" required/>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>

                                                </div><!-- /.box-body -->
                                                <div class="box-body">

                                                    <div class="col-md-12">
                                                        <div class="form-group col-md-12">
                                                            <input type="hidden" name="tid" value="{{time().time()}}" class="form-control"/>
                                                            <input type="hidden" name="order_id" value="{{time()}}" class="form-control"/>

                                                            <button type="submit" class="btn btn-success waves-effect waves-light m-l-10">PAY ONLINE</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1"></div>


                                                </div><!-- /.box-body -->

                                            </div><!-- /.box -->

                                        </div>

                                    </form>

                                    </div> <!-- panel-body -->
                            </div> <!-- panel -->
                        </div> <!-- col -->
                    </div> <!-- End row -->




                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div> <!-- content -->

        @include('portal.hospital-footer')

    </div>
    <!-- End Right content here -->


</div><!-- ./wrapper -->


@endsection
