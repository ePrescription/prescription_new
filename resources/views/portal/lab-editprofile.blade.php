@extends('layout.master-lab-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$lab_menu="0";
$patient_menu="0";
$profile_menu="1";
?>
@section('content')
    <div class="wrapper">
        @include('portal.lab-header')
        <!-- Left side column. contains the logo and sidebar -->

        <!-- sidebar: style can be found in sidebar.less -->
        @include('portal.lab-sidebar')
        <!-- /.sidebar -->

        <!-- Content Wrapper. Contains page content -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Lab Details</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-xs-12">

                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <h4 class="m-t-0 m-b-30">Lab Details</h4>

                                        <form action="{{URL::to('/')}}/lab/rest/api/lab" role="form" method="POST">

                            <div class="col-md-12">
                                <style>.control-label{line-height:32px;}</style>

                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Lab Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lab_name" value="{{$labProfile[0]->lab_name}}" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Address </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="address" value="{{$labProfile[0]->address}}" required="required" />
                                    </div>
                                </div>


                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">City</label>
                                    <div class="col-sm-9">
                                        <select name="city" class="form-control">
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}"  @if($city->id==$labProfile[0]->city_id) selected @endif >{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Country</label>
                                    <div class="col-sm-9">
                                        <select name="country" class="form-control">
                                            <option value="99">{{$labProfile[0]->country}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Pin Code</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="pincode" value="{{$labProfile[0]->pincode}}" required="required" />
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-sm-3 control-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="telephone" value="{{$labProfile[0]->telephone}}" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-success" style="float:right;">Save Profile</button>
                                </div>

                            </form>



                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->


                            </div><!-- /.col -->
                        </div><!-- /.row -->

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            @include('portal.doctor-footer')

        </div>
        <!-- End Right content here -->



    </div><!-- ./wrapper -->

@endsection
