<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientXRayExamination extends Model
{
    protected $table = 'patient_xray_examination';

    public function xrayexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientXRayExaminationItems', 'patient_xray_examination_id');
    }
}
