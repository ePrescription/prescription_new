<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 23/10/2017
 * Time: 12:57 PM
 */

namespace App\Http\ViewModels;


class PatientComplaintsViewModel
{
    private $patientId;
    private $doctorId;
    private $hospitalId;
    private $complaintDate;
    private $patientComplaints;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->patientComplaints = array();
    }

    /**
     * @return mixed
     */
    public function getPatientId()
    {
        return $this->patientId;
    }

    /**
     * @param mixed $patientId
     */
    public function setPatientId($patientId)
    {
        $this->patientId = $patientId;
    }

    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param mixed $doctorId
     */
    public function setDoctorId($doctorId)
    {
        $this->doctorId = $doctorId;
    }

    /**
     * @return mixed
     */
    public function getHospitalId()
    {
        return $this->hospitalId;
    }

    /**
     * @param mixed $hospitalId
     */
    public function setHospitalId($hospitalId)
    {
        $this->hospitalId = $hospitalId;
    }

    /**
     * @return mixed
     */
    public function getComplaintDate()
    {
        return $this->complaintDate;
    }

    /**
     * @param mixed $complaintDate
     */
    public function setComplaintDate($complaintDate)
    {
        $this->complaintDate = $complaintDate;
    }

    /**
     * @return mixed
     */
    public function getPatientComplaints()
    {
        return $this->patientComplaints;
    }

    /**
     * @param mixed $patientComplaints
     */
    public function setPatientComplaints($patientComplaints)
    {
        array_push($this->patientComplaints, (object) $patientComplaints);
        //$this->patientComplaints = $patientComplaints;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


}