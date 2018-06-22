<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionAttachment extends Model
{
    protected $table = 'patient_prescription_attachment';

    public function prescriptionattachmentitems()
    {
        return $this->hasMany('App\prescription\model\entities\PatientPrescriptionAttachmentItems', 'patient_prescription_attachment_id');
    }
}
