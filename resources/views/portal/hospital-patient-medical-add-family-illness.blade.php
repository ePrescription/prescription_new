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
                        <h4 class="page-title">Add Patient Family Illness</h4>
                    </div>
                </div>

                <div class="page-content-wrapper ">

                    <div class="container">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                                        <h4 class="m-t-0 m-b-30">Add Family Illness</h4>



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


                                            <form action="{{URL::to('/')}}/fronthospital/rest/api/familyillness" role="form" method="POST" class="form-horizontal ">
                                                <?php $i=0; ?>
                                                @foreach($patientFamilyIllness as $patientFamilyIllnessValue)
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label">{{$patientFamilyIllnessValue->illness_name}}</label>
                                                        <div class="col-sm-3">
                                                            <input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessId]" value="{{$patientFamilyIllnessValue->id}}" required="required" />
                                                            <input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessDate]" value="{{date('Y-m-d')}}" required="required" />
                                                            <input type="hidden" class="form-control" name="familyIllness[{{$i}}][examinationTime]" value="{{date('h:i:s')}}" required="required" />
                                                            <div class="radio radio-info radio-inline">
                                                                <input type="radio" id="scanDetails{{$patientFamilyIllnessValue->id}}1" value="1" name="familyIllness[{{$i}}][isValueSet]" onclick="javascript:enableBox('family{{$i}}')" class="family{{$i}}" />
                                                                <label for="scanDetails{{$patientFamilyIllnessValue->id}}1"> Yes </label>
                                                            </div>
                                                            <div class="radio radio-inline">
                                                                <input type="radio" id="scanDetails{{$patientFamilyIllnessValue->id}}2" value="0" name="familyIllness[{{$i}}][isValueSet]" checked="checked" onclick="javascript:disableBox('family{{$i}}')" class="family{{$i}}" />
                                                                <label for="scanDetails{{$patientFamilyIllnessValue->id}}2"> No </label>
                                                            </div>
                                                            @if($patientFamilyIllnessValue->illness_name=="Others")
                                                                <input type="text" class="form-control" name="familyIllness[{{$i}}][familyIllnessName]" value="None" required="required" id="family{{$i}}" style="display: none;" />
                                                            @elseif($patientFamilyIllnessValue->illness_name=="Any other herideitory diseases")
                                                                <input type="text" class="form-control" name="familyIllness[{{$i}}][familyIllnessName]" value="None" required="required" id="family{{$i}}" style="display: none;" />
                                                            @else
                                                                <input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessName]" value="{{$patientFamilyIllnessValue->illness_name}}" required="required" />
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <select class="form-control" name="familyIllness[{{$i}}][relation]" id="family{{$i}}">
                                                                <option value="" selected>None</option>
                                                                <option value="Brother">Brother</option>
                                                                <option value="Sister">Sister</option>
                                                                <option value="Husband">Husband ( If Married )</option>
                                                                <option value="Wife">Wife ( If Married )</option>
                                                                <option value="Father">Father</option>
                                                                <option value="Mother">Mother</option>
                                                                <option value="Grand Father">Grand Father</option>
                                                                <option value="Grand Mother">Grand Mother</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php $i++; ?>
                                                @endforeach
                                                <div class="form-group">
                                                    <div class="col-sm-4"></div>
                                                    <div class="col-sm-6">
                                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />

                                                        <input type="submit" name="addfamily" value="Save" class="btn btn-success"/>
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
    $(document).ready(function() {
        $('select').attr('disabled', 'disabled');
    });
    $('form').submit(function() {
        $('select').removeAttr('disabled');
    });
</script>
<script>
    function enableBox(cssvalue) {
        //alert(cssvalue);
        $('select#'+cssvalue).removeAttr('disabled');

        if(cssvalue=='family9')
        {
            $('input#'+cssvalue).show();
            $('input#'+cssvalue).val('');
        }

        if(cssvalue=='family11')
        {
            $('input#'+cssvalue).show();
            $('input#'+cssvalue).val('');
        }
    }

    function disableBox(cssvalue) {
        //alert(cssvalue);
        $('select#'+cssvalue).val('');

        if(cssvalue=='family9')
        {
            $('input#'+cssvalue).hide();
            $('input#'+cssvalue).val('None');
        }

        if(cssvalue=='family11')
        {
            $('input#'+cssvalue).hide();
            $('input#'+cssvalue).val('None');
        }
        $('select#'+cssvalue).attr('disabled', 'disabled');
    }
</script>

@endsection
