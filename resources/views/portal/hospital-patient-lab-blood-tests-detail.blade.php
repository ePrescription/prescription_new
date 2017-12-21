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
    <style>
        form.display label.control-label{ text-align:left; }
    </style>
    @if(Session::get('LoginUserType')=="lab")
        {{print_r($bloodTests)}}

        <form action="{{URL::to('/')}}/lab/rest/patient/bloodtestresults" role="form" method="POST" class="form-horizontal ">

            @if(count($bloodTests)>0)
                <h4 class="m-t-0 m-b-30">Blood Test Details</h4>
                @foreach($bloodTests as $recentTest)
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
                        <?php $i=0; ?>
                        @foreach($recentTest as $recentTestValue)
                            <div class="row">
                            @if($recentTestValue->isValueSet==1)
                                <div class="col-sm-4" >
                                    {{$recentTestValue->examinationName}}
                                </div>
                                <div class="col-sm-4" >



                                    <input type="hidden" name="testResults[{{$i}}]['examinationId']" value="{{$recentTestValue->patientExaminationItemId}}">
                                    <input type="text" name="testResults[{{$i}}]['examinationValue']" value="{{$recentTestValue->Reading}}">

                                </div>
                                <div class="col-sm-4" >
                                    {{$recentTestValue->examinationDefaultValue}}
                                    <?php /* ?> {{$recentTestValue->ReadingStatus}} <?php */ ?>
                                </div>
                            @endif
                            </div>
                            <?php $i++; ?>
                        @endforeach

                    </div>
                @endforeach

                <div class="col-sm-12 form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />
                        <input type="submit" name="addblood" value="Save Report" class="btn btn-success"/>
                    </div>
                </div>
            @endif


        </form>


    @else
    <form role="form" method="POST" class="display form-horizontal">

        @if(count($bloodTests)>0)
            <h4 class="m-t-0 m-b-30">Blood Test Details</h4>
            @foreach($bloodTests as $recentTest)
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
                        @if($recentTestValue->isValueSet==1)
                            <div class="col-sm-6" style="width:50%;float:left;">
                                {{$recentTestValue->examinationName}}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        @endif

        <?php /* ?>
        <?php $i=0; ?>
        @foreach($bloodTests as $bloodTestsValue)
            @if($bloodTestsValue->isValueSet==1)
            <div class="form-group col-sm-6">
                <label class="col-sm-12 control-label">{{$bloodTestsValue->examinationName}}</label>
            </div>
            <?php $i++; ?>
            @endif
        @endforeach
        <?php */ ?>

    </form>
    @endif

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
