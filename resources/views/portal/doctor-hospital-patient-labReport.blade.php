

    <div id="PatientInfoPrint" class="" style="height: 250px;">
        <div class="row">

            <div class="col-lg-6" style="width:50%;float:left;">
                <h4 class="m-t-0 m-b-30">Hospital Details</h4>

                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['hospitalDetails']->hospital_name}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">Address</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['hospitalDetails']->address}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">City</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['hospitalDetails']->city_name}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">Country</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['hospitalDetails']->name}}
                    </div>
                </div>

            </div>

            <div class="col-lg-6" style="width:50%;float:left;">
                <h4 class="m-t-0 m-b-30">Patient Details</h4>

                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">PID</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['patientDetails']->pid}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">Name</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['patientDetails']->name}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">Number</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['patientDetails']->telephone}}
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-sm-3 control-label" style="width:30%;float:left;">E-Mail</label>
                    <div class="col-sm-9" style="width:70%;float:left;">
                        {{$patientExaminations['patientDetails']->email}}
                    </div>
                </div>
                <?php /* ?>
                                                    <div class="form-group col-md-12">
                                                        <label class="col-sm-3 control-label">Age / Gender</label>
                                                        <div class="col-sm-9">
                                                            {{$patientExaminations['patientDetails']->age}} / @if($patientExaminations['patientDetails']->gender==1) Male @else Female @endif
                                                        </div>
                                                    </div>
                                                    <?php */ ?>
            </div>
        </div>
    </div>
    separate
    <div id="ExaminationInfoPrint1" class="form-group">


        @if(count($patientExaminations['recentBloodTests'])>0)
            <hr/>
            <div class="form-group" style="background-color: #ffff99; color: black;">
                <label class="col-sm-12 control-label">Blood Test
                    - {{$patientExaminations['recentBloodTests'][0]->examination_date}}</label>
            </div>
            <div class="form-group ">
                <div class="col-sm-4" style="width:100%;float:left;">
                    <table style="width:100%;float:left;">
                        <tr><th >Test Name</th><th>Test Report</th><th>Normal Value</th></tr>
                        <?php $parentCheck = "";?>
                        @foreach($patientExaminations['recentBloodTests'] as $recentTest)

                            @if($recentTest->is_parent==0 && ($parentCheck=="" || $parentCheck!=$recentTest->parent_examination_name))
                                <?php $parentCheck = $recentTest->parent_examination_name; ?>
                                <tr>
                                    <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                                </tr>

                            @endif
                            <tr>

                                <td >
                                    @if($recentTest->is_parent==0)
                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif
                                    {{$recentTest->examination_name}}
                                </td>

                                <td > {{$recentTest->test_readings}}</td>
                                <td >{{$recentTest->default_normal_values}}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>

                -


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
                            <tr>
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
                                <tr>
                                    <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                                </tr>

                            @endif
                            <tr>

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

