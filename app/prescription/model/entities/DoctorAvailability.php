<?php
/**
 * Created by PhpStorm.
 * User: glodeveloper
 * Date: 3/13/18
 * Time: 5:51 PM
 */

namespace App\prescription\model\entities;
use Illuminate\Database\Eloquent\Model;


class DoctorAvailability extends Model
{
    protected $table = 'doctor_availability';

    public function doctorAvailability()
    {
        return $this->hasMany('App\doctor', 'doctor_id');
    }

}