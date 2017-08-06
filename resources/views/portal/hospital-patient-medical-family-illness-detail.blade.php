<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
    {{print_r($familyIllness)}}

    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">
            <label class="col-sm-4 control-label">Endocrime diseases</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[0][familyIllnessId]" value="1" required="required">
                <input type="hidden" class="form-control" name="familyIllness[0][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails11" value="1" name="familyIllness[0][isValueSet]">
                    <label for="scanDetails11"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails12" value="0" name="familyIllness[0][isValueSet]" checked="checked">
                    <label for="scanDetails12"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[0][familyIllnessName]" value="Endocrime diseases" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[0][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Hyperthyroidism</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[1][familyIllnessId]" value="2" required="required">
                <input type="hidden" class="form-control" name="familyIllness[1][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails21" value="1" name="familyIllness[1][isValueSet]">
                    <label for="scanDetails21"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails22" value="0" name="familyIllness[1][isValueSet]" checked="checked">
                    <label for="scanDetails22"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[1][familyIllnessName]" value="Hyperthyroidism" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[1][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Diabetes</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[2][familyIllnessId]" value="3" required="required">
                <input type="hidden" class="form-control" name="familyIllness[2][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails31" value="1" name="familyIllness[2][isValueSet]">
                    <label for="scanDetails31"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails32" value="0" name="familyIllness[2][isValueSet]" checked="checked">
                    <label for="scanDetails32"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[2][familyIllnessName]" value="Diabetes" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[2][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">HyperTension</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[3][familyIllnessId]" value="4" required="required">
                <input type="hidden" class="form-control" name="familyIllness[3][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails41" value="1" name="familyIllness[3][isValueSet]">
                    <label for="scanDetails41"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails42" value="0" name="familyIllness[3][isValueSet]" checked="checked">
                    <label for="scanDetails42"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[3][familyIllnessName]" value="HyperTension" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[3][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Heart disease</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[4][familyIllnessId]" value="5" required="required">
                <input type="hidden" class="form-control" name="familyIllness[4][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails51" value="1" name="familyIllness[4][isValueSet]">
                    <label for="scanDetails51"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails52" value="0" name="familyIllness[4][isValueSet]" checked="checked">
                    <label for="scanDetails52"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[4][familyIllnessName]" value="Heart disease" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[4][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Asthma</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[5][familyIllnessId]" value="6" required="required">
                <input type="hidden" class="form-control" name="familyIllness[5][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails61" value="1" name="familyIllness[5][isValueSet]">
                    <label for="scanDetails61"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails62" value="0" name="familyIllness[5][isValueSet]" checked="checked">
                    <label for="scanDetails62"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[5][familyIllnessName]" value="Asthma" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[5][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Tuberculosis</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[6][familyIllnessId]" value="7" required="required">
                <input type="hidden" class="form-control" name="familyIllness[6][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails71" value="1" name="familyIllness[6][isValueSet]">
                    <label for="scanDetails71"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails72" value="0" name="familyIllness[6][isValueSet]" checked="checked">
                    <label for="scanDetails72"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[6][familyIllnessName]" value="Tuberculosis" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[6][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Stroke</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[7][familyIllnessId]" value="8" required="required">
                <input type="hidden" class="form-control" name="familyIllness[7][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails81" value="1" name="familyIllness[7][isValueSet]">
                    <label for="scanDetails81"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails82" value="0" name="familyIllness[7][isValueSet]" checked="checked">
                    <label for="scanDetails82"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[7][familyIllnessName]" value="Stroke" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[7][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Cancers</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[8][familyIllnessId]" value="9" required="required">
                <input type="hidden" class="form-control" name="familyIllness[8][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails91" value="1" name="familyIllness[8][isValueSet]">
                    <label for="scanDetails91"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails92" value="0" name="familyIllness[8][isValueSet]" checked="checked">
                    <label for="scanDetails92"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[8][familyIllnessName]" value="Cancers" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[8][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Any other herideitory diseases</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[9][familyIllnessId]" value="10" required="required">
                <input type="hidden" class="form-control" name="familyIllness[9][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails101" value="1" name="familyIllness[9][isValueSet]">
                    <label for="scanDetails101"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails102" value="0" name="familyIllness[9][isValueSet]" checked="checked">
                    <label for="scanDetails102"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[9][familyIllnessName]" value="Any other herideitory diseases" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[9][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Psychaitric illness</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[10][familyIllnessId]" value="11" required="required">
                <input type="hidden" class="form-control" name="familyIllness[10][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails111" value="1" name="familyIllness[10][isValueSet]">
                    <label for="scanDetails111"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails112" value="0" name="familyIllness[10][isValueSet]" checked="checked">
                    <label for="scanDetails112"> No </label>
                </div>
                <input type="hidden" class="form-control" name="familyIllness[10][familyIllnessName]" value="Psychaitric illness" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[10][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Others</label>
            <div class="col-sm-3">
                <input type="hidden" class="form-control" name="familyIllness[11][familyIllnessId]" value="12" required="required">
                <input type="hidden" class="form-control" name="familyIllness[11][familyIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="scanDetails121" value="1" name="familyIllness[11][isValueSet]">
                    <label for="scanDetails121"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="scanDetails122" value="0" name="familyIllness[11][isValueSet]" checked="checked">
                    <label for="scanDetails122"> No </label>
                </div>
                <input type="text" class="form-control" name="familyIllness[11][familyIllnessName]" value="" required="required">
            </div>
            <div class="col-sm-3">
                <select class="form-control" name="familyIllness[11][relation]">
                    <option>None</option>
                </select>
            </div>
        </div>
    </form>
<?php /* ?>
<form role="form" method="POST" class="form-horizontal ">
<?php $i=0; ?>
@foreach($patientFamilyIllness as $patientFamilyIllnessValue)
<div class="form-group">
<label class="col-sm-4 control-label">{{$patientFamilyIllnessValue->illness_name}}</label>
<div class="col-sm-3">
<input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessId]" value="{{$patientFamilyIllnessValue->id}}" required="required" />
<input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessDate]" value="{{date('Y-m-d')}}" required="required" />
<div class="radio radio-info radio-inline">
<input type="radio" id="scanDetails{{$patientFamilyIllnessValue->id}}1" value="1" name="familyIllness[{{$i}}][isValueSet]">
<label for="scanDetails{{$patientFamilyIllnessValue->id}}1"> Yes </label>
</div>
<div class="radio radio-inline">
<input type="radio" id="scanDetails{{$patientFamilyIllnessValue->id}}2" value="0" name="familyIllness[{{$i}}][isValueSet]" checked="checked">
<label for="scanDetails{{$patientFamilyIllnessValue->id}}2"> No </label>
</div>
@if($patientFamilyIllnessValue->illness_name=="Others")
<input type="text" class="form-control" name="familyIllness[{{$i}}][familyIllnessName]" value="" required="required" />
@else
<input type="hidden" class="form-control" name="familyIllness[{{$i}}][familyIllnessName]" value="{{$patientFamilyIllnessValue->illness_name}}" required="required" />
@endif
</div>
<div class="col-sm-3">
<select  class="form-control" name="familyIllness[{{$i}}][relation]">
<option>None</option>
</select>
</div>
</div>
<?php $i++; ?>
@endforeach

</form>
<?php */ ?>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->

