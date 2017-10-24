<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientDiagnosis extends Model
{
    protected $table = 'patient_investigations_diagnosis';

    public function patient()
    {
        return $this->belongsTo('App\User', 'patient_id');
    }
}
