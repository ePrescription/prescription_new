<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/2/2016
 * Time: 3:33 PM
 */

namespace App\prescription\mapper;

use App\Http\ViewModels\DoctorAvailabilityViewModel;
use App\Http\ViewModels\DoctorLeavesViewModel;
use App\Http\ViewModels\PharmacyViewModel;
use App\prescription\model\entities\DoctorAvailability;

//use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HospitalMapper
{
    //public static function setPhamarcyDetails(Request $pharmacyRequest)
    public static function setPhamarcyDetails($pharmacyRequest)
    {
        $pharmacyVM = new PharmacyViewModel();
        $userName = Session::get('DisplayName');
        $pharmacyVM->setPharmacyId(Auth::user()->id);
        $pharmacyVM->setName($pharmacyRequest['pharmacy_name']);
        $pharmacyVM->setAddress($pharmacyRequest['address']);
        $pharmacyVM->setCity($pharmacyRequest['city']);
        $pharmacyVM->setCountry($pharmacyRequest['country']);
        $pharmacyVM->setTelephone($pharmacyRequest['telephone']);
        //$pharmacyVM->setEmail($pharmacyRequest['email']);
        $pharmacyVM->setCreatedBy($userName);
        $pharmacyVM->setUpdatedBy($userName);
        $pharmacyVM->setCreatedAt(date("Y-m-d H:i:s"));
        $pharmacyVM->setUpdatedAt(date("Y-m-d H:i:s"));
        //$pharmacyPhone

        return $pharmacyVM;
    }

    public static function setDoctorAvailability($DoctorAvailability){
       // dd($DoctorAvailability);

        $doctorAvailabilityVM= new DoctorAvailabilityViewModel();
        $DocAvaObj = (object) $DoctorAvailability->all();
       //dd($DocAvaObj->hospitalId);
       // $doctorAvailabilityVM->setHospitalId($DocAvaObj->hospitalId);
        $doctorAvailabilityVM->setHospitalId($DocAvaObj->hospitalId);
        $doctorAvailabilityVM->setDoctorId($DocAvaObj->doctorId);
        $doctorAvailabilityVM->setWeekDay($DocAvaObj->week_day);
        $doctorAvailabilityVM->setMorningStartTime($DocAvaObj->morning_start_time);
        $doctorAvailabilityVM->setMorningEndTime($DocAvaObj->morning_end_time);
        $doctorAvailabilityVM->setAfternoonStartTime($DocAvaObj->afternoon_start_time);
        $doctorAvailabilityVM->setAfternoonEndTime($DocAvaObj->afternoon_end_time);
        $doctorAvailabilityVM->setEveningStartTime($DocAvaObj->evening_start_time);
        $doctorAvailabilityVM->setEveningEndTime($DocAvaObj->evening_end_time);

        // $doctorAvailabilityVM->setMorningTokens($DocAvaObj->morning_tokens);
        //$doctorAvailabilityVM->setAfternoonTokens($DocAvaObj->afternoon_tokens);
        $doctorAvailabilityVM->setStatus($DocAvaObj->status);
        $userName = 'Admin';
        //dd($doctorAvailabilityVM);
        $doctorAvailabilityVM->setCreatedBy($userName);
        $doctorAvailabilityVM->setUpdatedBy($userName);
        $doctorAvailabilityVM->setCreatedAt(date("Y-m-d H:i:s"));
        $doctorAvailabilityVM->setUpdatedAt(date("Y-m-d H:i:s"));

       // dd($doctorAvailabilityVM);
        return $doctorAvailabilityVM;

    }

    public static function setDoctorLeaves($DoctorLeaves){

        $doctorLeavesVM=new DoctorLeavesViewModel();
        $DocLeaObj=(object)$DoctorLeaves->all();
        $doctorLeavesVM->setHospitalId($DocLeaObj->hospitalId);
        $doctorLeavesVM->setDoctorId($DocLeaObj->doctorId);
        $doctorLeavesVM->setLeaveStartDate($DocLeaObj->leave_start_date);
        $doctorLeavesVM->setLeaveEndDate($DocLeaObj->leave_end_date);
        $doctorLeavesVM->setStatus($DocLeaObj->status);
        $doctorLeavesVM->setAvailableFrom($DocLeaObj->available_from);
        $doctorLeavesVM->setAvailableTo($DocLeaObj->available_to);

        $userName = 'Admin';
        //dd($doctorAvailabilityVM);
        $doctorLeavesVM->setCreatedBy($userName);
        $doctorLeavesVM->setUpdatedBy($userName);
        $doctorLeavesVM->setCreatedAt(date("Y-m-d H:i:s"));
        $doctorLeavesVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $doctorLeavesVM;
    }


}