<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 9/29/2016
 * Time: 10:05 PM
 */

namespace App\prescription\repositories\repointerface;


use App\Http\ViewModels\LabViewModel;
use App\Http\ViewModels\PatientLabDocumentsViewModel;
use App\Http\ViewModels\TestResultsViewModel;

interface LabInterface
{
    public function getProfile($labId);
    public function getPatientListForLab($labId, $hospitalId);
    public function getTestsForLab($labId, $hospitalId);
    public function getLabTestsByLid($lid);
    public function editLab(LabViewModel $labVM);
    public function getTestsForLabForPatient($patientId);

    public function getTestsForDoctor($doctorId, $hospitalId);

    public function uploadPatientLabDocuments(PatientLabDocumentsViewModel $labDocumentsVM);
    public function getPatientDocuments($patientId);
    public function downloadPatientDocument($documentItemId);

    public function saveBloodTestResults(TestResultsViewModel $testResultsVM);
    public function saveMotionTestResults(TestResultsViewModel $testResultsVM);
    public function saveUrineTestResults(TestResultsViewModel $testResultsVM);
    public function saveUltrasoundTestResults(TestResultsViewModel $testResultsVM);
    public function saveScanTestResults(TestResultsViewModel $testResultsVM);
    //public function saveDentalTestResults(TestResultsViewModel $testResultsVM);
}