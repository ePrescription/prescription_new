<?php
namespace App\Http\ViewModels;
/**
 * Created by PhpStorm.
 * User: glodeveloper
 * Date: 3/16/18
 * Time: 3:29 PM
 */
class DoctorLeavesViewModel{

    private $hospitalId;

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
    public function getLeaveStartDate()
    {
        return $this->leaveStartDate;
    }

    /**
     * @param mixed $leaveStartDate
     */
    public function setLeaveStartDate($leaveStartDate)
    {
        $this->leaveStartDate = $leaveStartDate;
    }

    /**
     * @return mixed
     */
    public function getLeaveEndDate()
    {
        return $this->leaveEndDate;
    }

    /**
     * @param mixed $leaveEndDate
     */
    public function setLeaveEndDate($leaveEndDate)
    {
        $this->leaveEndDate = $leaveEndDate;
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
    private $doctorId;
    private $leaveStartDate;
    private $leaveEndDate;
    private $availableFrom;
    private $availableTo;
    private $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param mixed $availableFrom
     */
    public function setAvailableFrom($availableFrom)
    {
        $this->availableFrom = $availableFrom;
    }

    /**
     * @return mixed
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * @param mixed $availableTo
     */
    public function setAvailableTo($availableTo)
    {
        $this->availableTo = $availableTo;
    }
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;
}