@extends('layout.master-pharmacy-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$prescription_menu="0";
$patient_menu="0";
$profile_menu="1";
?>
@section('content')
    <div class="wrapper">
        @include('portal.pharmacy-header')
        <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
        @include('portal.pharmacy-sidebar')
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Pharmacy Profile Details</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-xs-12">

                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h4 class="m-t-0 m-b-30">Pharmacy Profile Details</h4>

                                        <div class="col-md-12">
                                <style>.control-label{line-height:32px;}</style>
                                @if(!empty($message))
                                    <p style="color:green;">{{$message}}</p>
                                @endif
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Pharmacy ID</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->phid}}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Pharmacy Name</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->pharmacy_name}}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Address </label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->address}}
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->city_name}}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->country_name}}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->telephone}}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">E-Mail</label>
                                    <div class="col-sm-9">
                                        {{$pharmacyProfile[0]->email}}
                                    </div>
                                </div>




                            </div>


                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->


                            </div><!-- /.col -->
                        </div><!-- /.row -->

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            @include('portal.pharmacy-footer')

        </div>
        <!-- End Right content here -->



    </div><!-- ./wrapper -->

@endsection
