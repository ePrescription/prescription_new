<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02/12/2017
 * Time: 12:56 PM
 */

namespace App\Http\ViewModels;


class PatientLabDocumentsViewModel
{
    private $patientId;
    private $labId;
    private $documentUploadDate;
    private $testCategoryName;
    private $documentName;
    private $documentPath;
    private $patientLabDocuments;

    private $doctorUploads;

    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        $this->patientLabDocuments = array();
        //$this->doctorUploads = array();
        //$this->testCategoryName = array();
        //$this->documentName = array();
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
    public function getLabId()
    {
        return $this->labId;
    }

    /**
     * @param mixed $labId
     */
    public function setLabId($labId)
    {
        $this->labId = $labId;
    }

    /**
     * @return mixed
     */
    public function getDocumentUploadDate()
    {
        return $this->documentUploadDate;
    }

    /**
     * @param mixed $documentUploadDate
     */
    public function setDocumentUploadDate($documentUploadDate)
    {
        $this->documentUploadDate = $documentUploadDate;
    }

    /**
     * @return mixed
     */
    public function getTestCategoryName()
    {
        return $this->testCategoryName;
    }

    /**
     * @param mixed $testCategoryName
     */
    public function setTestCategoryName($testCategoryName)
    {
        $this->testCategoryName = $testCategoryName;
    }

    /**
     * @return mixed
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * @param mixed $documentName
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;
    }

    /**
     * @return mixed
     */
    public function getDocumentPath()
    {
        return $this->documentPath;
    }

    /**
     * @param mixed $documentPath
     */
    public function setDocumentPath($documentPath)
    {
        $this->documentPath = $documentPath;
    }

    /**
     * @return mixed
     */
    public function getPatientLabDocuments()
    {
        return $this->patientLabDocuments;
    }

    /**
     * @param mixed $patientLabDocuments
     */
    public function setPatientLabDocuments($patientLabDocuments)
    {
        //$this->patientLabDocuments = $patientLabDocuments;
        $this->patientLabDocuments[] = $patientLabDocuments;
    }

    /**
     * @return array
     */
    public function getDoctorUploads()
    {
        return $this->doctorUploads;
    }

    /**
     * @param array $doctorUploads
     */
    public function setDoctorUploads($doctorUploads)
    {
        $this->doctorUploads = $doctorUploads;
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