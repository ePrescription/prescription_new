<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h4 class="m-t-0 m-b-30">Add Blood Tests</h4>


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

                    @if(count($patientBloodTests)>0)

                        <form action="{{URL::to('/')}}/lab/rest/api/bloodtests" role="form" onsubmit="return submitForm(this);" method="POST"
                              class="form-horizontal ">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Test Date</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="examinationDate" id="TestDate"
                                           value="{{date('Y-m-d')}}" required="required"
                                           onchange="javascript:UpdateTestDates(this.value);"/>
                                    @if ($errors->has('examinationDate'))<p class="error"
                                                                            style="">{!!$errors->first('examinationDate')!!}</p>@endif
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="examinationTime" id="TestTIme"
                                           value="{{date('h:i:s')}}" required="required"
                                           onchange="javascript:UpdateTestTimes(this.value);"/>
                                    @if ($errors->has('examinationTime'))<p class="error"
                                                                            style="">{!!$errors->first('examinationTime')!!}</p>@endif
                                </div>
                            </div>
                            <?php
                            $input = $patientBloodTests;
                            $len = count($input);
                            $firsthalf = array_slice($input, 0, $len / 2);
                            $secondhalf = array_slice($input, $len / 2,$len);
                            // dd($firsthalf);

                            ?>
                            <div id="main">
                                <div id="d1" align="right">
                                    <?php $i = 0; ?>
                                    @foreach($firsthalf as $patientBloodTestValue)
                                        <label for="exampleInputEmail12">{{$patientBloodTestValue->examination_name}}</label>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$i}}][examinationId]"
                                               value="{{$patientBloodTestValue->id}}" required="required"/>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$i}}][examinationDate]" id="TestDates"
                                               value="{{date('Y-m-d')}}" required="required"/>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$i}}][examinationTime]" id="TestTimes"
                                               value="{{date('h:i:s')}}" required="required"/>
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="bloodExaminations{{$patientBloodTestValue->id}}1"
                                                   value="1" name="bloodExaminations[{{$i}}][isValueSet]">
                                            <label for="bloodExaminations{{$patientBloodTestValue->id}}1"> Yes </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="bloodExaminations{{$patientBloodTestValue->id}}2"
                                                   value="0" name="bloodExaminations[{{$i}}][isValueSet]" checked="checked">
                                            <label for="bloodExaminations{{$patientBloodTestValue->id}}2"> No </label>
                                        </div>
                                        <br/>
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                <div id="d2" align="right">
                                    <?php $j1 = $i; ?>
                                    @foreach($secondhalf as $patientBloodTestValue1)
                                        <label for="exampleInputEmail13">{{$patientBloodTestValue1->examination_name}}</label>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$j1}}][examinationId]"
                                               value="{{$patientBloodTestValue1->id}}" required="required"/>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$j1}}][examinationDate]" id="TestDates"
                                               value="{{date('Y-m-d')}}" required="required"/>
                                        <input type="hidden" class="form-control"
                                               name="bloodExaminations[{{$j1}}][examinationTime]" id="TestTimes"
                                               value="{{date('h:i:s')}}" required="required"/>
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="bloodExaminations{{$patientBloodTestValue1->id}}1"
                                                   value="1" name="bloodExaminations[{{$j1}}][isValueSet]">
                                            <label for="bloodExaminations{{$patientBloodTestValue1->id}}1"> Yes </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="bloodExaminations{{$patientBloodTestValue1->id}}2"
                                                   value="0" name="bloodExaminations[{{$j1}}][isValueSet]" checked="checked">
                                            <label for="bloodExaminations{{$patientBloodTestValue1->id}}2"> No </label>
                                        </div>
                                        <br/>
                                        <?php $j1++; ?>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" name="patientId"
                                           value="{{$patientDetails[0]->patient_id}}" required="required"/>
                                    <input type="hidden" class="form-control" name="hospitalId" value="{{$hid}}"
                                           required="required"/>
                                    <input type="submit" name="addblood" value="Save" class="btn btn-success"/>
                                    <input type="button" value="Cancel" class="btn btn-info waves-effect waves-light"
                                           onclick="window.location.href='{{URL::to('/')}}/lab/rest/api/{{Session::get('LoginUserHospital')}}/patients';"/>

                                </div>
                            </div>
                        </form>
                    @endif

                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->


</div><!-- container -->
<style>
    #main{
        width:800px;
        height:auto;
        /*border:1px solid black;*/
    }

    #d1{
        float: left;
        width: 40%;
        /*border:1px solid red;*/
    }

    #d2{
        float: left;
        width: 40%;
        /*border:1px solid blue;*/
    }
</style>
<script>
    function submitForm() {
        return confirm('Do you really want to Submit the Tests?');
    }

</script>
