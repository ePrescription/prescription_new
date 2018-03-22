<?php
namespace App\Http\ViewModels;
/**
 * Created by PhpStorm.
 * User: glodeveloper
 * Date: 3/14/18
 * Time: 10:36 AM
 */
class DoctorAvailabilityViewModel{
    /**
     * @return mixed
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param mixed $doctorId
     * @return DoctorAvailabilityViewModel
     */
    public function setDoctorId($doctorId)
    {
        $this->doctorId = $doctorId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMorningStartTime()
    {
        return $this->morningStartTime;
    }

    /**
     * @param mixed $morningStartTime
     * @return DoctorAvailabilityViewModel
     */
    public function setMorningStartTime($morningStartTime)
    {
        $this->morningStartTime = $morningStartTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMorningEndTime()
    {
        return $this->morningEndTime;
    }

    /**
     * @param mixed $morningEndTime
     * @return DoctorAvailabilityViewModel
     */
    public function setMorningEndTime($morningEndTime)
    {
        $this->morningEndTime = $morningEndTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAfternoonStartTime()
    {
        return $this->afternoonStartTime;
    }

    /**
     * @param mixed $afternoonStartTime
     * @return DoctorAvailabilityViewModel
     */
    public function setAfternoonStartTime($afternoonStartTime)
    {
        $this->afternoonStartTime = $afternoonStartTime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAfternoonEndtime()
    {
        return $this->afternoonEndtime;
    }

    /**
     * @param mixed $afternoonEndtime
     * @return DoctorAvailabilityViewModel
     */
    public function setAfternoonEndtime($afternoonEndtime)
    {
        $this->afternoonEndtime = $afternoonEndtime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMoringTokens()
    {
        return $this->moringTokens;
    }

    /**
     * @param mixed $moringTokens
     * @return DoctorAvailabilityViewModel
     */
    public function setMoringTokens($moringTokens)
    {
        $this->moringTokens = $moringTokens;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAfternoonTokens()
    {
        return $this->afternoonTokens;
    }

    /**
     * @param mixed $afternoonTokens
     * @return DoctorAvailabilityViewModel
     */
    public function setAfternoonTokens($afternoonTokens)
    {
        $this->afternoonTokens = $afternoonTokens;
        return $this;
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
    private $weekday;

    /**
     * @return mixed
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * @param mixed $weekday
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;
    }
    private $hospitalId;
    private $doctorId;
    private $morningStartTime;
    private $morningEndTime;
    private $afternoonStartTime;
    private $afternoonEndtime;
    private $eveningTokens;

    /**
     * @return mixed
     */
    public function getEveningTokens()
    {
        return $this->eveningTokens;
    }

    /**
     * @param mixed $eveningTokens
     */
    public function setEveningTokens($eveningTokens)
    {
        $this->eveningTokens = $eveningTokens;
    }

    /**
     * @return mixed
     */
    public function getEveningStartTime()
    {
        return $this->eveningStartTime;
    }

    /**
     * @param mixed $eveningStartTime
     */
    public function setEveningStartTime($eveningStartTime)
    {
        $this->eveningStartTime = $eveningStartTime;
    }

    /**
     * @return mixed
     */
    public function getEveningEndtime()
    {
        return $this->eveningEndtime;
    }

    /**
     * @param mixed $eveningEndtime
     */
    public function setEveningEndtime($eveningEndtime)
    {
        $this->eveningEndtime = $eveningEndtime;
    }
    private $eveningStartTime;
    private $eveningEndtime;
    private $moringTokens;
    private $afternoonTokens;
    private $createdBy;

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return DoctorAvailabilityViewModel
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }
    private $updatedBy;
    private $createdAt;

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
    private $updatedAt;
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


}