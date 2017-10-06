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

    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Endocrime diseases</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[0]->relation!="") Yes -  {{$familyIllness[0]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Hyperthyroidism</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[1]->relation!="") Yes -  {{$familyIllness[1]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Diabetes</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[2]->relation!="") Yes -  {{$familyIllness[2]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">HyperTension</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[3]->relation!="") Yes -  {{$familyIllness[3]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Heart disease</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[4]->relation!="") Yes -  {{$familyIllness[4]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Asthma</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[5]->relation!="") Yes -  {{$familyIllness[5]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Tuberculosis</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[6]->relation!="") Yes -  {{$familyIllness[6]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Stroke</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[7]->relation!="") Yes -  {{$familyIllness[7]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Cancers</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[8]->relation!="") Yes -  {{$familyIllness[8]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Any other herideitory diseases</label>
            <div class="col-sm-6 control-label">

                @if($familyIllness[9]->relation!="") {{$familyIllness[9]->otherIllnessName}} - Yes -  {{$familyIllness[9]->relation}} @else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Psychaitric illness</label>
            <div class="col-sm-6 control-label">
                @if($familyIllness[10]->relation!="") Yes - {{$familyIllness[10]->relation}}@else No @endif
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Others</label>
            <div class="col-sm-6 control-label">

                @if($familyIllness[11]->relation!="") {{$familyIllness[11]->otherIllnessName}} - Yes - {{$familyIllness[11]->relation}} @else No @endif
            </div>
        </div>
    </form>

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->

