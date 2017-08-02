@extends('layout.master-hospital-inner')

@section('title', 'ePrescription and Lab Tests Application')

@section('styles')
@stop
<?php
$dashboard_menu="1";
$patient_menu="0";
$profile_menu="0";
?>
@section('content')
<div class="wrapper">
    @include('portal.hospital-header')
    <!-- Left side column. contains the logo and sidebar -->

    <!-- sidebar: style can be found in sidebar.less -->
    @include('portal.hospital-sidebar')
    <!-- /.sidebar -->

    <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">

            <div class="">
                <div class="page-header-title">
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>

            <div class="page-content-wrapper ">

                <div class="container">

                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Total Subscription</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-warning font-light"><i class="mdi mdi-arrow-down-bold-circle-outline m-r-10"></i>89,52,125</h2>
                                    <p class=" m-b-0 m-t-20 text-muted"><b>48%</b> From Last 24 Hours</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Unique Visitors</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-success font-light"><i class="mdi mdi-arrow-up-bold-circle-outline m-r-10"></i>4,52,564</h2>
                                    <p class="text-muted m-b-0 m-t-20"><b>22%</b> From Last 24 Hours</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Order Status</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-purple font-light"><i class="mdi mdi-arrow-up-bold-circle-outline m-r-10"></i>65,21,542</h2>
                                    <p class="m-b-0 m-t-20 text-muted"><b>42%</b> Orders in Last 10 months</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h4 class="panel-title text-muted m-t-10 font-light">Monthly Earnings</h4>
                                </div>
                                <div class="panel-body p-t-10">
                                    <h2 class="m-t-0 m-b-15 text-pink font-light"><i class="mdi mdi-arrow-down-bold-circle-outline m-r-10"></i>56,21,256</h2>
                                    <p class="text-muted m-b-0 m-t-20"><b>35%</b> From Last 1 Month</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Monthly Earnings</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3654</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>954</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>8462</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-donut-example" style="height: 300px"><svg height="300" version="1.1" width="303" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#dcdcdc" d="M151.5,243.33333333333331A93.33333333333333,93.33333333333333,0,0,0,239.72775519497708,180.44625304313007" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#dcdcdc" stroke="#ffffff" d="M151.5,246.33333333333331A96.33333333333333,96.33333333333333,0,0,0,242.56364732624417,181.4248826052307L279.1151459070204,194.03833029452744A135,135,0,0,1,151.5,285Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#7578f9" d="M239.72775519497708,180.44625304313007A93.33333333333333,93.33333333333333,0,0,0,67.78484627831412,108.73398312817662" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#7578f9" stroke="#ffffff" d="M242.56364732624417,181.4248826052307A96.33333333333333,96.33333333333333,0,0,0,65.09400205154564,107.40757544301087L25.927269417471166,88.10097469226493A140,140,0,0,1,283.8416327924656,195.6693795646951Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#5cb45b" d="M67.78484627831412,108.73398312817662A93.33333333333333,93.33333333333333,0,0,0,151.47067846904883,243.333328727518" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#5cb45b" stroke="#ffffff" d="M65.09400205154564,107.40757544301087A96.33333333333333,96.33333333333333,0,0,0,151.46973599126827,246.3333285794739L151.4575884998742,284.9999933380171A135,135,0,0,1,30.412009795418626,90.31165416754118Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="151.5" y="140" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="15px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;" font-weight="800" transform="matrix(1.4579,0,0,1.4579,-69.368,-69.1426)" stroke-width="0.6859188988095237"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">In-Store Sales</tspan></text><text x="151.5" y="160" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="14px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;" transform="matrix(1.9444,0,0,1.9444,-143.1719,-143.5556)" stroke-width="0.5142857142857143"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">30</tspan></text></svg></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Revenue</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>5248</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>321</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>964</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-bar-example" style="height: 300px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="300" version="1.1" width="303" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.84375" y="261" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,261H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="202" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">25</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,202H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="143" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,143H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="84" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,84H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,25H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="263.458984375" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2016</tspan></text><text x="176.212890625" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2013</tspan></text><text x="88.966796875" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan></text><rect x="54.068359375" y="25" width="4.31640625" height="236" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="61.384765625" y="48.60000000000002" width="4.31640625" height="212.39999999999998" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="83.150390625" y="84" width="4.31640625" height="177" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="90.466796875" y="107.6" width="4.31640625" height="153.4" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="112.232421875" y="143" width="4.31640625" height="118" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="119.548828125" y="166.60000000000002" width="4.31640625" height="94.39999999999998" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="141.314453125" y="84" width="4.31640625" height="177" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="148.630859375" y="107.6" width="4.31640625" height="153.4" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="170.396484375" y="143" width="4.31640625" height="118" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="177.712890625" y="166.60000000000002" width="4.31640625" height="94.39999999999998" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="199.478515625" y="84" width="4.31640625" height="177" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="206.794921875" y="107.6" width="4.31640625" height="153.4" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="228.560546875" y="25" width="4.31640625" height="236" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="235.876953125" y="48.60000000000002" width="4.31640625" height="212.39999999999998" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="257.642578125" y="48.60000000000002" width="4.31640625" height="212.39999999999998" rx="0" ry="0" fill="#ed699b" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect><rect x="264.958984375" y="84" width="4.31640625" height="177" rx="0" ry="0" fill="#1d1e3a" stroke="none" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></rect></svg><div class="morris-hover morris-default-style" style="display: none;"></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-t-0">Email Sent</h4>

                                    <ul class="list-inline widget-chart m-t-20 text-center">
                                        <li>
                                            <h4 class=""><b>3652</b></h4>
                                            <p class="text-muted m-b-0">Marketplace</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>5421</b></h4>
                                            <p class="text-muted m-b-0">Last week</p>
                                        </li>
                                        <li>
                                            <h4 class=""><b>9652</b></h4>
                                            <p class="text-muted m-b-0">Last Month</p>
                                        </li>
                                    </ul>

                                    <div id="morris-area-example" style="height: 300px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="300" version="1.1" width="303" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="32.84375" y="261" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,261H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="202" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">50</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,202H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="143" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">100</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,143H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="84" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">150</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,84H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="32.84375" y="25" text-anchor="end" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">200</tspan></text><path fill="none" stroke="#eeeeee" d="M45.34375,25H278" stroke-width="0.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="78.56735377543035" y="273.5" text-anchor="middle" font-family="sans-serif" font-size="12px" stroke="none" fill="#888888" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,7)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2010</tspan></text><path fill="#d2d3f6" stroke="none" d="M45.34375,225.6C53.64965094385759,193.15,70.26145283157277,104.65,78.56735377543035,95.80000000000001C86.87325471928794,86.95000000000002,103.48505660700312,154.8,111.79095755086071,154.8C120.0968584947183,154.8,136.7086603824335,95.80000000000001,145.01456132629107,95.80000000000001C153.34321816314554,95.80000000000001,170.00053183685444,154.8,178.3291886737089,154.8C186.6350896175665,154.8,203.24689150528167,104.65000000000002,211.55279244913928,95.80000000000001C219.85869339299686,86.95000000000002,236.47049528071204,87.6875,244.77639622456962,84C253.0822971684272,80.3125,269.6940990561424,70.72500000000001,278,66.30000000000001L278,261L45.34375,261Z" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path><path fill="none" stroke="#7578f9" d="M45.34375,225.6C53.64965094385759,193.15,70.26145283157277,104.65,78.56735377543035,95.80000000000001C86.87325471928794,86.95000000000002,103.48505660700312,154.8,111.79095755086071,154.8C120.0968584947183,154.8,136.7086603824335,95.80000000000001,145.01456132629107,95.80000000000001C153.34321816314554,95.80000000000001,170.00053183685444,154.8,178.3291886737089,154.8C186.6350896175665,154.8,203.24689150528167,104.65000000000002,211.55279244913928,95.80000000000001C219.85869339299686,86.95000000000002,236.47049528071204,87.6875,244.77639622456962,84C253.0822971684272,80.3125,269.6940990561424,70.72500000000001,278,66.30000000000001" stroke-width="2" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.34375" cy="225.6" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="78.56735377543035" cy="95.80000000000001" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="111.79095755086071" cy="154.8" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="145.01456132629107" cy="95.80000000000001" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="178.3291886737089" cy="154.8" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="211.55279244913928" cy="95.80000000000001" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="244.77639622456962" cy="84" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="278" cy="66.30000000000001" r="4" fill="#7578f9" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#91c191" stroke="none" d="M45.34375,249.2C53.64965094385759,230.02499999999998,70.26145283157277,178.4,78.56735377543035,172.5C86.87325471928794,166.6,103.48505660700312,202,111.79095755086071,202C120.0968584947183,202,136.7086603824335,172.5,145.01456132629107,172.5C153.34321816314554,172.5,170.00053183685444,202,178.3291886737089,202C186.6350896175665,202,203.24689150528167,178.4,211.55279244913928,172.5C219.85869339299686,166.6,236.47049528071204,157.01250000000002,244.77639622456962,154.8C253.0822971684272,152.5875,269.6940990561424,154.8,278,154.8L278,261L45.34375,261Z" fill-opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path><path fill="none" stroke="#5cb45b" d="M45.34375,249.2C53.64965094385759,230.02499999999998,70.26145283157277,178.4,78.56735377543035,172.5C86.87325471928794,166.6,103.48505660700312,202,111.79095755086071,202C120.0968584947183,202,136.7086603824335,172.5,145.01456132629107,172.5C153.34321816314554,172.5,170.00053183685444,202,178.3291886737089,202C186.6350896175665,202,203.24689150528167,178.4,211.55279244913928,172.5C219.85869339299686,166.6,236.47049528071204,157.01250000000002,244.77639622456962,154.8C253.0822971684272,152.5875,269.6940990561424,154.8,278,154.8" stroke-width="2" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="45.34375" cy="249.2" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="78.56735377543035" cy="172.5" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="111.79095755086071" cy="202" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="145.01456132629107" cy="172.5" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="178.3291886737089" cy="202" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="211.55279244913928" cy="172.5" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="244.77639622456962" cy="154.8" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="278" cy="154.8" r="4" fill="#5cb45b" stroke="#ffffff" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="display: none;"></div></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->


                </div><!-- container -->


            </div> <!-- Page content Wrapper -->

        </div><!-- /.content -->
    @include('portal.hospital-footer')
    </div><!-- /.content-page -->

</div><!-- ./wrapper -->

</body>
</html>
