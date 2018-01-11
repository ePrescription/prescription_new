<?php
/**
 * Created by PhpStorm.
 * User: glodeveloper
 * Date: 1/9/18
 * Time: 12:04 PM
 */

namespace App\prescription\model\entities;

use Illuminate\Database\Eloquent\Model;

class PatientPaymentHistory extends Model
{
    protected $table = 'patient_payment_history';

    public function patientpaymenthistory()
    {
        return $this->belongsTo('App\prescription\model\entities\LabFeeReceipt', 'receipt_id');
    }
}
