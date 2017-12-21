<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/29/2016
 * Time: 10:19 PM
 */

namespace App\prescription\services;

use App\prescription\repositories\repointerface\LabInterface;
use App\prescription\utilities\Exception\LabException;
use App\prescription\utilities\ErrorEnum\ErrorEnum;

use Illuminate\Support\Facades\DB;
use Exception;

class LabService
{
    protected $labRepo;

    public function __construct(LabInterface $labRepo)
    {
        $this->labRepo = $labRepo;
    }

    /**
     * Get the profile of the lab
     * @param $labId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getProfile($labId)
    {
        $labProfile = null;

        try
        {
            $labProfile = $this->labRepo->getProfile($labId);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new Exception(null, ErrorEnum::LAB_PROFILE_VIEW_ERROR, $exc);
        }

        return $labProfile;
    }

    /**
     * Get the list of patients for the selected lab
     * @param $labId, $hospitalId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getPatientListForLab($labId, $hospitalId)
    {
        $patients = null;

        try
        {
            $patients = $this->labRepo->getPatientListForLab($labId, $hospitalId);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_PATIENT_LIST_ERROR, $exc);
        }

        return $patients;
    }

    /**
     * Get the list of lab tests for the selected lab
     * @param $labId, $hospitalId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getTestsForLab($labId, $hospitalId)
    {
        $labTests = null;

        try
        {
            $labTests = $this->labRepo->getTestsForLab($labId, $hospitalId);
            //dd($prescriptions);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Get lab tests by LID
     * @param $lid
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsByLid($lid)
    {
        $labTests = null;

        try
        {
            $labTests = $this->labRepo->getLabTestsByLid($lid);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_LIST_LID_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Edit Lab Details
     * @param $labVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function editLab($labVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($labVM, &$status)
            {
                $status = $this->labRepo->editLab($labVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::LAB_SAVE_ERROR, $ex);
        }

        return $status;
    }


    /**
     * Get the list of lab tests for the selected patient
     * @param $patientId
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function getTestsForLabForPatient($patientId)
    {
        $labTests = null;

        try
        {
            $labTests = $this->labRepo->getTestsForLabForPatient($patientId);
            //dd($prescriptions);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }



    public function getTestsForDoctor($doctorId, $hospitalId)
    {
        $labTests = null;

        try
        {
            $labTests = $this->labRepo->getTestsForDoctor($doctorId, $hospitalId);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labTests;
    }

    /**
     * Upload patient lab test documents
     * @param $labDocumentsVM
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientLabDocuments($labDocumentsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($labDocumentsVM, &$status)
            {
                $status = $this->labRepo->uploadPatientLabDocuments($labDocumentsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENTS_UPLOAD_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Get patient documents
     * @param $patientId
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function getPatientDocuments($patientId)
    {
        $labReports = null;

        try
        {
            $labReports = $this->labRepo->getPatientDocuments($patientId);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::LAB_TESTS_LIST_ERROR, $exc);
        }

        return $labReports;
    }

    /**
     * Download document item
     * @param $documentItemId
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function downloadPatientDocument($documentItemId)
    {
        $documentItem = null;

        try
        {
            $documentItem = $this->labRepo->downloadPatientDocument($documentItemId);
        }
        catch(LabException $profileExc)
        {
            throw $profileExc;
        }
        catch(Exception $exc)
        {
            throw new LabException(null, ErrorEnum::PATIENT_LAB_DOCUMENT_DOWNLOAD_ERROR, $exc);
        }

        return $documentItem;
    }

    /**
     * Save blood test results
     * @param $testResultsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveBloodTestResults($testResultsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($testResultsVM, &$status)
            {
                $status = $this->labRepo->saveBloodTestResults($testResultsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {
            dd($ex);
            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_TEST_RESULTS_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save motion test results
     * @param $testResultsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveMotionTestResults($testResultsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($testResultsVM, &$status)
            {
                $status = $this->labRepo->saveMotionTestResults($testResultsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_TEST_RESULTS_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save urine test results
     * @param $testResultsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveUrineTestResults($testResultsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($testResultsVM, &$status)
            {
                $status = $this->labRepo->saveUrineTestResults($testResultsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_TEST_RESULTS_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save ultrasound test results
     * @param $testResultsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveUltrasoundTestResults($testResultsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($testResultsVM, &$status)
            {
                $status = $this->labRepo->saveUltrasoundTestResults($testResultsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_TEST_RESULTS_ERROR, $ex);
        }

        return $status;
    }

    /**
     * Save scan test results
     * @param $testResultsVM
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveScanTestResults($testResultsVM)
    {
        $status = true;

        try
        {
            //dd('Inside edit lab in service');
            DB::transaction(function() use ($testResultsVM, &$status)
            {
                $status = $this->labRepo->saveScanTestResults($testResultsVM);
            });

        }
        catch(LabException $profileExc)
        {
            $status = false;
            throw $profileExc;
        }
        catch (Exception $ex) {

            $status = false;
            throw new LabException(null, ErrorEnum::PATIENT_TEST_RESULTS_ERROR, $ex);
        }

        return $status;
    }
}