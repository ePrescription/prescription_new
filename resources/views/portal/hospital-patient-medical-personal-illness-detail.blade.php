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

    @if(count($personalHistoryDetails)>0)
        <h4 class="m-t-0 m-b-30">Personal Illness Details</h4>
        @foreach($personalHistoryDetails as $recentTest)
            <?php $displaySet=0; ?>
        <div class="form-group">
            @foreach($recentTest as $recentTestDate)
                @if($displaySet==0)
                <label class="col-sm-12 control-label">{{$recentTestDate->personal_history_date}} - {{$recentTestDate->examination_time}} </label>
                <?php $displaySet=1; ?>
                @endif
            @endforeach
        </div>
        <div class="form-group col-sm-12">
            @foreach($recentTest as $recentTestValue)
                <div class="col-sm-6" style="width:50%;float:left;">
                    {{$recentTestValue->personal_history_name}} - {{$recentTestValue->personal_history_item_name}} @if($recentTestValue->personal_history_value!="") - {{$recentTestValue->personal_history_value}} @endif
                </div>
            @endforeach
        </div>
        @endforeach
    @endif

<?php /* ?>
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
    @if($personalHistoryDetails['patientHistory'][5]->personalHistoryItemName=="Yes")
        {{$personalHistoryDetails['patientHistory'][5]->personalHistoryValue}}
    @else
        No
    @endif
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Habits / Addictions</label>
<div class="col-sm-6 control-label">
    @if($personalHistoryDetails['patientHistory'][6]->personalHistoryItemName=="Yes")
        {{$personalHistoryDetails['patientHistory'][6]->personalHistoryValue}}
    @else
        No
    @endif
</div>
</div>
</form>
<?php */ ?>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
