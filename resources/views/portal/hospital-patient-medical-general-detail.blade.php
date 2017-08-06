<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
<!-- form start -->
<form role="form" method="POST" class="form-horizontal ">
<div class="form-group">
<label class="col-sm-4 control-label">Height (in Cm)</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[0][generalExaminationId]" value="1" required="required" />
<input type="text" class="form-control" name="generalExamination[0][generalExaminationValue]" value="{{$generalExamination[0]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[0][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[0][isValueSet]" value="1" required="required" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Weight (in Kg)</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[1][generalExaminationId]" value="2" required="required" />
<input type="text" class="form-control" name="generalExamination[1][generalExaminationValue]" value="{{$generalExamination[1]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[1][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[1][isValueSet]" value="1" required="required" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">BMI</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[2][generalExaminationId]" value="3" required="required" />
<input type="text" class="form-control" name="generalExamination[2][generalExaminationValue]" value="{{$generalExamination[2]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[2][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[2][isValueSet]" value="1" required="required" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Pallor</label>
<div class="col-sm-6">

<input type="hidden" class="form-control" name="generalExamination[3][generalExaminationId]" value="4" required="required" />
<input type="hidden" class="form-control" name="generalExamination[3][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[3][isValueSet]" value="1" required="required" />
{{$generalExamination[3]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue41" value="Yes" name="generalExamination[3][generalExaminationValue]" @if($generalExamination[3]->generalExaminationValue=="Yes") checked="checked" @endif readonly>
<label for="generalExaminationValue41"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue42" value="No" name="generalExamination[3][generalExaminationValue]" @if($generalExamination[3]->generalExaminationValue=="No") checked="checked" @endif readonly>
<label for="generalExaminationValue42"> No </label>
</div>

</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Cyanosis</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[4][generalExaminationId]" value="5" required="required" />
<input type="hidden" class="form-control" name="generalExamination[4][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[4][isValueSet]" value="1" required="required" />
{{$generalExamination[4]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue51" value="Yes" name="generalExamination[4][generalExaminationValue]" @if($generalExamination[4]->generalExaminationValue=="Yes") checked="checked" @endif>
<label for="generalExaminationValue51"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue52" value="No" name="generalExamination[4][generalExaminationValue]" @if($generalExamination[4]->generalExaminationValue=="Yes") checked="checked" @endif>
<label for="generalExaminationValue52"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Clubbing of Fingers / Toes</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[5][generalExaminationId]" value="6" required="required" />
<input type="hidden" class="form-control" name="generalExamination[5][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[5][isValueSet]" value="1" required="required" />
{{$generalExamination[5]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue61" value="Yes" name="generalExamination[5][generalExaminationValue]">
<label for="generalExaminationValue61"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue62" value="No" name="generalExamination[5][generalExaminationValue]" checked="checked">
<label for="generalExaminationValue62"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Lymphadenopathy</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[6][generalExaminationId]" value="7" required="required" />
<input type="hidden" class="form-control" name="generalExamination[6][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[6][isValueSet]" value="1" required="required" />
{{$generalExamination[6]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue71" value="Yes" name="generalExamination[6][generalExaminationValue]">
<label for="generalExaminationValue71"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue72" value="No" name="generalExamination[6][generalExaminationValue]" checked="checked">
<label for="generalExaminationValue72"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Oedema In Feet</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[7][generalExaminationId]" value="8" required="required" />
<input type="hidden" class="form-control" name="generalExamination[7][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[7][isValueSet]" value="1" required="required" />
{{$generalExamination[7]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue81" value="Yes" name="generalExamination[7][generalExaminationValue]">
<label for="generalExaminationValue81"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue82" value="No" name="generalExamination[7][generalExaminationValue]" checked="checked">
<label for="generalExaminationValue82"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Malnutrition</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[8][generalExaminationId]" value="9" required="required" />
<input type="hidden" class="form-control" name="generalExamination[8][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[8][isValueSet]" value="1" required="required" />
{{$generalExamination[8]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue91" value="Yes" name="generalExamination[8][generalExaminationValue]">
<label for="generalExaminationValue91"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue92" value="No" name="generalExamination[8][generalExaminationValue]" checked="checked">
<label for="generalExaminationValue92"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Dehydration</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[9][generalExaminationId]" value="10" required="required" />
<input type="hidden" class="form-control" name="generalExamination[9][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[9][isValueSet]" value="1" required="required" />
{{$generalExamination[9]->generalExaminationValue}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="generalExaminationValue101" value="Yes" name="generalExamination[9][generalExaminationValue]">
<label for="generalExaminationValue101"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="generalExaminationValue102" value="No" name="generalExamination[9][generalExaminationValue]" checked="checked">
<label for="generalExaminationValue102"> No </label>
</div>
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Temperature (C/F)</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[10][generalExaminationId]" value="11" required="required" />
<input type="text" class="form-control" name="generalExamination[10][generalExaminationValue]" value="{{$generalExamination[10]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[10][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[10][isValueSet]" value="1" required="required" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Pulse rate per minute</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[11][generalExaminationId]" value="12" required="required" />
<input type="text" class="form-control" name="generalExamination[11][generalExaminationValue]" value="{{$generalExamination[11]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[11][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[11][isValueSet]" value="1" required="required" />
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">Respiration (count for a full minute) rate</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="generalExamination[12][generalExaminationId]" value="13" required="required" />
<input type="text" class="form-control" name="generalExamination[12][generalExaminationValue]" value="{{$generalExamination[12]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[12][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[12][isValueSet]" value="1" required="required" />
<!--
<div class="radio radio-info radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
<div class="radio radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
-->
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">BP Lt.Arm mm/Hg</label>
<div class="col-sm-6">

<input type="hidden" class="form-control" name="generalExamination[13][generalExaminationId]" value="14" required="required" />
<input type="text" class="form-control" name="generalExamination[13][generalExaminationValue]" value="{{$generalExamination[13]->generalExaminationValue}}" required="required"  readonly />
<input type="hidden" class="form-control" name="generalExamination[13][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[13][isValueSet]" value="1" required="required" />

<!--
<div class="radio radio-info radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
<div class="radio radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
-->
</div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">BP Rt.Arm mm/Hg</label>
<div class="col-sm-6">

<input type="hidden" class="form-control" name="generalExamination[14][generalExaminationId]" value="15" required="required" />
<input type="text" class="form-control" name="generalExamination[14][generalExaminationValue]" value="{{$generalExamination[14]->generalExaminationValue}}" required="required" readonly />
<input type="hidden" class="form-control" name="generalExamination[14][examinationDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="generalExamination[14][isValueSet]" value="1" required="required" />

<!--
<div class="radio radio-info radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
<div class="radio radio-inline">
<input type="text" class="form-control" name="spouseName" value="" required="required" />
</div>
-->
</div>
</div>



</form>




</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->

