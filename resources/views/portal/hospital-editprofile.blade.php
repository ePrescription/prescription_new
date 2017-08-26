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



        <!-- Main content -->
        <div class="content">

            <div class="hidden">
                <div class="page-header-title">
                    <h4 class="page-title">Hospital Edit Details</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h4 class="m-t-0 m-b-30">Hospital Edit Details</h4>
                            <!-- form start -->
                            <form action="{{URL::to('/')}}/fronthospital/rest/api/hospital" role="form" method="POST">

                            <div class="col-md-12">
                                <style>.control-label{line-height:32px;}</style>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Hospital Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="hospital_name" value="{{$hospitalProfile[0]->hospital_name}}" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Address </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" value="{{$hospitalProfile[0]->address}}" required="required" />
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-9">
                                        <select name="city" class="form-control">
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}"  @if($city->id==$hospitalProfile[0]->city_id) selected @endif >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-9">
                                        <select name="country" class="form-control">
                                            <option value="99">{{$hospitalProfile[0]->country_name}}</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="telephone" value="{{$hospitalProfile[0]->telephone}}" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success" style="float:right;">Save Profile</button>
                                </div>

                            </form>
                            </div><!-- /.panel-body -->
                        </div><!-- /.panel -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.content -->
        </div>
        @include('portal.hospital-footer')
    </div>
</div><!-- ./wrapper -->

@endsection
