<?php

namespace App\Http\Controllers\Lab;

use App\prescription\mapper\LabMapper;
use App\prescription\services\HelperService;
use App\prescription\services\HospitalService;
use App\prescription\services\LabService;
use App\prescription\utilities\Exception\LabException;
use App\prescription\utilities\Exception\HospitalException;

use App\prescription\utilities\Exception\AppendMessage;
use App\prescription\common\ResponseJson;
use App\prescription\utilities\ErrorEnum\ErrorEnum;

use App\prescription\facades\HospitalServiceFacade;

use GuzzleHttp\Client;
use App\prescription\model\entities\LabTestDetails;
use App\prescription\common\ResponsePrescription;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\LabReportRequest;

use Exception;
use Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Mail;
use Storage;
use Crypt;
use App\prescription\mapper\PatientProfileMapper;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PatientProfileWebRequest;
use Input;




class LabController extends Controller
{
    protected $labService;

    public function __construct(LabService $labService)
    {
        $this->labService = $labService;
    }

    /**
     * Get the profile of the lab
     * @param $labId
     * @throws $labException
     * @return array | null
     * @author Baskaran Subbaraman
     */

    public function getProfile($labId)
    {
        $labProfile = null;
        //dd('Inside get profile function in lab controller');

        try
        {
            $labProfile = $this->labService->getProfile($labId);
            //dd($labProfile);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-profile',compact('labProfile'));

        //return $labProfile;
    }

    /**
     * Get the profile of the lab
     * @param $labId
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function editProfile($labId, HelperService $helperService)
    {
        $labProfile = null;
        $cities = null;
        //dd('Inside get profile function in lab controller');

        try
        {
            $labProfile = $this->labService->getProfile($labId);
            $cities = $helperService->getCities();
            //dd($cities);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-editprofile',compact('labProfile','cities'));

        //return $labProfile;
    }

    /**
     * Get the profile of the lab
     * @param $labId
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function editChangePassword($labId)
    {
        $labProfile = null;
        //dd('Inside get profile function in lab controller');

        try
        {
           // $labProfile = $this->labService->getProfile($labId);
            //dd($labProfile);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-changepassword');

        //return $labProfile;
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
            $patients = $this->labService->getPatientListForLab($labId, $hospitalId);
            //dd($patients);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patients',compact('patients'));

        //return $patients;
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
            $labTests = $this->labService->getTestsForLab($labId, $hospitalId);
            //dd($labTests);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-labtest',compact('labTests'));

        //return $labTests;

    }

    /**
     * Get lab tests by LID
     * @param $lid
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsByLid(Request $lidRequest)
    {
        $labTests = null;
        //dd('Inside labtests by lid');
        $lid = $lidRequest->get('lid');
        //dd($lid);
        try
        {
            $labTests = $this->labService->getLabTestsByLid($lid);
            //dd($labTests);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

       // return $labTests;

        return view('portal.lab-labtest',compact('labTests'));

        //return $labTests;
    }

    /**
     * Get lab test details for the given lab test id
     * @param $labTestId
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetails(HospitalService $hospitalService, $labTestId)
    {
        $labTestDetails = null;
        //dd('Inside prescription details');

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-labtest-details',compact('labTestDetails'));
    }

    /**
     * Edit Lab Details
     * @param $labRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function editLab(Request $labRequest)
    {
        $labVM = null;
        $status = true;
        $message = null;
        //$string = ""

        try
        {
            //dd('Inside edit lab');
            /*
            $lab = array('lab_name' => 'Anderson Diagnostics', 'address' => 'test', 'city' => 15, 'country' => 99,
                'pincode' => '600005' , 'telephone' => '5464645654', 'email' => 'anderson@gmail.com');
            */
            //dd($labRequest);
            //$pharmacyVM = PharmacyMapper::setPhamarcyDetails($pharmacyRequest);
            $labVM = LabMapper::setLabDetails($labRequest);
            //dd($labVM);
            $status = $this->labService->editLab($labVM);
            //dd($status);

            /*if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_SUCCESS));
            }*/

            if($status) {
                $labId=$labVM->getLabId();
                $labProfile = $this->labService->getProfile($labId);
                $message= "Profile Details Updated Successfully";
            }
        }
        catch(LabException $profileExc)
        {
            //dd($profileExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
            //return $jsonResponse;
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-profile',compact('labProfile','message'));

        //return $jsonResponse;
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
            $labTests = $this->labService->getTestsForLabForPatient($patientId);
            //dd($labTests);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.patient-labtest',compact('labTests'));

        //return $labTests;

    }

    /**
     * Get lab tests by LID
     * @param $lid
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function getLabTestsByLidForPatient(Request $lidRequest)
    {
        $labTests = null;
        //dd('Inside labtests by lid');
        $lid = $lidRequest->get('lid');
        //dd($lid);
        try
        {
            $labTests = $this->labService->getLabTestsByLid($lid);
            //dd($labTests);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        // return $labTests;

        return view('portal.patient-labtest',compact('labTests'));

        //return $labTests;
    }


    /**
     * Get lab test details for the given lab test id
     * @param $labTestId
     * @throws $labException
     * @return array | null
     * @author Vimal
     */

    public function getLabTestDetailsForPatient(HospitalService $hospitalService, $labTestId)
    {
        $labTestDetails = null;
        //dd('Inside prescription details');

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.patient-labtest-details',compact('labTestDetails'));
    }

    /**
     * Forward the lab test details to the specified mail id
     * @param $labTestId, $email
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function forwardLabDetailsByMail(HospitalService $hospitalService, $labTestId, $email)
    {
        $labTestDetails = null;
        $labMailInfo = null;
        //dd('Inside prescription details');

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

            $subject = "LabTest Details";
            $name = "ePrescription and Lab Tests Application";
            $title = "LabTest Details";
            $content = $labTestDetails;
            $to = $email;

            $data = array('name' => $name, 'title' => $title, 'labTestDetails' => $labTestDetails);

            Mail::send('emails.labtest', $data, function ($m) use($to, $subject)  {
                //$m->from('prescriptionapp1@gmail.com', $name);
                //$m->to($to)->subject($subject);
                $m->from('shamprasadp26@gmail.com', 'ePrescription and Lab Tests Application');;
                //$m->to('alagirivimal@gmail.com')->subject('ePrescription and Lab Tests Application');
                $m->to($to)->subject($subject);
            });

            $labMailInfo = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_DETAILS_SUCCESS));
            $labMailInfo->setObj("Mail Sent Successfully");
            $labMailInfo->sendSuccessResponse();
        }
        catch(LabException $labExc)
        {
            $jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return $labMailInfo;
        //return view('portal.patient-labtest-details',compact('labTestDetails'));
    }

    /**
     * Forward the lab test details by SMS
     * @param $labTestId, $mobileNumber
     * @throws $labException
     * @return array | null
     * @author Baskar
     */

    public function forwardLabDetailsBySMS(HospitalService $hospitalService, $labTestId, $mobile)
    {
        $labTestDetails = null;
        //dd('Inside prescription details');

        $labTestSMS = null;
        $responseJson = null;

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

            $patientName = $labTestDetails['PatientProfile'][0]->name;
            $doctorName = $labTestDetails['DoctorProfile'][0]->name;
            $hospitalName = $labTestDetails['HospitalProfile'][0]->hospital_name;
            $labTestDate = $labTestDetails['PatientProfile'][0]->labtest_date;
            //$mobile = $prescriptionDetails['HospitalProfile'][0]->telephone;

            $labTests = $labTestDetails['PatientLabTestDetails'];

            foreach($labTests as $labTest)
            {
                $labTestSMS .= "Lab Test Name: ".$labTest->test_name."%0a"."Lab Test Category: ".$labTest->test_category;
                //dd($labTestSMS);
            }

            $message = "Patient Name : ".$patientName."%0a"
                ." Doctor Name: ".$doctorName."%0a"
                ." Hospital Name: ".$hospitalName."%0a"
                ." Lab Test Id: ".$labTestId."%0a"
                ." Lab Test Date: ".$labTestDate."%0a"
                ." Lab Tests: ".$labTestSMS;

            $client = new Client();
            $response = $client->get('http://bhashsms.com/api/sendmsg.php?user=Daiwiksoft&pass=Daiwik2612&sender=daiwik&phone='.$mobile.'&text='.$message.'&priority=ndnd&stype=normal');

            if($response->getStatusCode() == 200)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LABTEST_SMS_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LABTEST_SMS_ERROR));
            }

            $responseJson->sendSuccessResponse();

            //$labSMSInfo = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_DETAILS_SUCCESS));
            //$labSMSInfo->setObj("SMS Sent Successfully");

        }
        catch(LabException $labExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendErrorResponse($labExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
        //return view('portal.patient-labtest-details',compact('labTestDetails'));
    }



    public function getTestsForDoctor($doctorId, $hospitalId)
    {

        $labTests = null;

        try
        {
            $labTests = $this->labService->getTestsForDoctor($doctorId, $hospitalId);
            //dd($labTests);
        }
        catch(LabException $profileExc)
        {
            //dd($hospitalExc);
            $errorMsg = $profileExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($profileExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.doctor-labtest',compact('labTests'));

        //return $labTests;

    }


    public function getLabTestDetailsForDoctor(HospitalService $hospitalService, $labTestId)
    {
        $labTestDetails = null;
        //dd('Inside prescription details');

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.doctor-labtest-details',compact('labTestDetails'));
    }


    public function getLabTestDetailsForHospital(HospitalService $hospitalService, $labTestId)
    {
        $labTestDetails = null;
        //dd('Inside prescription details');

        try
        {
            $labTestDetails = $hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

        }
        catch(LabException $labExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.hospital-labtest-details',compact('labTestDetails'));
    }

    /**
     * Upload patient lab test documents
     * @param $uploadRequest
     * @throws $userException
     * @return true | false
     * @author Baskar
     */

    public function uploadPatientLabDocuments(Request $uploadRequest)
    {
        $status = true;
        $labDocumentsVM = null;
        //dd('Inside lab controller');

        try
        {
            $labDocumentsVM = LabMapper::setLabDocumentDetails($uploadRequest);
            $status = $this->labService->uploadPatientLabDocuments($labDocumentsVM);

            if($status)
            {
                return redirect('lab/'.$uploadRequest->lab_id.'/hospital/'.$uploadRequest->hospital_id.'/patient/'.$uploadRequest->patient_id.'/lab-report-upload')->with('success','Lab Report Upload Successfully');
            }
            else
            {
                return redirect('lab/'.$uploadRequest->lab_id.'/hospital/'.$uploadRequest->hospital_id.'/patient/'.$uploadRequest->patient_id.'/lab-report-upload')->with('message','Lab Report Upload Issues');
            }
        }
        catch(LabException $userExc)
        {
            //dd($userExc);
            $errorMsg = $userExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($userExc);
            Log::error($msg);
            //return redirect('exception')->with('message',$errorMsg." ".trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message',trans('messages.SupportTeam'));
        }

    }

    /**
     * Get patient documents
     * @param $patientId
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function getPatientDocuments($doctorId, $hospitalId, $patientId)
    {
        $labReports = null;

        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $labReports = $this->labService->getPatientDocuments($patientId);
            //dd($labReports);
            //dd($patientDetails);
        }
        catch(LabException $userExc)
        {
            //dd($userExc);
            $errorMsg = $userExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($userExc);
            Log::error($msg);
            //return redirect('exception')->with('message',$errorMsg." ".trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message',trans('messages.SupportTeam'));
        }
        return view('portal.lab-patient-lab-report-download',compact('patientDetails','labReports'));
    }


    public function getPatientDocumentsForDoctor($doctorId, $hospitalId, $patientId)
    {
        $labReports = null;

        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $labReports = $this->labService->getPatientDocuments($patientId);
            //dd($labReports);
            //dd($patientDetails);
        }
        catch(LabException $userExc)
        {
            //dd($userExc);
            $errorMsg = $userExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($userExc);
            Log::error($msg);
            //return redirect('exception')->with('message',$errorMsg." ".trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message',trans('messages.SupportTeam'));
        }
        return view('portal.doctor-patient-lab-report-download',compact('patientDetails','labReports'));
    }

    public function getPatientDocumentsForHospital($hospitalId, $patientId)
    {
        $labReports = null;

        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $labReports = $this->labService->getPatientDocuments($patientId);
            //dd($labReports);
            //dd($patientDetails);
        }
        catch(LabException $userExc)
        {
            //dd($userExc);
            $errorMsg = $userExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($userExc);
            Log::error($msg);
            //return redirect('exception')->with('message',$errorMsg." ".trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message',trans('messages.SupportTeam'));
        }
        return view('portal.hospital-patient-lab-report-download',compact('patientDetails','labReports'));
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
        //dd($documentItemId);
        $documentItem = null;
        $contents = null;
        $path = null;
        $documentName = null;

        try
        {
            $documentItem = $this->labService->downloadPatientDocument($documentItemId);
            //dd($documentItem);
            if(!empty($documentItem))
            {
                $downloadFileName = $documentItem[0]->document_path;

                /*
                echo $path = storage_path($downloadFileName);
                return response()->download($path);
                */

                //$path =  Config::get('constants.DOCTOR_EMPANEL_URL') .'/' .$downloadFileName;
                $path = storage_path('app').'/' .$downloadFileName;
                $file = Storage::disk('local')->get($downloadFileName);
                $contents = Crypt::decrypt($file);

                //$documentName = $documentItem[0]->test_category_name.'-'.$documentItem[0]->document_name.'.'.pathinfo($path, PATHINFO_EXTENSION);
                $documentName = $documentItem[0]->document_name.' '.$documentItem[0]->document_upload_date.'.'.pathinfo($path, PATHINFO_EXTENSION);
            }

        }
        catch(LabException $userExc)
        {
            //dd($userExc);
            $errorMsg = $userExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($userExc);
            Log::error($msg);
            //return redirect('exception')->with('message',$errorMsg." ".trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message',trans('messages.SupportTeam'));
        }

        return response()->make($contents, 200, array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $documentName . '"'
        ));

        /*$documentName = $documentItem[0]->test_category_name.'-'.$documentItem[0]->document_name.'.'.pathinfo($path, PATHINFO_EXTENSION);
        return response()->make($contents, 200, array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $documentName . '"'
        ));*/


        /*
        return response()->make($contents, 200, array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . pathinfo($path, PATHINFO_BASENAME) . '"'
        ));
        */

    }


    public function getLabTestUploadForLab($labTestId)
    {
        //dd('Inside prescription details');
        return view('portal.lab-labtest-upload',compact('labTestId'));
    }

    public function getLabTestUploadSaveForLab(LabReportRequest $labTestUpload)
    {
        //dd($labTestUpload->input('labTestId'));
        //dd('Inside lab upload details');
        $labTestId = $labTestUpload->input('labTestId');
        $file = $labTestUpload->file('labtest_report');
        //dd($file);
        //Display File Name
        echo 'File Name: '.$file->getClientOriginalName();
        echo '<br>';

        //Display File Extension
        echo 'File Extension: '.$file->getClientOriginalExtension();
        echo '<br>';

        //Display File Real Path
        echo 'File Real Path: '.$file->getRealPath();
        echo '<br>';

        //Display File Size
        echo 'File Size: '.$file->getSize();
        echo '<br>';

        //Display File Mime Type
        echo 'File Mime Type: '.$file->getMimeType();

        //Move Uploaded File
        $destinationPath = 'uploads/'.$labTestId;
        $file->move($destinationPath,$file->getClientOriginalName());


        $domain = "ec2-50-112-212-39.us-west-2.compute.amazonaws.com";

        $LabTestDetails = LabTestDetails::find($labTestId);
        //dd($LabTestDetails);
        $LabTestDetails->labtest_report = $domain.'/'.$destinationPath.'/'.$file->getClientOriginalName();

        $LabTestDetails->save();

        $msg = "Lab Report Upload.";
        return redirect('lab/rest/api/lab/23')->with('message',$msg);
       // return view('portal.lab-labtest-upload',compact('labTestId'));
    }


    public function PatientDetailsForLab($lid,$hid,$patientId)
    {
        $patientDetails = null;
        $patientPrescriptions = null;
        $labTests = null;
        //$jsonResponse = null;
        //dd('Inside patient details');
        try
        {
            //$patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointments($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointmentsByHospital($patientId, $hid);
            //dd($patientDetails);
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-details',compact('patientDetails','labTests'));

    }


    public function PatientLabDetailsForLab($lid,$hid,$patientId)
    {
        $patientDetails = null;
        $patientPrescriptions = null;
        $labTests = null;
        $patientAppointment = null;
        //$jsonResponse = null;
        //dd('Inside patient details');
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientExaminations = HospitalServiceFacade::getExaminationDates($patientId, $hid);
            //dd($patientExaminations);
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-details',compact('patientExaminations','patientDetails'));

    }


    public function PatientLabReportUploadForLab($lid,$hid,$patientId)
    {
        $patientDetails = null;
        $patientPrescriptions = null;
        $labTests = null;
        $patientAppointment = null;
        //$jsonResponse = null;
        //dd('Inside patient details');
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientExaminations = HospitalServiceFacade::getExaminationDates($patientId, $hid);
            //dd($patientExaminations);
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-report-upload',compact('patientDetails'));

    }

    /**
     * Save blood test results
     * @param $testRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    //public function saveBloodTestResults()
    public function saveBloodTestResults(Request $testRequest)
    {
        $patientBloodVM = null;
        $status = true;

        try
        {
            //dd($testRequest);

            /*$bloodResults = array(
                "patientId"=> 57,
                "testResults" => array(
                    0=>array(
                        "examinationId" => 98,
                        "examinationValue" => "120"
                    ),
                    1=>array(
                        "examinationId" => 100,
                        "examinationValue" => "Sugar"
                    )
                )
            );*/
            //dd($bloodTestRequest);
            //dd($testRequest);
            $patientBloodVM = LabMapper::setLabTestMapper($testRequest);
            //dd($patientBloodVM->getPatientId());
            $status = $this->labService->saveBloodTestResults($patientBloodVM);

            //dd($status);
            //lab/4/hospital/1/patient/317/lab-details
            if($status)
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_SUCCESS));
            }
            else
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_ERROR));
            }
        }
        catch(LabException $labExc)
        {
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }

    /**
     * Save motion test results
     * @param $testRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveMotionTestResults(Request $testRequest)
    {
        $patientMotionVM = null;
        $status = true;

        try
        {
            //dd($bloodTestRequest);
            $patientMotionVM = LabMapper::setLabTestMapper($testRequest);
            //dd($patientBloodVM);
            $status = $this->labService->saveMotionTestResults($patientMotionVM);

            //dd($status);

            if($status)
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#motion')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_SUCCESS));
            }
            else
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#motion')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_ERROR));
            }
        }
        catch(LabException $labExc)
        {
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }

    /**
     * Save urine test results
     * @param $testRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveUrineTestResults(Request $testRequest)
    {
        $patientUrineVM = null;
        $status = true;

        try
        {
            //dd($bloodTestRequest);
            $patientUrineVM = LabMapper::setLabTestMapper($testRequest);
            //dd($patientBloodVM);
            $status = $this->labService->saveUrineTestResults($patientUrineVM);

            //dd($status);

            if($status)
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_SUCCESS));
            }
            else
            {
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$testRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_TEST_RESULTS_ERROR));
            }
        }
        catch(LabException $labExc)
        {
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }

    /**
     * Save ultrasound test results
     * @param $testRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveUltrasoundTestResults(Request $testRequest)
    {
        $patientUltrasoundVM = null;
        $status = true;

        try
        {
            //dd($bloodTestRequest);
            $patientUltrasoundVM = LabMapper::setLabTestMapper($testRequest);
            //dd($patientBloodVM);
            $status = $this->labService->saveUltrasoundTestResults($patientUltrasoundVM);

            //dd($status);

            if($status)
            {

            }
        }
        catch(LabException $labExc)
        {
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }

    /**
     * Save scan test results
     * @param $testRequest
     * @throws $labException
     * @return true | false
     * @author Baskar
     */

    public function saveScanTestResults(Request $testRequest)
    {
        $patientScanVM = null;
        $status = true;

        try
        {
            //dd($bloodTestRequest);
            $patientScanVM = LabMapper::setLabTestMapper($testRequest);
            //dd($patientBloodVM);
            $status = $this->labService->saveUltrasoundTestResults($patientScanVM);

            //dd($status);

            if($status)
            {

            }
        }
        catch(LabException $labExc)
        {
            $errorMsg = $labExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($labExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }

    /**
     * Shows hospital lab detail results
     * @param $lid,$hid, $patientId
     * @throws $HospitalException
     * @return view->portal.lab-patient-lab-results page
     * @author Ramana
     */


    /*RAMANA 19-01-2018*/
    public function PatientLabDetailsResultsByHospitalForLab($lid,$hid, $patientId)
    {
        $patientDetails = null;
        $patientPrescriptions = null;
        $labTests = null;
        $patientAppointment = null;
        //$jsonResponse = null;
        //dd('Inside patient details');
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientExaminations = HospitalServiceFacade::getExaminationDates($patientId, $hid);
            //dd($patientExaminations);
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }


        return view('portal.lab-patient-lab-results', compact('patientExaminations', 'patientDetails'));

    }

    /**
     * Shows hospital,doctors,specialities in lab portal
     * @param $hospitalId
     * @throws $HospitalException
     * @return view->portal.lab-addpatientwithappointment page
     * @author Ramana
     */

    /*Ramana New 20-01-2018*/

    public function addPatientWithAppointmentByHospitalForLab($hospitalId)
    {
       // dd('HI');
        $patients = null;
        try
        {
            $patients = HospitalServiceFacade::getPatientsByHospital($hospitalId, $keyword = null);
            $doctors = HospitalServiceFacade::getDoctorsByHospitalId($hospitalId);
            $specialties = HospitalServiceFacade::getAllSpecialties();

      //dd($specialties);
        }
        catch(HospitalException $hospitalExc)
        {
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);

            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-addpatientwithappointment',compact('patients','doctors','specialties'));
    }
    /**
     * save patient book appointment in lab portal
     * @param PatientProfileWebRequest
     * @throws $HospitalException
     * @return true|false
     * @author Ramana
     */

    public function savePatientWithAppointmentByHospitalForLab(PatientProfileWebRequest $patientProfileRequest)
    {
       // dd('HI');
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        //$jsonResponse = null;
        $msg = null;
        //return $patientProfileRequest->all();

        try
        {

            //dd('hi');
            //$patient_photo = \Input::file('patient_photo');
            if(Input::hasFile('patient_photo'))
            {
                $destinationPath = 'uploads/patient_photo'; // upload path
                $extension = Input::file('patient_photo')->getClientOriginalExtension(); // getting file extension
                //$fileName = rand(11111, 99999) . '.' . $extension; // renameing image
                $fileName = $patientProfileRequest->name.'_'.time() . '.' . $extension; // renameing image
                $upload_success = Input::file('patient_photo')->move($destinationPath, $fileName); // uploading file to given path
                $fileLocation = $destinationPath.'/'.$fileName;

                //$patientProfileRequest->patientPhoto = $fileName;
                //$patientProfileRequest['patientPhoto'] = $fileName;
                $patientProfileRequest['patientPhoto'] = $fileLocation;
               // dd($patientProfileRequest);
            }
            else
            {
                //$patientProfileRequest->patientPhoto = "";
                $patientProfileRequest['patientPhoto'] = "";
            }
            //dd($patientProfileVM);
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
             //dd($patientProfileVM);
            $status = HospitalServiceFacade::savePatientProfile($patientProfileVM);
//dd($status);
            if($status['status'])
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Profile Added Successfully.";
                $tokenId=$status['tokenId'];
                $pid=$status['pid'];
                return redirect('lab/rest/api/'.Session::get('LoginUserHospital').'/addpatientwithappointment')->with('success',$msg)->with('tokenId',$tokenId)->with('pid',$pid);
            }
            else
            {
                $msg = "Patient Details Invalid / Incorrect! Try Again.";
                return redirect('lab/rest/api/'.Session::get('LoginUserHospital').'/addpatientwithappointment')->with('message',$msg)->with('tokenId',"")->with('pid',"");
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            //return $jsonResponse;
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        //return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatientwithappointment')->with('message',$msg);

        //$msg = "Patient Details Invalid / Incorrect! Try Again.";
        //return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatientwithappointment')->with('message',$msg);
        //return $jsonResponse;

    }

    /**
     * to Add patient blood test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-blood"  page
     * @author Ramana
     */

    public function AddPatientLabBloodTestsByHospitalForLab($hid,$patientId)
    {
        $patientDetails = null;
        $patientBloodTests = null;
        try
        {

             //dd($patientId.$hid);
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientBloodTests =HospitalServiceFacade::getAllBloodTests();

            //dd($patientBloodTests);

            //$patientBloodTests = DB::select('select * from blood_examination where status = ?', [1]);
            //dd($blood_examination);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-blood',compact('patientBloodTests','patientDetails','hid'));

    }

    /**
     * to Add patient Motion test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-motion"  page
     * @author Ramana
     */
    public function AddPatientLabMotionTestsByHospitalForLab($hid,$patientId)
    {
        $patientDetails = null;
        $patientMotionTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientMotionTests = DB::select('select * from motion_examination where status = ?', [1]);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-motion',compact('patientMotionTests','patientDetails','hid'));

    }

    /**
     * to Add patient urine test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-urine"  page
     * @author Ramana
     */

    public function AddPatientLabUrineTestsByHospitalForLab($hid,$patientId)
    {
        $patientDetails = null;
        $patientUrineTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientUrineTests = HospitalServiceFacade::getAllUrineTests();

            //$patientUrineTests = DB::select('select * from urine_examination where status = ?', [1]);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-urine',compact('patientUrineTests','patientDetails','hid'));

    }

    /**
     * to Add patient ultrasound test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-ultrasound"  page
     * @author Ramana
     */


    public function AddPatientLabUltraSoundTestsByHospitalForLab($hid,$patientId)
    {
        $patientDetails = null;
        $patientUltraSoundTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientUltraSoundTests = DB::select('select * from ultra_sound where status = ?', [1]);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.hospital-patient-lab-add-ultrasound',compact('patientUltraSoundTests','patientDetails','hid'));

    }

    /**
     * to Add patient scan test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-scan"  page
     * @author Ramana
     */

    public function AddPatientLabScanTestsByHospitalForLab($hid,$patientId)
    {
        $patientDetails = null;
        $patientBloodTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientScans = DB::select('select * from scans where status = ?', [1]);
            //dd($blood_examination);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-scan',compact('patientScans','patientDetails','hid'));

    }

    /**
     * to Add patient dental test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-dental"  page
     * @author Ramana
     */
    public function addPatientDentalTestsForLab($hid, $patientId)
    {
        $patientDetails = null;
        $dentalExaminations = null;
        $dentalExaminationCategory = null;
        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $dentalExaminations = HospitalServiceFacade::getAllDentalItems();

            foreach($dentalExaminations as $dentalExamination)
            {
                $dentalExaminationCategory[$dentalExamination->category_id] = $dentalExamination->category_name;
            }
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-dental',compact('dentalExaminationCategory','dentalExaminations','patientDetails','hid'));

    }
    /**
     * to Add patient xray test in lab
     * @param $hid,$patientId
     * @throws $HospitalException
     * @return "lab-patient-lab-add-xray"  page
     * @author Ramana
     */
    public function addPatientXrayTestsForLab($hid, $patientId)
    {
        $patientDetails = null;
        $xrayExaminations = null;
        $xrayExaminationCategory = null;
        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $xrayExaminations =HospitalServiceFacade::getAllXRayItems();
//dd($xrayExaminations);
            foreach($xrayExaminations as $xrayExamination)
            {
                $xrayExaminationCategory[$xrayExamination->category_id] = $xrayExamination->category_name;
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.lab-patient-lab-add-xray',compact('xrayExaminationCategory','xrayExaminations','patientDetails','hid'));

    }
    /**
     * Save patient patient blood examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientBloodTests(Request $examinationRequest)
    {
        $patientBloodVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientBloodVM = PatientProfileMapper::setPatientBloodExamination($examinationRequest);

            //$examinations = $patientBloodVM->getExaminations();

            //dd($patientBloodVM);

           // dd($patientMotionVM);
            $status = HospitalServiceFacade::savePatientBloodTests($patientBloodVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details');
    }



    /**
     * Save patient motion examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientMotionTests(Request $examinationRequest)
    {
        $patientMotionVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientMotionVM = PatientProfileMapper::setPatientMotionExamination($examinationRequest);
            //dd($patientMotionVM);
            $status = HospitalServiceFacade::savePatientMotionTests($patientMotionVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#motion')->with('success',trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#blood');
    }

    /**
     * Save patient ultra sound details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientUltraSoundTests(Request $examinationRequest)
    {
        dd($examinationRequest);
        $patientUltraSoundVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientUltraSoundVM = PatientProfileMapper::setPatientUltraSoundExamination($examinationRequest);
            dd($patientUltraSoundVM);
            $status = HospitalServiceFacade::savePatientUltraSoundTests($patientUltraSoundVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#ultra')->with('success',trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#ultra')->with('success',trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#ultra');
    }

    /**
     * Save patient urine examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientUrineTests(Request $examinationRequest)
    {
        $patientUrineVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientUrineVM = PatientProfileMapper::setPatientUrineExamination($examinationRequest);
            //dd($patientHistoryVM);
            $status =HospitalServiceFacade::savePatientUrineTests($patientUrineVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$examinationRequest->patientId.'/lab-details#urine');
    }

    /**
     * Save patient scan details
     * @param $scanRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientScanDetails(Request $scanRequest)
    {
        //dd($scanRequest);
        $patientScanVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientScanVM = PatientProfileMapper::setPatientScanDetails($scanRequest);
            //dd($patientScanVM);
            $status =HospitalServiceFacade::savePatientScanDetails($patientScanVM);


            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$scanRequest->patientId.'/lab-details#scan')->with('success',trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$scanRequest->patientId.'/lab-details#scan')->with('success',trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
            }
            /*
                if($status)
                {
                    $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_SUCCESS));
                    $responseJson->sendSuccessResponse();
                    return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$scanRequest->patientId.'/medical-details#scan')->with('success',trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_SUCCESS));
                }
                else
                {
                    $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
                    $responseJson->sendSuccessResponse();
                    return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$scanRequest->patientId.'/medical-details#scan')->with('success',trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
                }
            */
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;


        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$scanRequest->patientId.'/add-lab-scan');

    }
    /**
     * Save patient XRAY tests
     * @param $xrayRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientXRayTests(Request $xrayRequest)
    {
        $patientXRayVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($xrayRequest);
            //dd($personalHistoryRequest->all());
            $patientXRayVM = PatientProfileMapper::setPatientXRayExamination($xrayRequest);
            //dd($patientMotionVM);
            $status = HospitalServiceFacade::savePatientXRayTests($patientXRayVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$xrayRequest->patientId.'/lab-details#xray')->with('success',trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$xrayRequest->patientId.'/lab-details#xray')->with('success',trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
            }


            /*
            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
            */
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_XRAY_TESTS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$xrayRequest->patientId.'/add-lab-xray');
    }

    /**
     * Save patient dental tests
     * @param $dentalRequest
     * @throws $hospitalException
     * @return true | false
     * @author Ramana
     */

    public function savePatientDentalTests(Request $dentalRequest)
    {
        //dd($dentalRequest);
        $patientDentalVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientDentalVM = PatientProfileMapper::setPatientDentalExamination($dentalRequest);
            //dd($patientDentalVM);
            $status =HospitalServiceFacade::savePatientDentalTests($patientDentalVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$dentalRequest->patientId.'/lab-details#dental')->with('success',trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_SUCCESS));

            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$dentalRequest->patientId.'/lab-details#dental')->with('success',trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR));

            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DENTAL_TESTS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('lab/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patient/'.$dentalRequest->patientId.'/add-lab-dental');
    }

    /**
     * to get lab test details receipt in lab
     * @param $hid, $patientId, Request $receiptRequest
     * @throws $hospitalException
     * @return "portal.lab-patient-receipt-details" page
     * @author Ramana
     */



    public function getLabTestDetailsForReceipt($hid, $patientId, Request $receiptRequest)
    {
        $labTestDetails = null;
        $generatedDate = null;

       // dd($receiptRequest);

        try
        {
            //dd($hid);
            //$hospitalId = $receiptRequest->get('hospitalId');
            $hospitalId = $hid;

            if($receiptRequest->has('generatedDate'))
            {
                $generatedDate = $receiptRequest->get('generatedDate');
            }

            $labTestDetails =HospitalServiceFacade::getLabTestDetailsForReceipt($patientId, $hospitalId, $generatedDate);
           // dd($labTestDetails);
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

          //  dd($labTestDetails);
            return view('portal.lab-patient-receipt-details', compact('labTestDetails','patientDetails'));

        }
        catch(HospitalException $hospitalExc)
        {
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            //return redirect('exception')->with('message', $errorMsg . " " . trans('messages.SupportTeam'));
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //return redirect('exception')->with('message', trans('messages.SupportTeam'));
        }
    }

    /**
     * to Save lab receipt details  in lab
     * @param $labReceiptRequest
     * @throws $hospitalException
     * @return "portal.lab-patient-receipt-details" page
     * @author Ramana
     */

    public function saveLabReceiptDetailsForPatient(Request $labReceiptRequest)
    {
        //dd('Hi');
        $labReceiptsVM = null;
        $status = true;
        //dd($labReceiptRequest);
        try
        {

            /*
            $labTestsPayments = array(
                'patientId' => 57,
                'hospitalId' => 1,
                'labTests' => array('bloodTests' =>
                    array(
                        array('id' => 3, 'fees' => 500),
                        array('id' => 4, 'fees' => 800)
                    ),
                    'urineTests' =>
                    array(
                        array('id' => 19, 'fees' => 1000),
                        array('id' => 20, 'fees' => 200)
                    ),
                    'motionTests' =>
                    array(
                        array('id' => 3, 'fees' => 200),
                        array('id' => 4, 'fees' => 300)
                    ),
                    'scanTests' =>
                        array(
                            array('id' => 3, 'fees' => 200),
                            array('id' => 4, 'fees' => 300)
                    ),
                    'ultraSoundTests' =>
                        array(
                            array('id' => 3, 'fees' => 200),
                            array('id' => 4, 'fees' => 300)
                    ),
                    'dentalTests' =>
                        array(
                            array('id' => 3, 'fees' => 200),
                            array('id' => 4, 'fees' => 300)
                    ),
                )
                );
            */


            /*$labTestsPayments = array(
                'patientId' => 57,
                'hospitalId' => 1,
                'labTests' => array('dentalTests' =>
                    array(
                        array('id' => 1, 'item_id' => 1, 'fees' => 8000),
                        array('id' => 1, 'item_id' => 2, 'fees' => 9000)
                        )
                    )
                );*/

            /*$labTestsPayments = array(
                'patientId' => 57,
                'hospitalId' => 1,
                'labTests' => array('xrayTests' =>
                    array(
                        array('id' => 1, 'item_id' => 1, 'fees' => 8000),
                        array('id' => 1, 'item_id' => 2, 'fees' => 9000)
                        )
                    )
                );*/

            $labTestsPayments = $labReceiptRequest;
            //dd($labTestsPayments);
            $labReceiptsVM = PatientProfileMapper::setPatientLabReceipts($labTestsPayments);
            //dd($labReceiptsVM);
            $status = HospitalServiceFacade::saveLabReceiptDetailsForPatient($labReceiptsVM);
            //dd($status);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Fees Details Updated Successfully.";
                return redirect('lab/'.Session::get('LoginUserHospital').'/patient/'.$labReceiptRequest['patientId'].'/labtestreceipts')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Fess Details Invalid / Incorrect! Try Again.";
                return redirect('lab/'.Session::get('LoginUserHospital').'/patient/'.$labReceiptRequest['patientId'].'/labtestreceipts')->with('message',$msg);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }
    }
    /**
     * Gets Latest TokenId of patient for doctor appointment
     * @param $hospitalId,$doctorId
     * @throws $hospitalException
     * @return count|0
     * @author Prasanth
     */
    public function getTokenIdByHospitalIdandDoctorId($hospitalId,$doctorId){

        $TokenID = null;
        //$jsonResponse = null;
        $responseJson = null;
        $count = 0;
        try
        {
            $TokenID = HospitalServiceFacade::getTokenIdByHospitalIdandDoctorId($hospitalId,$doctorId);


         //  dd($TokenID);
          //  $responseJson->setObj($TokenID);
           // $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR));
            /*$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);*/
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            /*$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);*/
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $TokenID;
    }

}
