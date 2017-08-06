<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">
    {{print_r($pastIllness)}}

    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group">

            <label class="col-sm-4 control-label">Endocrine diseases</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[0][pastIllnessId]" value="1" required="required">
                <input type="hidden" class="form-control" name="pastIllness[0][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness11" value="1" name="pastIllness[0][isValueSet]">
                    <label for="pastIllness11"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness12" value="0" name="pastIllness[0][isValueSet]" checked="checked">
                    <label for="pastIllness12"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[0][pastIllnessName]" value="Endocrine diseases" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Hyperthyroidism</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[1][pastIllnessId]" value="2" required="required">
                <input type="hidden" class="form-control" name="pastIllness[1][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness21" value="1" name="pastIllness[1][isValueSet]">
                    <label for="pastIllness21"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness22" value="0" name="pastIllness[1][isValueSet]" checked="checked">
                    <label for="pastIllness22"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[1][pastIllnessName]" value="Hyperthyroidism" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Diabetes</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[2][pastIllnessId]" value="3" required="required">
                <input type="hidden" class="form-control" name="pastIllness[2][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness31" value="1" name="pastIllness[2][isValueSet]">
                    <label for="pastIllness31"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness32" value="0" name="pastIllness[2][isValueSet]" checked="checked">
                    <label for="pastIllness32"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[2][pastIllnessName]" value="Diabetes" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">HyperTension</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[3][pastIllnessId]" value="4" required="required">
                <input type="hidden" class="form-control" name="pastIllness[3][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness41" value="1" name="pastIllness[3][isValueSet]">
                    <label for="pastIllness41"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness42" value="0" name="pastIllness[3][isValueSet]" checked="checked">
                    <label for="pastIllness42"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[3][pastIllnessName]" value="HyperTension" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">CAD</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[4][pastIllnessId]" value="5" required="required">
                <input type="hidden" class="form-control" name="pastIllness[4][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness51" value="1" name="pastIllness[4][isValueSet]">
                    <label for="pastIllness51"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness52" value="0" name="pastIllness[4][isValueSet]" checked="checked">
                    <label for="pastIllness52"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[4][pastIllnessName]" value="CAD" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Asthma</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[5][pastIllnessId]" value="6" required="required">
                <input type="hidden" class="form-control" name="pastIllness[5][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness61" value="1" name="pastIllness[5][isValueSet]">
                    <label for="pastIllness61"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness62" value="0" name="pastIllness[5][isValueSet]" checked="checked">
                    <label for="pastIllness62"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[5][pastIllnessName]" value="Asthma" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Tuberculosis</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[6][pastIllnessId]" value="7" required="required">
                <input type="hidden" class="form-control" name="pastIllness[6][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness71" value="1" name="pastIllness[6][isValueSet]">
                    <label for="pastIllness71"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness72" value="0" name="pastIllness[6][isValueSet]" checked="checked">
                    <label for="pastIllness72"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[6][pastIllnessName]" value="Tuberculosis" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Stroke</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[7][pastIllnessId]" value="8" required="required">
                <input type="hidden" class="form-control" name="pastIllness[7][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness81" value="1" name="pastIllness[7][isValueSet]">
                    <label for="pastIllness81"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness82" value="0" name="pastIllness[7][isValueSet]" checked="checked">
                    <label for="pastIllness82"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[7][pastIllnessName]" value="Stroke" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Cancers</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[8][pastIllnessId]" value="9" required="required">
                <input type="hidden" class="form-control" name="pastIllness[8][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness91" value="1" name="pastIllness[8][isValueSet]">
                    <label for="pastIllness91"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness92" value="0" name="pastIllness[8][isValueSet]" checked="checked">
                    <label for="pastIllness92"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[8][pastIllnessName]" value="Cancers" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Blood Transfusion</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[9][pastIllnessId]" value="10" required="required">
                <input type="hidden" class="form-control" name="pastIllness[9][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness101" value="1" name="pastIllness[9][isValueSet]">
                    <label for="pastIllness101"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness102" value="0" name="pastIllness[9][isValueSet]" checked="checked">
                    <label for="pastIllness102"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[9][pastIllnessName]" value="Blood Transfusion" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Surgeries</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[10][pastIllnessId]" value="11" required="required">
                <input type="hidden" class="form-control" name="pastIllness[10][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness111" value="1" name="pastIllness[10][isValueSet]">
                    <label for="pastIllness111"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness112" value="0" name="pastIllness[10][isValueSet]" checked="checked">
                    <label for="pastIllness112"> No </label>
                </div>
                <input type="hidden" class="form-control" name="pastIllness[10][pastIllnessName]" value="Surgeries" required="required">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-4 control-label">Others</label>
            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="pastIllness[11][pastIllnessId]" value="12" required="required">
                <input type="hidden" class="form-control" name="pastIllness[11][pastIllnessDate]" value="2017-08-06" required="required">
                <div class="radio radio-info radio-inline">
                    <input type="radio" id="pastIllness121" value="1" name="pastIllness[11][isValueSet]">
                    <label for="pastIllness121"> Yes </label>
                </div>
                <div class="radio radio-inline">
                    <input type="radio" id="pastIllness122" value="0" name="pastIllness[11][isValueSet]" checked="checked">
                    <label for="pastIllness122"> No </label>
                </div>
                <input type="text" class="form-control" name="pastIllness[11][pastIllnessName]" value="" required="required">
            </div>
        </div>

    </form>
<?php /* ?>
<form action="{{URL::to('/')}}/fronthospital/rest/api/pastillness" role="form" method="POST" class="form-horizontal ">
<?php $i=0; ?>
@foreach($patientPastIllness as $patientPastIllnessValue)
<div class="form-group">

<label class="col-sm-4 control-label">{{$patientPastIllnessValue->illness_name}}</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessId]" value="{{$patientPastIllnessValue->id}}" required="required" />
<input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessDate]" value="{{date('Y-m-d')}}" required="required" />
<div class="radio radio-info radio-inline">
<input type="radio" id="pastIllness{{$patientPastIllnessValue->id}}1" value="1" name="pastIllness[{{$i}}][isValueSet]">
<label for="pastIllness{{$patientPastIllnessValue->id}}1"> Yes </label>
</div>
<div class="radio radio-inline">
<input type="radio" id="pastIllness{{$patientPastIllnessValue->id}}2" value="0" name="pastIllness[{{$i}}][isValueSet]" checked="checked">
<label for="pastIllness{{$patientPastIllnessValue->id}}2"> No </label>
</div>
@if($patientPastIllnessValue->illness_name=="Others")
<input type="text" class="form-control" name="pastIllness[{{$i}}][pastIllnessName]" value="" required="required" />
@else
<input type="hidden" class="form-control" name="pastIllness[{{$i}}][pastIllnessName]" value="{{$patientPastIllnessValue->illness_name}}" required="required" />
@endif
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
