@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="0";
$profile_menu="1";
?>
@section('content')
<div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')
    <!-- /.sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Hospital Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h4 class="m-t-0 m-b-30">Hospital Details</h4>

                                <div class="col-md-12">
                                    <style>.control-label{line-height:32px;}</style>
                                    @if(!empty($message))
                                        <p style="color:green;">{{$message}}</p>
                                    @endif
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Hospital ID</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->hid}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Hospital Name</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->hospital_name}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Address </label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->address}}
                                        </div>
                                    </div>


                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">City</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->city_name}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Country</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->country_name}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">Phone Number</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->telephone}}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="col-sm-3 control-label">E-Mail</label>
                                        <div class="col-sm-9">
                                            {{$hospitalProfile[0]->email}}
                                        </div>
                                    </div>




                                </div>



                            </div><!-- /.box-body -->
                        </div><!-- /.box -->


                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        @include('portal.hospital-footer')
   </div>
</div><!-- ./wrapper -->

@endsection
