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



            @if(count($bloodTests)>0)
                <h4 class="m-t-0 m-b-30">Blood Test Details</h4>
                @foreach($bloodTests as $recentTest)
                <form action="{{URL::to('/')}}/lab/rest/patient/bloodtestresults" role="form" method="POST" onsubmit="return submitForm(this);" class="display form-horizontal">

                <?php $displaySet=0; ?>
                    <div class="form-group">
                        @foreach($recentTest as $recentTestDate)
                            @if($displaySet==0)
                                <label class="col-sm-12 control-label">{{$recentTestDate[0]->examinationDate}} - {{$recentTestDate[0]->examination_time}} </label>
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
                            <?php $recentTestKeyValueName=""; ?>
                        @foreach($recentTest as $recentTestValueGroup)

                            @foreach($recentTestValueGroup as $recentTestValue)
                            <?php
                            $recentTestKeyValue=array_keys($recentTest,$recentTestValueGroup);
                            if($recentTestKeyValueName!=$recentTestKeyValue[0]) {
                            $recentTestKeyValueName = $recentTestKeyValue[0];

                            ?>
                            <tr>
                                <td colspan="3">
                                   <strong> {{$recentTestKeyValueName}} </strong>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                            @if($recentTestValue->isValueSet==1)
                                <td class="col-sm-4" style="text-align: right;">

                                    <?php
                                        $finalvalue="";
                                      $val1="Serum Glucose (F)";
                                      $val2="Serum Glucose (PP)";
                                      $val3="Serum Glucose (R)";
                                      if($recentTestValue->examinationName==$val1){
                                          $finalvalue="Fasting--     Serum Glucose (F)";
                                      }else if($recentTestValue->examinationName==$val2){
                                          $finalvalue="Post Prandial--     Serum Glucose (PP)";
                                      }else if($recentTestValue->examinationName==$val3){
                                          $finalvalue="Random--     Serum Glucose (R)";
                                      }else{
                                          $finalvalue=$recentTestValue->examinationName;
                                      }

                                    ?>

                                    {{$finalvalue}}
                                </td>
                                <td class="col-sm-4">

                                    @if($recentTestValue->readingStatus==1)
                                       <div  style="display: block" >
                                       <!-- {{$recentTestValue->readings}} -->
                                           <input   type="hidden" name="testResults[{{$i}}][examinationId]" value="{{$recentTestValue->patientExaminationItemId}}">
                                           <input class="updatefields"  disabled="disabled" type="text" name="testResults[{{$i}}][examinationValue]" value="{{$recentTestValue->readings}}" >

                                       </div>

                                    @else

                                    <input type="hidden" name="testResults[{{$i}}][examinationId]" value="{{$recentTestValue->patientExaminationItemId}}">
                                    <input type="text" name="testResults[{{$i}}][examinationValue]" value="{{$recentTestValue->readings}}" >

                                         @endif
                                </td>

                                <td class="col-sm-4" >
                                    {{$recentTestValue->examinationDefaultValue}}
                                    <?php /* ?> {{$recentTestValue->readingStatus}} <?php */ ?>
                                </td>
                            @endif
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        @endforeach
                            </tbody>
                        </table>
                    </div>

                @if($recentTestValue->readingStatus==1)
                        <div class="col-sm-12 form-group" style="display: block" id="buttonTest">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-6">
                                <button type="button" name="addblood" id="visible" value="Update" onclick="UpdateAction()" class="btn btn-success">Update</button>
                            </div>
                        </div>

                        <div class="col-sm-12 form-group" style="display: none" id="updatepart">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-6">
                                <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />
                                <input type="submit" name="addblood" value="Update Report" class="btn btn-success"/>
                            </div>
                        </div>


                    @else

                <div class="col-sm-12 form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-6">
                        <input type="hidden" class="form-control" name="patientId" value="{{$patientId}}" required="required" />
                        <input type="submit" name="addblood" value="Save Report" class="btn btn-success"/>
                    </div>
                </div>

                @endif
                </form>
            @endforeach

            @endif





    @elseif(Session::get('LoginUserType')=="doctor")

    <form role="form" method="POST" class="display form-horizontal">

        @if(count($bloodTests)>0)
            <h4 class="m-t-0 m-b-30">Blood Test Details</h4>
            @foreach($bloodTests as $recentTest)
                <?php $displaySet=0; ?>
                <div class="form-group">
                    @foreach($recentTest as $recentTestDate)
                        @if($displaySet==0)
                            <label class="col-sm-12 control-label">{{$recentTestDate[0]->examinationDate}} - {{$recentTestDate[0]->examination_time}} </label>
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
                        <?php $recentTestKeyValueName=""; ?>
                        @foreach($recentTest as $recentTestValueGroup)
                            @foreach($recentTestValueGroup as $recentTestValue)
                            <?php
                            $recentTestKeyValue=array_keys($recentTest,$recentTestValueGroup);
                            if($recentTestKeyValueName!=$recentTestKeyValue[0]) {
                            $recentTestKeyValueName = $recentTestKeyValue[0];
                            ?>
                            <tr>
                                <td colspan="3">
                                    <strong>{{$recentTestKeyValueName}}</strong>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                @if($recentTestValue->isValueSet==1)
                                    <td class="col-sm-4" style="text-align: right;">

                                            {{$recentTestValue->examinationName}}
                                    </td>
                                    <td class="col-sm-4" >
                                        {{$recentTestValue->readings}}
                                    </td>
                                    <td class="col-sm-4" >
                                        {{$recentTestValue->examinationDefaultValue}}
                                        <?php /* ?> {{$recentTestValue->readingStatus}} <?php */ ?>
                                    </td>
                                @endif
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach

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
                                <label class="col-sm-12 control-label">{{$recentTestDate[0]->examinationDate}} - {{$recentTestDate[0]->examination_time}} </label>
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
                            <?php $recentTestKeyValueName=""; ?>
                            @foreach($recentTest as $recentTestValueGroup)
                                @foreach($recentTestValueGroup as $recentTestValue)
                                    <?php
                                    $recentTestKeyValue=array_keys($recentTest,$recentTestValueGroup);
                                    if($recentTestKeyValueName!=$recentTestKeyValue[0]) {
                                    $recentTestKeyValueName = $recentTestKeyValue[0];
                                    ?>
                                    <tr>
                                        <td colspan="3">
                                            <strong>{{$recentTestKeyValueName}}</strong>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        @if($recentTestValue->isValueSet==1)
                                            <td class="col-sm-4" style="text-align: right;">

                                                {{$recentTestValue->examinationName}}
                                            </td>
                                            <td class="col-sm-4" >
                                                {{$recentTestValue->readings}}
                                            </td>
                                            <td class="col-sm-4" >
                                                {{$recentTestValue->examinationDefaultValue}}
                                                <?php /* ?> {{$recentTestValue->readingStatus}} <?php */ ?>
                                            </td>
                                        @endif
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            @endif


        </form>

    <?php /* ?>
    <form role="form" method="POST" class="display form-horizontal">

        @if(count($bloodTests)>0)
            <h4 class="m-t-0 m-b-30">Blood Test Details</h4>
            @foreach($bloodTests as $recentTest)
                <?php $displaySet=0; ?>
                <div class="form-group">
                    @foreach($recentTest as $recentTestDate)
                        @if($displaySet==0)
                            <label class="col-sm-12 control-label">{{$recentTestDate[0]->examinationDate}} - {{$recentTestDate[0]->examination_time}} </label>
                            <?php $displaySet=1; ?>
                        @endif
                    @endforeach
                </div>
                <div class="form-group col-sm-12">


                    <?php $i=0; ?>

                        <?php $recentTestKeyValueName=""; ?>
                        @foreach($recentTest as $recentTestValueGroup)
                            @foreach($recentTestValueGroup as $recentTestValue)
                                <?php
                                $recentTestKeyValue=array_keys($recentTest,$recentTestValueGroup);
                                if($recentTestKeyValueName!=$recentTestKeyValue[0]) {
                                $recentTestKeyValueName = $recentTestKeyValue[0];
                                ?>
                                    <div class="col-sm-6">
                                       {{$recentTestKeyValueName}}
                                    </div>
                                <?php } ?>

                                <?php $i++; ?>
                            @endforeach
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
<script>
    function UpdateAction(){

        document.getElementById("visible").style.display="none";
        document.getElementById("updatepart").style.display="block";
        $("input[class='updatefields']").prop( "disabled", false );;

    }
</script>
<script>
    function submitForm() {
        return confirm('Do you really want to Save Results?');
    }

</script>
