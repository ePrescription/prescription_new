<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientComplaints extends Model
{
    protected $table = 'patient_complaints';

    public function patientcomplaintdetails()
    {
        return $this->hasMany('App\prescription\model\entities\PatientComplaintDetails', 'patient_complaint_id');
    }
}
