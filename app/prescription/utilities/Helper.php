<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/11/2017
 * Time: 4:06 PM
 */

namespace App\prescription\utilities;
use App\User;


class Helper
{
    public static function checkDoctorExists($doctorId)
    {
        $doctor = null;

        $doctorQuery =  User::join('role_user as ru', 'ru.user_id', '=', 'users.id');
        $doctorQuery->where('ru.role_id', '=', UserType::USERTYPE_DOCTOR);
        $doctorQuery->where('users.id', '=', $doctorId);
        $doctorQuery->where('users.delete_status', '=', 1);

        $doctor = $doctorQuery->first();

        return $doctor;
    }

    public static function checkPatientExists($patientId)
    {
        $patient = null;

        $patientQuery =  User::join('role_user as ru', 'ru.user_id', '=', 'users.id');
        $patientQuery->where('ru.role_id', '=', UserType::USERTYPE_PATIENT);
        $patientQuery->where('users.id', '=', $patientId);
        $patientQuery->where('users.delete_status', '=', 1);

        $patient = $patientQuery->first();

        return $patient;
    }

    public static function checkHospitalExists($hospitalId)
    {
        $hospital = null;

        $hospitalQuery =  User::join('role_user as ru', 'ru.user_id', '=', 'users.id');
        $hospitalQuery->where('ru.role_id', '=', UserType::USERTYPE_HOSPITAL);
        $hospitalQuery->where('users.id', '=', $hospitalId);
        $hospitalQuery->where('users.delete_status', '=', 1);

        $hospital = $hospitalQuery->first();

        return $hospital;
    }
}