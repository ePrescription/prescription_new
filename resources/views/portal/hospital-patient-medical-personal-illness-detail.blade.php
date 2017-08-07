
<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">

<!-- form start -->

<form role="form" method="POST" class="form-horizontal ">
<div class="form-group">

<label class="col-sm-4 control-label">Marital Status</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="personalHistory[0][personalHistoryId]" value="1" required="required" />
<input type="hidden" class="form-control" name="personalHistory[0][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="personalHistory[0][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][0]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory11" value="1" name="personalHistory[0][personalHistoryItemId]" required="required">
<label for="personalHistory11"> Single </label>
</div>
<div class="hidden radio radio-inline">
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
<input type="hidden" class="form-control" name="personalHistory[1][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][1]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory21" value="3" name="personalHistory[1][personalHistoryItemId]" required="required">
<label for="personalHistory21"> Normal </label>
</div>
<div class="hidden radio radio-inline">
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
<input type="hidden" class="form-control" name="personalHistory[2][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][2]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory31" value="5" name="personalHistory[2][personalHistoryItemId]" required="required">
<label for="personalHistory31"> Veg </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="personalHistory32" value="6" name="personalHistory[2][personalHistoryItemId]" required="required">
<label for="personalHistory32">  Non Veg </label>
</div>
<div class="hidden radio radio-inline">
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
<input type="hidden" class="form-control" name="personalHistory[3][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][3]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory41" value="8" name="personalHistory[3][personalHistoryItemId]" required="required">
<label for="personalHistory41"> Regular </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="personalHistory42" value="9" name="personalHistory[3][personalHistoryItemId]" required="required">
<label for="personalHistory42"> Irregular </label>
</div>
<div class="hidden radio radio-inline">
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
<input type="hidden" class="form-control" name="personalHistory[4][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][4]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory51" value="11" name="personalHistory[4][personalHistoryItemId]" required="required">
<label for="personalHistory51"> Normal </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="personalHistory52" value="12" name="personalHistory[4][personalHistoryItemId]" required="required">
<label for="personalHistory52"> Abnormal </label>
</div>
</div>

</div>
<div class="form-group">

<label class="col-sm-4 control-label">Known Allergies</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="personalHistory[5][personalHistoryId]" value="6" required="required" />
<input type="hidden" class="form-control" name="personalHistory[5][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="personalHistory[5][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][5]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory61" value="11" name="personalHistory[5][personalHistoryItemId]" required="required">
<label for="personalHistory61"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="personalHistory62" value="12" name="personalHistory[5][personalHistoryItemId]" required="required">
<label for="personalHistory62"> No </label>
</div>
</div>
</div>
<div class="form-group">

<label class="col-sm-4 control-label">Habits / Addictions</label>
<div class="col-sm-6">
<input type="hidden" class="form-control" name="personalHistory[6][personalHistoryId]" value="7" required="required" />
<input type="hidden" class="form-control" name="personalHistory[6][personalHistoryDate]" value="{{date('Y-m-d')}}" required="required" />
<input type="hidden" class="form-control" name="personalHistory[6][isValueSet]" value="1" required="required" />
    {{$personalHistoryDetails['patientHistory'][6]->personalHistoryItemName}}
<div class="hidden radio radio-info radio-inline">
<input type="radio" id="personalHistory71" value="13" name="personalHistory[6][personalHistoryItemId]" required="required">
<label for="personalHistory71"> Yes </label>
</div>
<div class="hidden radio radio-inline">
<input type="radio" id="personalHistory72" value="14" name="personalHistory[6][personalHistoryItemId]" required="required">
<label for="personalHistory72"> No </label>
</div>
</div>
</div>


</form>




</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
