@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
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

            <div class="">
                <div class="page-header-title">
                    <h4 class="page-title">New Patient Appointment</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0 m-b-30">New Patient Appointment</h4>


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

                                            <!-- form start -->
                                        <form action="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/savepatient" role="form" method="POST">
                                            <input type="hidden" name="hospitalId" value="{{Auth::user()->id}}" required="required" />
                                            <input type="hidden" name="patientId" value="0" required="required" />
                                            <input type="hidden" name="doctorId" value="0" required="required" />
                                            <div class="col-md-12">
                                                <style>.control-label{line-height:32px;}</style>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Email</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="email" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Mobile</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="telephone" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Age</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="age" value="" required="required" />
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Gender</label>
                                                    <div class="col-sm-9">
                                                        <input type="radio" class="form-controlx" name="gender" value="1" required="required" />Male
                                                        &nbsp;&nbsp;
                                                        <input type="radio" class="form-controlx" name="gender" value="2" required="required" />Female
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Relationship</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="relationship" required="required">
                                                            <option selected></option>
                                                            <option>Brother</option>
                                                            <option>Sister</option>
                                                            <option>Husband</option>
                                                            <option>Wife</option>
                                                            <option>Father</option>
                                                            <option>Mother</option>
                                                            <option>Others</option>
                                                        </select>
                                                        <!--
                                                        <input type="text" class="form-control" name="relationship" value="" required="required" />
                                                        -->
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Relation Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>


                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Visiting</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Type</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Doctor Specialization</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Appointment Time</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Referred By</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Hospital Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Location</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Amount</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Payment Type</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="col-sm-3 control-label">Notes</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="spouseName" value="" required="required" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-1"></div>
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-success" style="float:right;">Save & Book Appointment</button>
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
