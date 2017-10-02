<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientXRayExaminationItems extends Model
{
    protected $table = 'patient_xray_examination_item';

    public function xrayexamination()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientXRayExamination', 'patient_xray_examination_id');
    }
}
