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


    @if(count($pregnancyDetails)>0)
        <h4 class="m-t-0 m-b-30">Pregnancy Details</h4>
        @foreach($pregnancyDetails as $recentTest)
            <?php $displaySet=0; ?>
            <div class="form-group">
                @foreach($recentTest as $recentTestDate)
                    @if($displaySet==0)
                        <label class="col-sm-12 control-label">{{$recentTestDate->pregnancyExaminationDate}} - {{$recentTestDate->examination_time}} </label>
                        <?php $displaySet=1; ?>
                    @endif
                @endforeach
            </div>
            <div class="form-group col-sm-12">
                @foreach($recentTest as $recentTestValue)
                        <div class="col-sm-6" style="width:50%;float:left;">
                            {{$recentTestValue->pregnancyDetails}} - {{$recentTestValue->pregnancyValue}}
                        </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <?php /* ?>
    <form role="form" method="POST" class="form-horizontal ">
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Uterus Height</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[0]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Presentation of the fetus</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[1]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Fetal heart sound</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[2]->pregnancyValue}}
            </div>
        </div>
        <div class="form-group col-sm-6">
            <label class="col-sm-6 control-label">Fetal movements</label>
            <div class="col-sm-6 control-label">
                {{$pregnancyDetails[3]->pregnancyValue}}
            </div>
        </div>

    </form>
    <?php */ ?>
</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
