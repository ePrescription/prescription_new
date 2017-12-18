<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/2/2016
 * Time: 7:39 PM
 */

namespace App\prescription\mapper;


use App\Http\ViewModels\LabViewModel;
use App\Http\ViewModels\PatientLabDocumentsViewModel;
use App\Http\ViewModels\TestResultsViewModel;
use Illuminate\Http\Request;

//use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LabMapper
{
    //public static function setLabDetails(Request $labRequest)
    public static function setLabDetails($labRequest)
    {
        $labVM = new LabViewModel();
        $userName = Session::get('DisplayName');

        $labVM->setLabId(Auth::user()->id);
        $labVM->setName($labRequest['lab_name']);
        $labVM->setAddress($labRequest['address']);
        $labVM->setCity($labRequest['city']);
        $labVM->setCountry($labRequest['country']);
        $labVM->setPincode($labRequest['pincode']);
        $labVM->setTelephone($labRequest['telephone']);
        //$labVM->setEmail($labRequest['email']);
        //$labVM->setLabPhoto($labRequest['labphoto']);
        $labVM->setCreatedBy($userName);
        $labVM->setUpdatedBy($userName);
        $labVM->setCreatedAt(date("Y-m-d H:i:s"));
        $labVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $labVM;
    }

    public static function setLabDocumentDetails(Request $uploadRequest)
    {
        $labDocumentsVM = new PatientLabDocumentsViewModel();

        $labDocuments = $uploadRequest['lab_documents'];
        //$medicalDocuments = $hospitalRequest['medical_new_document'];

        //dd($medicalDocuments);
        //$loggedUserId = Session::get('LoginUserId');
        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        foreach ($labDocuments as $key => $value)
        {

            /*
            if(!is_null($value['test_category_name']))
            {
                $labDocumentsVM->setTestCategoryName($value);
            }

            if(!is_null($value['document_name']))
            {
                $labDocumentsVM->setDocumentName($value);
            }
            */

            if(!is_null($value['document_upload_path']))
            {
                $labDocumentsVM->setPatientLabDocuments($value);
            }


        }

        $labDocumentsVM->setDocumentName($uploadRequest['document_name']);
        $labDocumentsVM->setTestCategoryName($uploadRequest['test_category_name']);
        $labDocumentsVM->setPatientId($uploadRequest['patient_id']);
        $labDocumentsVM->setLabId($uploadRequest['lab_id']);
        $labDocumentsVM->setDocumentUploadDate(date("Y-m-d"));


        $labDocumentsVM->setCreatedBy($userName);
        $labDocumentsVM->setUpdatedBy($userName);
        $labDocumentsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $labDocumentsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $labDocumentsVM;
    }

    public static function setBloodTestMapper(Request $bloodTestRequest)
    {
        $testResultsVM = new TestResultsViewModel();

        $resultsObj = (object) $bloodTestRequest->all();
        $testResultsVM->setPatientId($resultsObj->patientId);
        /*$patientBloodVM->setDoctorId($examinationObj->doctorId);
        $patientBloodVM->setHospitalId($examinationObj->hospitalId);*/
        $testResults = $resultsObj->testResults;
        //dd($candidateEmployments);

        foreach($testResults as $testResult)
        {
            $testResultsVM->setTestResults($testResult);
        }

        //$userName = Session::get('DisplayName');
        $userName = 'Admin';

        $testResultsVM->setCreatedBy($userName);
        $testResultsVM->setUpdatedBy($userName);
        $testResultsVM->setCreatedAt(date("Y-m-d H:i:s"));
        $testResultsVM->setUpdatedAt(date("Y-m-d H:i:s"));

        return $testResultsVM;
    }
}