
<style>
    table, td, th {
        border: 1px solid black;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
    .tabel{
        border-collapse: collapse;
        width: 100%;
    }

    th {
        height: 50px;
        text-align:center;
        color: white;
        background-color: #1d1e3a;
    }
    td{
        height: 20px;
        text-align:center;
        font-size: 12px;
    }
</style>

<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <h4 class="m-t-0 m-b-30">Doctor Schedule Assigning</h4>


                    @if (session()->has('message'))
                        <div class="col_full login-title">
                       <span style="color:red;">
                       <b>{{session('message')}}</b>
                       </span>
                        </div>
                    @endif

                    @if (session()->has('success'))
                        <div class="col_full login-title">
                      <span style="color:green;">
                      <b>{{session('success')}}</b>
                      </span>
                        </div>
                    @endif
                <!-- form start -->
                    <form action="{{URL::to('/')}}/fronthospital/rest/api/savedoctoravailability" role="form" method="POST" name="form1" onsubmit="return validateForm('form1')">
                        <div class="form-group">
                    <table cellspacing="2" border="none" class="tabel">
                        <thead>
                        <tr>
                            <th>Weak Day</th>
                            <th>Morning Start Time</th>
                            <th>Morning End Time</th>
                            <th>Afternoon Start Time</th>
                            <th>Afternoon End Time</th>
                            <th>Evening Start Time</th>
                            <th>Evening End Time</th>
                          <!--  <th>Status</th>-->
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td><select id="week_day" name="week_day">
                                    <option value="week">Week</option>
                                    <option value="MON">Monday</option>
                                    <option value="TUE">Tuesday</option>
                                    <option value="WED">Wednesday</option>
                                    <option value="THU">Thursday</option>
                                    <option value="FRI">Friday</option>
                                    <option value="SAT">Saturday</option>
                                    <option value="SUN">Sunday</option>
                                </select></td>
                            <td><input type="time" id="morning_start_time" name="morning_start_time"></td>
                            <td><input type="time" id="morning_end_time" name="morning_end_time"></td>
                            <td><input type="time" id="afternoon_start_time" name="afternoon_start_time"></td>
                            <td><input type="time" id="afternoon_end_time" name="afternoon_end_time"></td>
                            <td><input type="time" id="evening_start_time" name="evening_start_time"></td>
                            <td><input type="time" id="evening_end_time" name="evening_end_time"></td>
                            <input type="hidden" class="form-controlx" name="status" value="1" required="required" checked/>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="hidden" id="doctorId" name="doctorId" value="{{$doctorId}}" >
                                <input type="hidden" id="hospitalId" name="hospitalId" value="{{Auth::user()->id}}">

                            </td>
                              <td><input type="submit"   value="Save" class="btn btn-success"/>

                              </td>
                        </tr>
                        </thead>
                    </table>
                        </div>
                       </form>

                    <hr>

                    <h4>Doctor Availabilities</h4>
                    @if(count($doctorsAvailability)>0)

                        <div class="form-group">
                            <table cellspacing="2" class="tabel">

                                @foreach($doctorsAvailability as $doctorAvail)


                                    <tr>
                                       <td> <form role="form"  id="{{$doctorAvail->week_day}}" >
                                        <table class="tabel" >


                                            <tr>
                                    <td><select id="week_day" name="week_day">
                                            <option selected value="{{$doctorAvail->week_day}}">{{$doctorAvail->week_day}}</option>
                                        </select></td>
                                    <td><input type="time" id="morning_start_time" name="morning_start_time" value="{{$doctorAvail->morning_start_time}}"></td>
                                    <td><input type="time" id="morning_end_time" name="morning_end_time" value="{{$doctorAvail->morning_end_time}}"></td>
                                    <td><input type="time" id="afternoon_start_time" name="afternoon_start_time" value="{{$doctorAvail->afternoon_start_time}}"></td>
                                    <td><input type="time" id="afternoon_end_time" name="afternoon_end_time" value="{{$doctorAvail->afternoon_end_time}}"></td>
                                    <td><input type="time" id="evening_start_time" name="evening_start_time" value="{{$doctorAvail->evening_start_time}}"></td>
                                    <td><input type="time" id="evening_end_time" name="evening_end_time" value="{{$doctorAvail->evening_end_time}}"></td>
                                    <input type="hidden" id="status" name="status" value="1" />
                                    <input type="hidden" id="doctorId" name="doctorId" value="{{$doctorAvail->doctor_id}}" >
                                    <input type="hidden" id="hospitalId" name="hospitalId" value="{{$doctorAvail->hospital_id}}">
                                    </td>
                                    <td><input type="button" value="Update" class="btn btn-primary" onclick="update('{{$doctorAvail->week_day}}')"/></td>
                                    </tr></table> </form></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                        </div>
                    @endif
                    <hr>  <hr>
                <h4>Doctor Non-Availability Duration</h4>
                <form id="LeavesForm" name="LeavesForm">
                    <div class="form-group">
                        <table cellspacing="2" border="none" class="tabel">
                            <thead>
                            <tr>
                                <th>Leave Start Date</th>
                                <th>Leave End Date</th>
                                <th>Total Days</th>
                                <th>Status</th>
                               
                                <th  id="th1" style="display: none;">Avl Start Time</th>
                                <th id="th2" style="display: none;">Avl End Time</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td><input type="date" id="leave_start_date" name="leave_start_date" min="<?php echo date("Y-m-d"); ?>" ></td>
                                <td><input type="date" id="leave_end_date" name="leave_end_date" onchange="DayCalculator()" min="<?php echo date("Y-m-d"); ?>"></td>
                                <td><input type="text" id="days" id="days"></td>
                                <td>
                                    <input type="radio" name="status" id="status" value="0" required onchange="actionShow()" checked>Non-Avl
                                    <input type="radio" name="status" id="status" value="1" required onchange="actionHide()" >Avbl
                                </td>
                                <td id="td1" style="display: none;"><input type="time" id="available_from" name="available_from"  ></td>
                                <td id="td2" style="display: none;"><input type="time" id="available_to" name="available_to" ></td>
                                <input type="hidden" id="doctorId" name="doctorId" value="{{$doctorId}}" >
                                <input type="hidden" id="hospitalId" name="hospitalId" value="{{Auth::user()->id}}">

                                <td><input type="button" value="Save" class="btn btn-success" onclick="InsertLeaves()"/></td>
                            </tr>
                            </thead>
                        </table>
                <!-- panel-body -->
                </div>
                </form>


                @if(count($doctorLeaves)>0)
                        <h4>Doctor Non-Availability Details</h4>
                    <div class="form-group">
                        <table cellspacing="2" class="tabel">

                            @foreach($doctorLeaves as $doctorAvail)


                                <tr>
                                    <td> <form role="form"  id="{{$doctorAvail->id}}" name="{{$doctorAvail->id}}">
                                            <table class="tabel"  >

                                                <tr>
                                                    <td><input type="date" id="leave_start_date" name="leave_start_date" min="<?php echo date("Y-m-d"); ?>"  value="{{$doctorAvail->leave_start_date}}"></td>
                                                    <td><input type="date" id="leave_end_date" name="leave_end_date" min="<?php echo date("Y-m-d"); ?>"  value="{{$doctorAvail->leave_end_date}}">
                                                         <input type="hidden" id="doctorId" name="doctorId" value="{{$doctorAvail->doctor_id}}" >
                                                        <input type="hidden" id="hospitalId" name="hospitalId" value="{{$doctorAvail->hospital_id}}">
                                                    </td>
                                                    <?php
                                                     $nodays=intval(abs(strtotime($doctorAvail->leave_start_date)-strtotime($doctorAvail->leave_end_date))/86400);
                                                    ?>
                                                    <td><input type="text" id="days" name="days" value="{{$nodays+1}}"></td>

                                                    @if($doctorAvail->status==1)
                                                    <td>
                                                        <input type="radio" name="status" id="status" value="1"    checked required>Avbl
                                                    </td>
                                                    @else
                                                        <td>
                                                            <input type="radio" name="status" id="status" value="0"  checked>Non-Avl
                                                        </td>
                                                        @endif
                                                    @if($doctorAvail->status==1)
                                                   <td><input type="time" id="available_from" name="available_from" value="{{$doctorAvail->available_from}}"></td>
                                                   <td><input type="time" id="available_to" name="available_to" value="{{$doctorAvail->available_to}}"></td>
                                                    @else
                                                        <td id="rd1"><input type="time" id="available_from" name="available_from" value="{{$doctorAvail->available_from}}" readonly="readonly"></td>
                                                        <td id="rd2"><input type="time" id="available_to" name="available_to" value="{{$doctorAvail->available_to}}" readonly="readonly"></td>
                                                       @endif
                                                        <td><input type="button" value="Update" class="btn btn-primary" onclick="updateLeaves({{$doctorAvail->id}})"/></td>
                                                        <td><input type="button" value="Delete" class="btn btn-danger" onclick="DeleteLeaves({{$doctorAvail->id}})"/></td>

                                                </tr></table> </form></td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                @endif
            </div>
            </div>


                <!-- panel -->
            </div> <!-- col -->
        </div> <!-- End row -->

    </div><!-- container -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    function DeleteLeaves(id) {
        var BASEURL = "{{ URL::to('/') }}/";
        var data = $("#" + id).serialize();
        var ask = window.confirm("Are You Sure Want To Delete Record..?");
        if (ask){
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/' + id + '/deleteDoctorLeaves';
            $.ajax({
                url: callurl,
                type: "GET",
                data: data,
                success: function (data) {
                    console.log(data);
                    alert(data);
                    $("#doctorInfo").html("");

                    $("#doctorInfo").html(data);
                }
            });
        }
    }

    function validateForm(formId) {
        var mstart =document.forms[formId]["morning_start_time"].value;
        var mend = document.forms[formId]["morning_end_time"].value;
        var afstart=document.forms[formId]["afternoon_start_time"].value;
        var afend = document.forms[formId]["afternoon_end_time"].value;
        var evstart = document.forms[formId]["evening_start_time"].value;
        var evend = document.forms[formId]["evening_end_time"].value;

        var m=1;
        var a=1;
        var e=1;
        var msg="Plase Fill start time and end time";
        if(mstart=="" && mend==""){
            m=1;
        }else if(mstart=="" || mend==""){
            m=0;
        }
        else{
            var timeA = new Date();
            timeA.setHours(mstart.split(":")[0],mstart.split(":")[1]);
            var timeB = new Date();
            timeB.setHours(mend.split(":")[0],mend.split(":")[1]);
            if(timeA>timeB){
                msg="Mornig Start Time Should be Less than Mornig End Time";
                m=0;
            }
        }
        if(afstart=="" && afend==""){
            a=1;

        }else if(afstart=="" || afend==""){
            a=0;
        }
        else{
            var timeA = new Date();
            timeA.setHours(afstart.split(":")[0],afstart.split(":")[1]);
            var timeB = new Date();
            timeB.setHours(afend.split(":")[0],afend.split(":")[1]);
            if(timeA>timeB){
                msg="Afternoon Start Time Should be Less than Afternoon End Time";
                m=0;
            }
        }
        if(evstart=="" && evend==""){
            e=1;
        }else if(evstart=="" || evend==""){
            e=0;
        }else{
            var timeA = new Date();
            timeA.setHours(evstart.split(":")[0],evstart.split(":")[1]);
            var timeB = new Date();
            timeB.setHours(evend.split(":")[0],evend.split(":")[1]);
            if(timeA>timeB){
                msg="Evening Start Time Should be Less than Evening End Time";
                m=0;
            }
        }

        if(mstart=="" && mend=="" && afstart=="" && afend=="" && evstart=="" && evend==""){
            m=0;
            a=0;
            e=0;
            msg="Please Fill Atleast One Slot Of Availability..!";
        }
        if (m==1 && a==1 && e==1) {
            return true;
        }
        else{
            alert(msg);
            return false;
        }
    }
    function DayCalculator(){
        var start=document.forms["LeavesForm"]["leave_start_date"].value;
        var end=document.forms["LeavesForm"]["leave_end_date"].value;
        //  var a=$("#leave_start_date").val();
        // var b=$("#leave_end_date").val();
        var date1 = new Date(start);
        var date2 =  new Date(end);
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        document.forms["LeavesForm"]["days"].value=diffDays+1;//
        document.forms["LeavesForm"]["days"].prop('disabled',true);
        //$("#LeavesForm#days").val(diffDays).prop('disabled',true);
    }


    function actionHide() {
      //  $("#id").css("display", "none");
        $("#th1").css("display","block");
        $("#th2").css("display","block");
        $("#td1").css("display","block");
        $("#td2").css("display","block");
    }
    function actionShow() {
        $("#th1").css("display", "none");
        $("#th2").css("display", "none");
        $("#td1").css("display", "none");
        $("#td2").css("display", "none");
    }
    function InsertLeaves(){
        var start=document.forms["LeavesForm"]["leave_start_date"].value;
        var end=document.forms["LeavesForm"]["leave_end_date"].value;
        var status=document.forms["LeavesForm"]["status"].value;
        var from=document.forms["LeavesForm"]["available_from"].value;
        var to=document.forms["LeavesForm"]["available_to"].value;
        var final=1;
        var msg="Please fill Start and End Date..!";
        if(start=="" || end==""){
            final=0;
        }else{
            var d1 = new Date(start);
            var d2 = new Date(end);
            if(d1>d2){
                msg="Start Date Should Be Less Than End Date..!";
                final=0;
            }else{
                final=1;
            }
        }
        if(status==1){
            if(from==""||to==""){

                msg="Please Fill Start And End TIME..!";
                final=0;
            }

            var timeA = new Date();
            timeA.setHours(from.split(":")[0],from.split(":")[1]);
            var timeB = new Date();
            timeB.setHours(to.split(":")[0],to.split(":")[1]);
            if(timeA>timeB){
                msg="Available Start Time Should be Less than Available End Time";
                final=0;
            }
        }
        if(final==0){
          alert(msg);
        }else {
            var BASEURL = "{{ URL::to('/') }}/";
            var data = $("#LeavesForm").serialize();
            // alert(data);
            var status = 1;
            var callurl = BASEURL + 'fronthospital/rest/api/saveDoctorLeaves';
            $.ajax({
                url: callurl,
                type: "POST",
                data: data,
                success: function (data) {
                    console.log(data);
                    alert(data);
                    $("#doctorInfo").html("");

                    $("#doctorInfo").html(data);
                }
            });
        }
    }
    function updateLeaves(id){
        var BASEURL = "{{ URL::to('/') }}/";
        var data= $("#"+id).serialize();
      //  alert(id);
        //alert(data);
        var status = 1;
        var callurl = BASEURL + 'fronthospital/rest/api/'+id+'/UpdateDoctorLeaves';
        $.ajax({
            url: callurl,
            type: "GET",
            data: data,
            success: function (data) {
                console.log(data);
                alert("Updated Successfully");
                $("#doctorInfo").html("");
                $("#doctorInfo").html(data);

            }
        });
    }

    function update(id) {
       if( validateForm(id)) {
           var BASEURL = "{{ URL::to('/') }}/";
           var data = $("#" + id).serialize();
           var status = 1;
           var callurl = BASEURL + 'fronthospital/rest/api/updateavailability';
           $.ajax({
               url: callurl,
               type: "GET",
               data: data,
               success: function (data) {
                   console.log(data);
                   alert("Updated Successfully");
                   $("#doctorInfo").html("");

                   $("#doctorInfo").html(data);
               }
           });
       }
    }
</script>