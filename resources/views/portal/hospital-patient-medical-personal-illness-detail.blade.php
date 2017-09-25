<style>
    div.control-label {
        text-align: left !important;
    }
</style>
<div class="container">

<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-body">

<!-- form start -->

<form role="form" method="POST" class="form-horizontal ">
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Marital Status</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][0]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Appetite</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][1]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Diet</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][2]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Bowels</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][3]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Nutrition</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][4]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Known Allergies</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][5]->personalHistoryItemName}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Habits / Addictions</label>
<div class="col-sm-6 control-label">
    {{$personalHistoryDetails['patientHistory'][6]->personalHistoryItemName}}
</div>
</div>
</form>




</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
