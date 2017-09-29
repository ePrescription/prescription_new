<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientDentalExaminationItems extends Model
{
    protected $table = 'patient_dental_examination_item';

    public function dentalexamination()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientDentalExamination', 'patient_dental_examination_id');
    }
}
