<?php

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionAttachmentItems extends Model
{
    protected $table = 'patient_prescription_attachment_items';

    public function prescriptionattachment()
    {
        return $this->belongsTo('App\prescription\model\entities\PatientPrescriptionAttachment', 'patient_prescription_attachment_id');
    }
}
