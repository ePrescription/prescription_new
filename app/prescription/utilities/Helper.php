<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/11/2017
 * Time: 4:06 PM
 */

namespace App\prescription\utilities;
use App\User;
use Illuminate\Support\Facades\DB;


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

    public static function generatedId($hospitalId, $idType)
    {
        $generatedId = null;

        $query = DB::table('id_generation as ig')->where('ig.generation_type', '=', trim($idType));
        $query->where('ig.status', '=', 1);
        $query->where('ig.hospital_id', '=', $hospitalId);
        $query->select('ig.id', 'ig.generation_type', 'ig.prefix', 'ig.year_required', 'ig.month_required', 'ig.no_characters');

        $ids = $query->get();
        //dd($ids);

        $generatedId = self::generateRandomString($ids);

        return $generatedId;
    }

    private static function generateRandomString($ids)
    {
        $generatedId = null;
        $year = '';
        $month = '';

        //dd($ids);

        $prefix = $ids[0]->prefix;
        //dd($prefix);
        $length = $ids[0]->no_characters;

        if($ids[0]->year_required == 1)
        {
            $year = date("y");
        }

        if($ids[0]->month_required == 1)
        {
            //$isMonth = true;
            $month = date("m");
        }

        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $generatedId = $prefix.'-'.$year.$month.$randomString;

        return $generatedId;
    }
}