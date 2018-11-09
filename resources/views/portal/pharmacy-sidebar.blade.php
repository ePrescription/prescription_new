<!-- ========== Left Sidebar Start ========== -->

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
                        <li><a href="{{URL::to('/')}}/pharmacy/rest/api/{{Auth::user()->id}}/profile"> Profile</a></li>
                        <li><a href="{{URL::to('/')}}/pharmacy/rest/api/{{Auth::user()->id}}/editprofile"> Edit Profile</a></li>
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
            <a href="{{URL::to('/')}}/pharmacy/{{Auth::user()->id}}/dashboard">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="@if($prescription_menu==1) active @endif treeview">
            <a href="{{URL::to('/')}}/pharmacy/rest/api/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/prescriptions">
                <i class="fa fa-pencil-square-o"></i> <span>Prescriptions</span>
            </a>
        </li>

            <li class="@if($prescription_menu==1) active @endif treeview">
                <a href="{{URL::to('/')}}/pharmacy/rest/api/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/onlinedetails">
                    <i class="fa fa-pencil-square-o"></i> <span>Online Details</span>
                </a>
            </li>
        {{--<li class="@if($patient_menu==1) active @endif treeview">--}}
            {{--<a href="{{URL::to('/')}}/pharmacy/rest/api/{{Auth::user()->id}}/hospital/{{Session::get('LoginUserHospital')}}/patients">--}}
                {{--<i class="fa fa-users"></i> <span>Patients</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        </ul>
        </div>

        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->