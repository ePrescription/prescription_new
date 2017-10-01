<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patient/{{$patientDetails[0]->patient_id}}/medical-details" style="float:right;margin: 16px;display:none;"><button type="submit" class="btn btn-success"><i class="fa fa-edit"></i><b> Back to Details </b></button></a>
                    <h4 class="m-t-0 m-b-30">Add Scan</h4>


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


                        <form action="{{URL::to('/')}}/fronthospital/rest/api/scandetails" role="form" method="POST" class="form-horizontal ">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Test Date</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="examinationDate" id="TestDate" value="{{date('Y-m-d')}}" required="required" onchange="javascript:UpdateTestDates(this.value);" />
                                    @if ($errors->has('examinationDate'))<p class="error" style="">{!!$errors->first('examinationDate')!!}</p>@endif
                                </div>
                            </div>
                            <?php $i=0; ?>
                             @foreach($patientScans as $patientScanValue)
                                <div class="col-sm-6 form-group">
                                    <label class="col-sm-8 control-label">{{$patientScanValue->scan_name}}</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" class="form-control" name="scanDetails[{{$i}}][scanId]" value="{{$patientScanValue->id}}" required="required" />
                                        <input type="hidden" class="form-control" name="scanDetails[{{$i}}][scanDate]" value="{{date('Y-m-d')}}" id="TestDates" required="required" />
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="scanDetails{{$patientScanValue->id}}1" value="1" name="scanDetails[{{$i}}][isValueSet]">
                                            <label for="scanDetails{{$patientScanValue->id}}1"> Yes </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="scanDetails{{$patientScanValue->id}}2" value="0" name="scanDetails[{{$i}}][isValueSet]" checked="checked">
                                            <label for="scanDetails{{$patientScanValue->id}}2"> No </label>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            @endforeach
                                <div class="col-sm-12 form-group">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control" name="patientId" value="{{$patientDetails[0]->patient_id}}" required="required" />
                                        <input type="hidden" class="form-control" name="hospitalId" value="{{$hid}}" required="required" />
                                        <input type="submit" name="addscan" value="Save" class="btn btn-success"/>
                                    </div>
                                </div>

                        </form>




                </div> <!-- panel-body -->
            </div> <!-- panel -->
        </div> <!-- col -->
    </div> <!-- End row -->

</div><!-- container -->
