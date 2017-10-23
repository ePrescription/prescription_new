<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientComplaintDetails extends Model
{
    protected $table = 'patient_complaint_details';

    public function patientcomplaint()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientComplaints', 'patient_complaint_id');
    }
}
