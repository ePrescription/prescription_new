<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientBloodExamination extends Model
{
    protected $table = 'patient_blood_examination';

    public function bloodexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientBloodExaminationItems', 'patient_blood_examination_id');
    }

    public function bloodexaminationfees()
    {
        return $this->hasMany('App\prescription\model\entities\PatientBloodExaminationFees', 'patient_blood_examination_id');
    }
}
