<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientUrineExamination extends Model
{
    protected $table = 'patient_urine_examination';

    public function urineexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientUrineExaminationItems', 'patient_urine_examination_id');
    }
}
