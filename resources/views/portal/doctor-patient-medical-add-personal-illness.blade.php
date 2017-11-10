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
                        <h4 class="page-title">Add Patient Personal Illness</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/doctor/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Personal Illness</h4>


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


                                            <form action="{{URL::to('/')}}/doctor/personalhistory" role="form" method="POST" class="form-horizontal ">
                                                <br>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Marital Status</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="personalHistory[0][personalHistoryId]" value="1" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[0][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[0][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[0][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory11" value="1" name="personalHistory[0][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory11"> Single </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory12" value="2" name="personalHistory[0][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory12"> Married </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Appetite</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="personalHistory[1][personalHistoryId]" value="2" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[1][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[1][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[1][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory21" value="3" name="personalHistory[1][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory21"> Normal </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory22" value="4" name="personalHistory[1][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory22"> Lost </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Diet</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="personalHistory[2][personalHistoryId]" value="3" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[2][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[2][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[2][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory31" value="5" name="personalHistory[2][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory31"> Veg </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory32" value="6" name="personalHistory[2][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory32">  Non Veg </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory33" value="7" name="personalHistory[2][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory33"> Eggeterian </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Bowels</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="personalHistory[3][personalHistoryId]" value="4" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[3][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[3][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[3][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory41" value="8" name="personalHistory[3][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory41"> Regular </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory42" value="9" name="personalHistory[3][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory42"> Irregular </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory43" value="10" name="personalHistory[3][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory43"> Constipation </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Nutrition</label>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="personalHistory[4][personalHistoryId]" value="5" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[4][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[4][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[4][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory51" value="11" name="personalHistory[4][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory51"> Normal </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory52" value="12" name="personalHistory[4][personalHistoryItemId]" required="required">
                                                            <label for="personalHistory52"> Abnormal </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Known Allergies</label>
                                                    <div class="col-sm-2">
                                                        <input type="hidden" class="form-control" name="personalHistory[5][personalHistoryId]" value="6" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[5][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[5][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[5][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory61" value="13" name="personalHistory[5][personalHistoryItemId]" required="required" onclick="javascript:enableBox('personal5')" />
                                                            <label for="personalHistory61"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory62" value="14" name="personalHistory[5][personalHistoryItemId]" required="required" onclick="javascript:disableBox('personal5')" />
                                                            <label for="personalHistory62"> No </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="personalHistory[5][personalHistoryItemValue]" value="None" required="required" id="personal5" style="display: none;" />

                                                    </div>
                                                </div>
                                                <div class="form-group">

                                                    <label class="col-sm-4 control-label">Habits / Addictions</label>
                                                    <div class="col-sm-2">
                                                        <input type="hidden" class="form-control" name="personalHistory[6][personalHistoryId]" value="7" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[6][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[6][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                        <input type="hidden" class="form-control" name="personalHistory[6][isValueSet]" value="1" required="required" />
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio" id="personalHistory71" value="15" name="personalHistory[6][personalHistoryItemId]" required="required" onclick="javascript:enableBox('personal6')" />
                                                            <label for="personalHistory71"> Yes </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <input type="radio" id="personalHistory72" value="16" name="personalHistory[6][personalHistoryItemId]" required="required"onclick="javascript:disableBox('personal6')" />
                                                            <label for="personalHistory72"> No </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="personalHistory[6][personalHistoryItemValue]" value="None" required="required" id="personal6" style="display: none;" />
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="doctorId" value="{{$doctorId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="hospitalId" value="{{$hospitalId}}" required="required" />
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />

                                                        <input type="submit" name="addpersonal" value="Save" class="btn btn-success">

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

            @include('portal.hospital-footer')

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