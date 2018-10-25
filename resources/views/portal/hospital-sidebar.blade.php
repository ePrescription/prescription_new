<!-- ========== Left Sidebar Start ========== -->
<?php $appointment_menu=""; ?>
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">

        <form class="sidebar-search hidden">
            <div class="">
                <input type="text" class="form-control search-bar" placeholder="Search...">
            </div>
            <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
        </form>

        <div class="user-details">
            <div class="text-center">
                <img src="{{ URL::to('/') }}/theme/assets/images/users/hospital.png" alt="" class="img-circle">
            </div>
            <div class="user-info">
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{Session::get('AuthDisplayName')}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/profile"> Profile</a></li>
                        <li><a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/editprofile"> Edit Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ URL::to('/logout') }}"> Logout</a></li>
                    </ul>
                </div>

                <!--<p class="text-muted m-0"><i class="fa fa-dot-circle-o text-success"></i> Online</p>-->
            </div>
        </div>
        <!--- Divider -->

            <div id="sidebar-menu">
                <ul> 
                    <li class="@if($dashboard_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/{{Auth::user()->id}}/dashboard">
                            <i class="fa fa-snowflake-o"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="@if($patient_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/patients">
                            <i class="fa fa-wheelchair"></i> <span>Patients</span>
                        </a>
                    </li>
                    <li class="@if($appointment_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/rest/{{Auth::user()->id}}/patients/appointments">
                            <i class="fa fa-stethoscope"></i> <span>Appointments</span>
                        </a>
                    </li>
                    <?php if(!isset($doctor_menu)) { $doctor_menu=0; } ?>
                    <li class="@if($doctor_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/doctorlist">
                            <i class="fa fa-money"></i> <span>Doctor Fee</span>
                        </a>
                    </li>

                    <li class="@if($doctor_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/payment/online">
                            <i class="fa fa-cc-visa"></i> <span>Online Payment</span>
                        </a>
                    </li>
                    <li class="@if($doctor_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/doctorAvailabilitySetting">
                            <i class="fa fa-cogs"></i> <span>Doctors Settings</span>
                        </a>
                    </li>

                    <li class="@if($appointment_menu==1) active @endif treeview">
                        <a href="{{URL::to('/')}}/fronthospital/rest/{{Auth::user()->id}}/patients/onlinedetails">
                            <i class="fa fa-stethoscope"></i> <span>Online Details</span>
                        </a>
                    </li>

                    <li class="@if($profile_menu==1) active @endif has_sub treeview hidden">
                        <a href="javascript:void(0);">
                            <i class="fa fa-book"></i> <span>My Account</span>
                        </a>
                        <ul class="list-unstyled treeview-menu">
                            <li><a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/profile"><i class="fa fa-circle-o"></i> View Profile</a></li>
                            <li><a href="{{URL::to('/')}}/fronthospital/rest/api/{{Auth::user()->id}}/editprofile"><i class="fa fa-circle-o"></i> Edit Profile</a></li>
                        </ul>
                    </li>



                </ul>
            </div>

        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->
