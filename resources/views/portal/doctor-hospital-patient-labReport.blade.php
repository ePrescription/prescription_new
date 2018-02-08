

<div id="PatientInfoPrint" class="" style="height:100px; border: 1px solid #000000; padding: 5px; line-height: 15px;">
    <div class="row" style="text-transform: uppercase" >

        <div class="col-lg-6" style="width:50%;float:left; ">

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Name</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->name}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left;font-size: 12px; font-weight: bold; ">Address</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->address==""? "----":$patientExaminations['patientDetails']->address }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Ref.DR</label>
                <div class="col-sm-9" style="width:70%;float:left;font-size: 11px;font-weight: bold; ">
                    {{count($patientExaminations['doctorDetails'])>0?$examinationDates['doctorDetails']->name:"---"}}
                </div>
            </div>


            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Address</label>
                <div class="col-sm-9" style="width:70%;float:left;font-size: 11px;font-weight: bold; ">
                    {{$patientExaminations['hospitalDetails']->hospital_name}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Sex</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{ $patientExaminations['patientDetails']->gender==0 ? "Male" :"Female"}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Age</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->age}}
                </div>
            </div>



        </div>

        <div class="col-lg-6" style="width:50%; float: left;">


            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">PID</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->pid}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">E-Mail</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->email}}
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Sample No</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    <b>-t-</b>

                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Specimen</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    <b>-t-</b>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Patient</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['patientDetails']->patient_id}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Test Date</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: bold;">
                    {{$patientExaminations['recentBloodTests'][0]->examination_date}}
                </div>
            </div>
        </div>

    </div>

</div>
<br><br>
separate
<div id="ExaminationInfoPrint1"  class="form-group">
@if(count($patientExaminations['recentBloodTests'])>0)

    <!--<div class="form-group" style="background-color: #ffff99; color: black;">
                <label class="col-sm-12 control-label">Blood Test
                   </label>
            </div>-->
        <div class="form-group" style="font-family:traditional">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;">
                    <tr><th style="padding-right: 80px;">Test Name</th><th style="padding-right: 80px;" >Test Report</th><th style="padding-right: 50px;"  >Normal Value</th></tr>
                    <tr><th colspan="3"><hr/></th></tr>
                    <?php $parentCheck = "";?>
                    @foreach($patientExaminations['recentBloodTests'] as $recentTest)
                        @if($recentTest->is_parent==0 && ($parentCheck=="" || $parentCheck!=$recentTest->parent_examination_name))
                            <?php $parentCheck = $recentTest->parent_examination_name; ?>
                            <tr style="font-size: 15px; font-weight: bold; align-content: center">
                                <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                            </tr>

                        @endif
                        <tr style="font-size: 13px;font-weight: bold; align-content: center">
                            <td >
                                @if($recentTest->is_parent==0)
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                                {{$recentTest->examination_name}}
                            </td>

                            <td style="padding-left: 50px;"> {{$recentTest->test_readings}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$recentTest->units}}</td>
                            <td style="padding-left: 30px;">{{$recentTest->default_normal_values}}</td>

                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
    @endif
    @if(count($patientExaminations['recentMotionExaminations'])>0)

        <div class="form-group" style="background-color: #ffff99; color: black;">
            <label class="col-sm-12 control-label">Motion Test
                - {{$patientExaminations['recentMotionExaminations'][0]->examination_date}}</label>
        </div>
        <div class="form-group ">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;float:left;">
                    @foreach($patientExaminations['recentMotionExaminations'] as $recentTest)
                        <tr style="font-size: 13px;font-weight: bold; align-content: center">
                            <td>{{$recentTest->examination_name}}</td>
                            <td>{{$recentTest->test_readings}}</td>
                            <td>&nbsp;</td>
                        </tr>


                    @endforeach
                </table>
            </div>
            -

        </div>
    @endif
    @if(count($patientExaminations['recentUrineExaminations'])>0)

        <div class="form-group" style="background-color: #ffff99; color: black;">
            <label class="col-sm-12 control-label">Urine Test
                - {{$patientExaminations['recentUrineExaminations'][0]->examination_date}}</label>
        </div>
        <div class="form-group ">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;float:left;">

                    <?php $parentCheck = "";?>
                    @foreach($patientExaminations['recentUrineExaminations'] as $recentTest)
                        @if($recentTest->is_parent==0 && ($parentCheck=="" || $parentCheck!=$recentTest->parent_examination_name))
                            <?php $parentCheck = $recentTest->parent_examination_name; ?>
                            <tr style=" font-size: 15px;font-weight: bold; align-content: center">
                                <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                            </tr>

                        @endif
                        <tr style="font-size: 13px;font-weight: bold; align-content: center">

                            <td style="width:33%;float:left;">
                                @if($recentTest->is_parent==0)
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                                {{$recentTest->examination_name}}
                            </td>

                            <td style="width:33%;float:left;"> {{$recentTest->test_readings}}</td>
                            <td style="width:33%;float:left;">{{$recentTest->normal_default_values}}</td>

                        </tr>




                    @endforeach
                </table>
            </div>
            -


        </div>

    @endif


</div>

