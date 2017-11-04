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

    @if(count($pastIllness)>0)
        <h4 class="m-t-0 m-b-30">Past Illness Details</h4>

        @foreach($pastIllness as $recentTest)
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
                        {{$recentTestValue->illnessName}} - @if($recentTestValue->isValueSet==1) Yes @else No @endif
                        @if($recentTestValue->illnessName=="Surgeries")
                            - {{$recentTestValue->otherIllnessName}}
                        @endif
                        @if($recentTestValue->illnessName=="Others")
                        - {{$recentTestValue->otherIllnessName}}
                        @endif

                    </div>
                @endforeach
            </div>

        @endforeach
    @endif



</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
