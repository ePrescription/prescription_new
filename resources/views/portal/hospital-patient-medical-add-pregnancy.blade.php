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
                        <h4 class="page-title">Add Patient Pregnancy</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Pregnancy</h4>


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


                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/pregnancydetails" role="form" method="POST" class="form-horizontal ">
                                                <?php $i=0; ?>
                                                @foreach($patientPregnancyDetails as $patientPregnancyValue)
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">{{$patientPregnancyValue->pregnancy_details}} @if($patientPregnancyValue->id==1)(in Cm) @endif </label>
                                                        <div class="col-sm-6">
                                                            <input type="hidden" class="form-control" name="pregnancyDetails[{{$i}}][pregnancyId]" value="{{$patientPregnancyValue->id}}" required="required" />
                                                            <input type="text" class="form-control" name="pregnancyDetails[{{$i}}][pregnancyValue]" value="" required="required" />
                                                            <input type="hidden" class="form-control" name="pregnancyDetails[{{$i}}][pregnancyDate]" value="{{date('Y-m-d')}}" required="required" />
                                                            <input type="hidden" class="form-control" name="pregnancyDetails[{{$i}}][examinationTime]" value="{{date('h-i-s')}}" required="required" />
                                                            <input type="hidden" class="form-control" name="pregnancyDetails[{{$i}}][isValueSet]" value="1" required="required" />
                                                        </div>
                                                    </div>
                                                <?php $i++; ?>
                                                @endforeach

                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />
                                                        <input type="submit" name="addpregnancy" value="Save" class="btn btn-success"/>
                                                    </div>
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


@endsection