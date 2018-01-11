<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<h4 class="m-t-0 m-b-30">Add Motion Tests</h4>


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

@if(count($patientMotionTests)>0)

<form action="{{URL::to('/')}}/fronthospital/rest/api/motiontests" role="form" method="POST" class="form-horizontal ">
<div class="form-group">
<label class="col-sm-4 control-label">Test Date</label>
<div class="col-sm-4">
<input type="text" class="form-control" name="examinationDate" id="TestDate" value="{{date('Y-m-d')}}" required="required" onchange="javascript:UpdateTestDates(this.value);" />
@if ($errors->has('examinationDate'))<p class="error" style="">{!!$errors->first('examinationDate')!!}</p>@endif
</div>
<div class="col-sm-4">
    <input type="text" class="form-control" name="examinationTime" id="TestTIme" value="{{date('h:i:s')}}" required="required" onchange="javascript:UpdateTestTimes(this.value);" />
    @if ($errors->has('examinationTime'))<p class="error" style="">{!!$errors->first('examinationTime')!!}</p>@endif
</div>
</div>
<?php $i=0; ?>
@foreach($patientMotionTests as $patientMotionTestsValue)
<div class="col-sm-6 form-group">
<label class="col-sm-8 control-label">{{$patientMotionTestsValue->examination_name}}</label>
<div class="col-sm-4">
<input type="hidden" class="form-control" name="motionExaminations[{{$i}}][examinationId]" value="{{$patientMotionTestsValue->id}}" required="required" />
<input type="hidden" class="form-control" name="motionExaminations[{{$i}}][examinationDate]" id="TestDates" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="motionExaminations[{{$i}}][examinationTime]" id="TestTimes" value="{{date('h:i:s')}}" required="required" />
<div class="radio radio-info radio-inline">
<input type="radio" id="motionExaminations{{$patientMotionTestsValue->id}}1" value="1" name="motionExaminations[{{$i}}][isValueSet]">
<label for="motionExaminations{{$patientMotionTestsValue->id}}1"> Yes </label>
</div>
<div class="radio radio-inline">
<input type="radio" id="motionExaminations{{$patientMotionTestsValue->id}}2" value="0" name="motionExaminations[{{$i}}][isValueSet]" checked="checked">
<label for="motionExaminations{{$patientMotionTestsValue->id}}2"> No </label>
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
<input type="submit" name="addmotion" value="Save" class="btn btn-success"/>
    <input type="button" value="Cancel" class="btn btn-info waves-effect waves-light" onclick="window.location.href='{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients';"/>

</div>
</div>
</form>
@endif

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
