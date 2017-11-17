            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <h4 class="page-title">Future's Appointments</h4>

                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th> </th>
                                <th>Normal</th>
                                <th>Special</th>
                                <th>Pregnancy</th>
                                <th>Online</th>
                            </tr>
                            </thead>


                            <tbody>

                                <tr>
                                    <td>
                                        Open
                                    </td>
                                    <td>

                                    <?php
                                        $openAppointments = $dashboardDetails['openAppointments'];
                                        $selected_value = "Normal";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                            if($e->appointment_category == $selected_value)
                                            { return true; }
                                            else
                                            { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                    ?>
                                        {{$noAppointments}}
                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['openAppointments'];
                                        $selected_value = "Special";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}


                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['openAppointments'];
                                        $selected_value = "Pregnancy";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['openAppointments'];
                                        $selected_value = "Online";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Transferred
                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['transferredAppointments'];
                                        $selected_value = "Normal";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}
                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['transferredAppointments'];
                                        $selected_value = "Special";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}


                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['transferredAppointments'];
                                        $selected_value = "Pregnancy";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['transferredAppointments'];
                                        $selected_value = "Online";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Cancelled
                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['cancelledAppointments'];
                                        $selected_value = "Normal";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}
                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['cancelledAppointments'];
                                        $selected_value = "Special";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}


                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['cancelledAppointments'];
                                        $selected_value = "Pregnancy";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                    <td>

                                        <?php
                                        $openAppointments = $dashboardDetails['cancelledAppointments'];
                                        $selected_value = "Online";

                                        $openAppointments_values = array_filter($openAppointments, function($e) use ($selected_value){

                                        if($e->appointment_category == $selected_value)
                                        { return true; }
                                        else
                                        { return false; }

                                        });

                                        if(count($openAppointments_values))
                                        {
                                        $openAppointments_values_key = key($openAppointments_values);
                                        $noAppointments = $openAppointments_values[$openAppointments_values_key]->noAppointments;
                                        }
                                        else
                                        {
                                        $noAppointments = "0";
                                        }

                                        ?>
                                        {{$noAppointments}}

                                    </td>
                                </tr>


                            </tbody>
                        </table>

                    </div>
                </div><!-- container -->


            </div> <!-- Page content Wrapper -->
