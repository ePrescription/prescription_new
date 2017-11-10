@extends('layout.master-doctor-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="0";
$patient_menu="1";
$prescription_menu="0";
$lab_menu="0";
$profile_menu="0";
?>
@section('content')
    <div class="wrapper">
        @include('portal.doctor-header')
        <!-- Left side column. contains the logo and sidebar -->
        <!-- sidebar: style can be found in sidebar.less -->
        @include('portal.doctor-sidebar')
        <!-- /.sidebar -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <div class="">
                    <div class="page-header-title">
                        <h4 class="page-title">Add Patient Past Illness</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="button" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Past Illness</h4>


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


                                            <form action="{{URL::to('/')}}/doctor/pastillness" role="form" method="POST" class="form-horizontal ">
                                                <br/>
                                                <?php $i=0; ?>
                                                    @foreach($patientPastIllness as $patientPastIllnessValue)
                                                    <div class="form-group">

                                                        <label class="col-sm-4 control-label">{{$patientPastIllnessValue->illness_name}}</label>
                                                        <div class="col-sm-6">
                                                            <input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessId]" value="{{$patientPastIllnessValue->id}}" required="required" />
                                                            <input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessDate]" value="{{date('Y-m-d')}}" required="required" />
                                                            <input type="hidden" class="form-control" name="pastIllness[{{$i}}][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="pastIllness{{$patientPastIllnessValue->id}}1" value="1" name="pastIllness[{{$i}}][isValueSet]" @if($patientPastIllnessValue->illness_name=="Others") onclick="javascript:enableBox('past{{$i}}')" class="past{{$i}}" @endif @if($patientPastIllnessValue->illness_name=="Surgeries") onclick="javascript:enableBox('past{{$i}}')" class="past{{$i}}" @endif />
                                                                <label for="pastIllness{{$patientPastIllnessValue->id}}1"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-inline">
                                                                <input type="radio" id="pastIllness{{$patientPastIllnessValue->id}}2" value="0" name="pastIllness[{{$i}}][isValueSet]" checked="checked" @if($patientPastIllnessValue->illness_name=="Others") onclick="javascript:disableBox('past{{$i}}')" class="past{{$i}}" @endif @if($patientPastIllnessValue->illness_name=="Surgeries") onclick="javascript:disableBox('past{{$i}}')" class="past{{$i}}" @endif />
                                                                <label for="pastIllness{{$patientPastIllnessValue->id}}2"> No </label>
                                                            </div>
                                                            @if($patientPastIllnessValue->illness_name=="Others")
                                                                <input type="text" class="form-control" name="pastIllness[{{$i}}][pastIllnessName]" value="None" required="required" id="past{{$i}}" style="display: none;" />
                                                            @elseif($patientPastIllnessValue->illness_name=="Surgeries")
                                                                <input type="text" class="form-control" name="pastIllness[{{$i}}][pastIllnessName]" value="None" required="required" id="past{{$i}}" style="display: none;" />
                                                            @else
                                                                <input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessName]" value="{{$patientPastIllnessValue->illness_name}}" required="required" />
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <?php $i++; ?>
                                                @endforeach

                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="doctorId" value="{{$doctorId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="hospitalId" value="{{$hospitalId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />

                                                        <input type="submit" name="addpast" value="Save" class="btn btn-success"/>

                                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="margin:0px 16px;"><button type="button" class="btn btn-success">Cancel</button></a>
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

            @include('portal.doctor-footer')

        </div>
        <!-- End Right content here -->


@endsection
@section('scripts')
            <script>
                function enableBox(cssvalue) {
                        $('input#'+cssvalue).show();
                        $('input#'+cssvalue).val('');
                }

                function disableBox(cssvalue) {
                        $('input#'+cssvalue).hide();
                        $('input#'+cssvalue).val('None');
                }
            </script>

@endsection
