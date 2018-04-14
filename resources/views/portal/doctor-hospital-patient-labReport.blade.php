

<div id="PatientInfoPrint" class="" style="height:100px; border: 1px solid #000000; padding: 5px; line-height: 18px;">
    <div class="row" style="text-transform: uppercase" >

        <div class="col-lg-6" style="width:50%;float:left; ">

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Name</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{$patientExaminations['patientDetails']->name}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Age</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{$patientExaminations['patientDetails']->age}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Sex</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{ $patientExaminations['patientDetails']->gender==0 ? "Male" :"Female"}}
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left;font-size: 12px; font-weight: bold; ">City/Town</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{$patientExaminations['patientDetails']->address==""? "----":$patientExaminations['patientDetails']->address }}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Ref.DR</label>
                <div class="col-sm-9" style="width:70%;float:left;font-size: 11px;font-weight: regular; ">
                    {{count($patientExaminations['doctorDetails'])>0?$patientExaminations['doctorDetails']->name:"---"}}
                </div>
            </div>






        </div>

        <div class="col-lg-6" style="width:50%; float: left;">


            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">PID</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{$patientExaminations['patientDetails']->pid}}
                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Receipt ID</label>
                <div class="col-sm-9" style="width:70%;float:left;font-size: 11px;font-weight: regular; ">
                    {{count($patientExaminations['recieptId'])>0?$patientExaminations['recieptId']:"---"}}
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Sample No</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{"----"}}

                </div>
            </div>
            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Specimen</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{"----"}}
                </div>
            </div>


            <div class="form-group col-md-12">
                <label class="col-sm-3 control-label" style="width:30%;float:left; font-size: 12px; font-weight: bold;">Test Date</label>
                <div class="col-sm-9" style="width:70%;float:left; font-size: 11px; font-weight: regular;">
                    {{$patientExaminations['recentBloodTests'][0]->examination_date}}
                </div>
            </div>



        </div>

    </div>

</div>
<br><br>

<?php

$defaultvalues = array(

    array(
        "id" =>42,
        "min" => 2,
        "max" =>6,
    ),
    array(
        "id" =>57,
        "min" =>0,
        "max" =>40,
    ),
    array(
        "id" =>72,
        "min" =>0,
        "max" =>39,
    ),
    array(
        "id" =>73,
        "min" =>0,
        "max" =>39,
    ),

    array(
        "id" =>43,
        "min" =>4,
        "max" =>10,
    ),
    array(
        "id" =>22,
        "min" =>4.0,
        "max" =>5.0,
    ),
    array(
        "id" =>6,
        "min" =>0.8,
        "max" =>1.7,
    ),
    array(
        "id" =>25,
        "min" =>10,
        "max" =>40,
    ),
    array(
        "id" =>13,
        "min" =>1.5,
        "max" =>4.0,
    ),
    array(
        "id" =>44,
        "min" =>60,
        "max" =>70,
    ),
    array(
        "id" =>45,
        "min" =>20,
        "max" =>40,
    ),
    array(
        "id" =>46,
        "min" =>1,
        "max" =>4,
    ),
    array(
        "id" =>47,
        "min" =>1,
        "max" =>6,
    ),
    array(
        "id" =>48,
        "min" =>0,
        "max" =>1,
    ),
    array(
        "id" =>2,
        "min" =>2,
        "max" =>10,
    ),
    array(
        "id" =>16,
        "min" =>150,
        "max" =>250,
    ),
    array(
        "id" =>21,
        "min" =>5000,
        "max" =>10000,
    ),
    array(
        "id" =>27,
        "min" =>8.5,
        "max" =>10.5,
    ),
    array(
        "id" =>28,
        "min" =>2.5,
        "max" =>7.5,
    ),
    array(
        "id" =>51,
        "min" =>0.2,
        "max" =>1.0,
    ),
    array(
        "id" =>52,
        "min" =>0.2,
        "max" =>0.4,
    ),
    array(
        "id" =>53,
        "min" =>0.0,
        "max" =>0.6,
    ),
    array(
        "id" =>54,
        "min" =>150,
        "max" =>250,
    ),
    array(
        "id" =>55,
        "min" =>30,
        "max" =>70,
    ),
    array(
        "id" =>56,
        "min" =>90,
        "max" =>150,
    ),
    array(
        "id" =>58,
        "min" =>60,
        "max" =>170,
    ),
    array(
        "id" =>61,
        "min" =>50,
        "max" =>250,
    ),

    array(
        "id" =>62,
        "min" =>60,
        "max" =>110,
    ),

    array(
        "id" =>63,
        "min" =>70,
        "max" =>180,
    ),

    array(
        "id" =>64,
        "min" =>70,
        "max" =>140,
    ),

    array(
        "id" =>69,
        "min" =>0.2,
        "max" =>1.0,
    ),

    array(
        "id" =>70,
        "min" =>0.0,
        "max" =>0.4,
    ),

    array(
        "id" =>71,
        "min" =>0.0,
        "max" =>0.6,
    ),

    array(
        "id" =>74,
        "min" =>37,
        "max" =>147,
    ),

    array(
        "id" =>75,
        "min" =>135,
        "max" =>155,
    ),

    array(
        "id" =>76,
        "min" =>3.5,
        "max" =>5.5,
    ),

    array(
        "id" =>78,
        "min" =>3.2,
        "max" =>5.2,
    ),

    array(
        "id" =>79,
        "min" =>2.2,
        "max" =>3.7,
    ),

    array(
        "id" =>80,
        "min" =>4900,
        "max" =>10900,
    ),

    array(
        "id" =>85,
        "min" =>7.350,
        "max" =>7.450,
    ),

    array(
        "id" =>86,
        "min" =>35.0,
        "max" =>48.0,
    ),

    array(
        "id" =>87,
        "min" =>83.0,
        "max" =>108.0,
    ),

    array(
        "id" =>88,
        "min" =>138,
        "max" =>146,
    ),

    array(
        "id" =>89,
        "min" =>3.5,
        "max" =>4.5,
    ),
    array(
        "id" =>90,
        "min" =>1.15,
        "max" =>1.33,
    ),

    array(
        "id" =>91,
        "min" =>74,
        "max" =>100,
    ),

    array(
        "id" =>92,
        "min" =>5.0,
        "max" =>12.5,
    ),
    array(
        "id" =>93,
        "min" =>0.51,
        "max" =>1.19,
    ),

    array(
        "id" =>94,
        "min" =>38,
        "max" =>51,
    ),

    array(
        "id" =>95,
        "min" =>12.0,
        "max" =>17.0,
    ),
    array(
        "id" =>96,
        "min" =>21.0,
        "max" =>28.0,
    ),

    array(
        "id" =>97,
        "min" =>22.0,
        "max" =>28.0,
    ),

    array(
        "id" =>98,
        "min" =>10,
        "max" =>20,
    ),
    array(
        "id" =>99,
        "min" =>-0.2,
        "max" =>3.0,
    ),

    array(
        "id" =>100,
        "min" =>-20,
        "max" =>30,
    ),

    array(
        "id" =>101,
        "min" =>94.0,
        "max" =>98.0,
    ),
    array(
        "id" =>102,
        "min" =>98,
        "max" =>107,
    ),
    array(
        "id" =>11,
        "min" =>12.8,
        "max" =>16.8,
    ),





);

function searchForId($id, $array,$value) {
    $texttype="normal";
    foreach ($array as $key => $val) {
        // echo ($val['id']." ==== ".$val['min']." ==== ".$val['max']."<br>");
        //$texttype= ($val['id']." ==== ".$val['min']." ==== ".$val['max']."<br>");
        if ($val['id'] == $id) {
            //dd($key);
            if($value>=$val['min'] && $value <=$val['max']){
                // echo ($val['id']." ==== ".$val['min']." ==== ".$val['max']);
                $texttype="normal";
            }else{
                $texttype="bold";
            }
            //  $texttype= ($val['id']." ==== ".$val['min']." ==== ".$val['max']);
        }
    }
    return $texttype;
}
//$defaultvalues ={{"id" =>1,"min" =>1,"max"=>1}};


// $defaultvalues[0]=$defaultvalues[0]['id']=42;
// $defaultvalues[0]=$defaultvalues[0]['min']=2;


?>


separate
<div id="ExaminationInfoPrint1"  class="form-group">
    @if(count($patientExaminations['recentBloodTests'])>0)


        <div class="form-group" style="font-family:traditional">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;">
                    <tr><th style="padding-right: 80px;">Test Name</th><th style="padding-right: 80px;" >Test Report</th><th style="padding-right: 50px;"  >Normal Value</th></tr>
                    <tr><th colspan="3"><hr/></th></tr>
                    <div class="form-group" style="background-color: #ffff99; color: black;">
                        <?php $parentCheck = "";?>
                        @foreach($patientExaminations['recentBloodTests'] as $recentTest)
                            @if($recentTest->is_parent==0 && ($parentCheck=="" || $parentCheck!=$recentTest->parent_examination_name))
                                <?php $parentCheck = $recentTest->parent_examination_name; ?>
                                <tr style="font-size: 14px;  align-content: center">
                                    <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                                </tr>

                            @endif
                            <tr style="font-size: 14px;font-weight: normal; align-content: center">
                                <td >
                                    @if($recentTest->is_parent==0)
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif
                                    {{$recentTest->examination_name}}
                                </td>

                                <td style="padding-left: 50px; font-weight: <?php echo searchForId($recentTest->id, $defaultvalues,$recentTest->test_readings)?>">
                                    {{$recentTest->test_readings}}{{$recentTest->units}}</td>
                                <td style="padding-left: 30px;">{{$recentTest->default_normal_values}}</td>

                            </tr>
                    @endforeach
                </table>
            </div>

        </div>
    @endif
    @if(count($patientExaminations['recentMotionExaminations'])>0)

        <div class="form-group" style="color: black;">
            <label class="col-sm-12 control-label" style=" font-size: 14px;font-weight: bold; align-content: center">Motion Test
                - {{$patientExaminations['recentMotionExaminations'][0]->examination_date}}</label>
        </div>
        <div class="form-group ">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;float:left;">
                    @foreach($patientExaminations['recentMotionExaminations'] as $recentTest)
                        <tr style="font-size: 14px; align-content: center">
                            <td style="width:33%;float:left;">{{$recentTest->examination_name}}</td>
                            <td style="width:33%;float:left;">{{$recentTest->test_readings}}</td>
                            <td style="width:33%;float:left;"></td>
                        </tr>


                    @endforeach
                </table>
            </div>
            -

        </div>
    @endif
    @if(count($patientExaminations['recentUrineExaminations'])>0)

        <div class="form-group" style="color: black;">
            <label class="col-sm-12 control-label" style=" font-size: 14px;font-weight: bold; align-content: center">Urine Test
                - {{$patientExaminations['recentUrineExaminations'][0]->examination_date}}</label>
        </div>
        <div class="form-group ">
            <div class="col-sm-4" style="width:100%;float:left;">
                <table style="width:100%;float:left;">

                    <?php $parentCheck = "";?>
                    @foreach($patientExaminations['recentUrineExaminations'] as $recentTest)
                        @if($recentTest->is_parent==0 && ($parentCheck=="" || $parentCheck!=$recentTest->parent_examination_name))
                            <?php $parentCheck = $recentTest->parent_examination_name; ?>
                            <tr style=" font-size: 14px;font-weight: bold; align-content: center">
                                <td colspan="3"> <b>{{$recentTest->parent_examination_name}}</b> </td>
                            </tr>

                        @endif
                        <tr style="font-size: 14px;font-weight: normal; align-content: center">

                            <td style="width:33%;float:left;">
                                @if($recentTest->is_parent==0)
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                                {{$recentTest->examination_name}}
                            </td>

                            <td style="width:33%;float:left;"> {{$recentTest->test_readings}}</td>
                            <td style="width:33%;float:left;">{{$recentTest->normal_default_values}}</td>

                        </tr>




                    @endforeach
                </table>
            </div>
            -


        </div>

    @endif


</div>
separate
{{$patientExaminations['recieptStatus']}}

