<style>
    div.control-label {
        text-align: left !important;
    }
    table tr th {
        background: #7578f9;  color: #fff;
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



            @if(count($motionTests)>0)
                <h4 class="m-t-0 m-b-30">Motion Test Details</h4>
                @foreach($motionTests as $recentTest)
                    <?php $displaySet=0; ?>
                    <form action="{{URL::to('/')}}/lab/rest/patient/motiontestresults" role="form" method="POST" class="display form-horizontal">
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
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Reading</th>
                                <th>Default</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentTest as $recentTestValue)
                                <tr>
                                    @if($recentTestValue->isValueSet==1)
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationName}}
                                        </td>
                                        <td class="col-sm-4" >


                                            @if($recentTestValue->ReadingStatus==1)
                                                {{$recentTestValue->Reading}}
                                            @else
                                                <input type="hidden" name="testResults[{{$i}}][examinationId]" value="{{$recentTestValue->patientExaminationItemId}}">
                                                <input type="text" name="testResults[{{$i}}][examinationValue]" value="{{$recentTestValue->Reading}}">
                                            @endif
                                        </td>
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationDefaultValue}}
                                            <?php /* ?> {{$recentTestValue->ReadingStatus}} <?php */ ?>
                                        </td>
                                    @endif
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                        @if($recentTestValue->ReadingStatus==1)

                        @else

                            <div class="col-sm-12 form-group">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-6">
                                    <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />
                                    <input type="submit" name="addmotion" value="Save Report" class="btn btn-success"/>
                                </div>
                            </div>

                        @endif
                    </form>
                @endforeach


            @endif





    @elseif(Session::get('LoginUserType')=="doctor")

        <form role="form" method="POST" class="display form-horizontal">


            @if(count($motionTests)>0)
                <h4 class="m-t-0 m-b-30">Motion Test Details</h4>
                @foreach($motionTests as $recentTest)
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
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Reading</th>
                                <th>Default</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentTest as $recentTestValue)
                                <tr>
                                    @if($recentTestValue->isValueSet==1)
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationName}}
                                        </td>
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->Reading}}
                                        </td>
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationDefaultValue}}
                                            <?php /* ?> {{$recentTestValue->ReadingStatus}} <?php */ ?>
                                        </td>
                                    @endif
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            @endif


        </form>


    @else


        <form role="form" method="POST" class="display form-horizontal">


            @if(count($motionTests)>0)
                <h4 class="m-t-0 m-b-30">Motion Test Details</h4>
                @foreach($motionTests as $recentTest)
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
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Reading</th>
                                <th>Default</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentTest as $recentTestValue)
                                <tr>
                                    @if($recentTestValue->isValueSet==1)
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationName}}
                                        </td>
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->Reading}}
                                        </td>
                                        <td class="col-sm-4" >
                                            {{$recentTestValue->examinationDefaultValue}}
                                            <?php /* ?> {{$recentTestValue->ReadingStatus}} <?php */ ?>
                                        </td>
                                    @endif
                                </tr>
                                <?php $i++; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            @endif


        </form>

    <?php /* ?>
        <form role="form" method="POST" class="display form-horizontal">


            @if(count($motionTests)>0)
                <h4 class="m-t-0 m-b-30">Motion Test Details</h4>
                @foreach($motionTests as $recentTest)
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

                                    @if($recentTestValue->isValueSet==1)
                                        <div class="col-sm-6">
                                            {{$recentTestValue->examinationName}}
                                        </div>
                                    @endif

                                <?php $i++; ?>
                            @endforeach
                    </div>
                @endforeach

            @endif


        </form>
    <?php */ ?>
    @endif

</div> <!-- panel-body -->
</div> <!-- panel -->
</div> <!-- col -->
</div> <!-- End row -->

</div><!-- container -->
