<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 24/10/2017
 * Time: 4:47 PM
 */

namespace App\prescription\utilities;


class AppointmentType
{
    const APPOINTMENT_FIXED = 1;
    const APPOINTMENT_COMPLETED = 2;
    const APPOINTMENT_TRANSFERRED = 3;
    const APPOINTMENT_CANCELLED = 4;
}