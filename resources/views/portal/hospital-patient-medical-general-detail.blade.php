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

    @if(count($generalExamination)>0)
        <h4 class="m-t-0 m-b-30">General Examination Details</h4>
        @foreach($generalExamination as $recentTest)
            <?php $displaySet=0; ?>
            <div class="form-group">
                @foreach($recentTest as $recentTestDate)
                    @if($displaySet==0)
                        <label class="col-sm-12 control-label">{{$recentTestDate->examinationDate}} - {{$recentTestDate->examination_time}} </label>
                        <?php $displaySet=1; ?>
                    @endif
                @endforeach
            </div>
            <div class="form-group col-sm-12">
                @foreach($recentTest as $recentTestValue)
                    <div class="col-sm-6" style="width:50%;float:left;">
                        {{$recentTestValue->generalExaminationName}} - {{$recentTestValue->generalExaminationValue}}
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif


<?php /* ?>
<!-- form start -->
<form role="form" method="POST" class="form-horizontal ">
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Height (in Cm)</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[0]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Weight (in Kg)</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[1]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">BMI</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[2]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Pallor</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[3]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Cyanosis</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[4]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Clubbing of Fingers / Toes</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[5]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Lymphadenopathy</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[6]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Oedema In Feet</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[7]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Malnutrition</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[8]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Dehydration</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[9]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Temperature (C/F)</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[10]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Pulse rate per minute</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[11]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">Respiration (count for a full minute) rate</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[12]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">BP Lt.Arm mm/Hg</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[13]->generalExaminationValue}}
</div>
</div>
<div class="form-group col-sm-6">
<label class="col-sm-6 control-label">BP Rt.Arm mm/Hg</label>
<div class="col-sm-6 control-label">
    {{$generalExamination[14]->generalExaminationValue}}
</div>
</div>
</form>
<?php */ ?>



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->

