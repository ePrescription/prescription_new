<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientDentalExamination extends Model
{
    protected $table = 'patient_dental_examination';

    public function dentalexaminationitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientDentalExaminationItems', 'patient_dental_examination_id');
    }
}
