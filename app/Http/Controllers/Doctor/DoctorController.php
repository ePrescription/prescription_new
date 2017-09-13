<?php

namespace App\Http\Controllers\Doctor;

use App\prescription\common\ResponseJson;
use App\prescription\common\ResponsePrescription;
use App\prescription\common\UserSession;
use App\prescription\facades\HospitalServiceFacade;
use App\prescription\mapper\PatientProfileMapper;
use App\prescription\utilities\ErrorEnum\ErrorEnum;
use App\prescription\utilities\Exception\UserNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\prescription\services\HelperService;
use App\prescription\services\HospitalService;
use App\prescription\utilities\Exception\HospitalException;
use App\prescription\utilities\Exception\AppendMessage;
use App\prescription\utilities\UserType;
use App\prescription\mapper\PatientPrescriptionMapper;

use App\prescription\model\entities\HospitalDoctor;

use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\PatientProfileRequest;
use App\Http\Requests\EditPatientProfileRequest;
use App\Http\Requests\NewAppointmentRequest;
use App\Http\Requests\FeeReceiptRequest;

use App\prescription\mapper\HospitalMapper;

use Log;
use Input;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;

use Mail;
use GuzzleHttp\Client;

use App\Http\ViewModels\PatientPrescriptionViewModel;

use Softon\Indipay\Facades\Indipay;


class DoctorController extends Controller
{
    protected $hospitalService;

    public function __construct(HospitalService $hospitalService) {
        $this->hospitalService = $hospitalService;
    }

    /**
     * Get list of hospitals
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitals()
    {
        $hospitals = null;
        $responseJson = null;
        //$result = array();

        try
        {
            //$hospitals = HospitalServiceFacade::getHospitals();
            $hospitals = $this->hospitalService->getHospitals();

            if(!empty($hospitals))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_LIST_SUCCESS));
                $responseJson->setCount(sizeof($hospitals));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_HOSPITAL_LIST_FOUND));
            }

            $responseJson->setObj($hospitals);
            $responseJson->sendSuccessResponse();
            //return $prescriptionResult;
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
            /*$errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);//*/
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$msg = AppendMessage::appendGeneralException($exc);
            //Log::error($msg);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of hospitals by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalByKeyword($keyword = null)
    {
        $hospitals = null;
        //$prescriptionResult = null;
        $responseJson = null;

        try
        {
            //dd('Inside doctor');
            //$hospitals = HospitalServiceFacade::getHospitals();
            $hospitals = $this->hospitalService->getHospitals();

            if(!empty($hospitals))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_LIST_SUCCESS));
                $responseJson->setCount(sizeof($hospitals));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_HOSPITAL_LIST_FOUND));
            }

            $responseJson->setObj($hospitals);
            $responseJson->sendSuccessResponse();
            //$prescriptionResult = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_LIST_SUCCESS));
            //$prescriptionResult->setObj($hospitals);

            //dd($prescriptionResult);
        }
        catch(HospitalException $hospitalExc)
        {
            //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
            /*$errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);*/
        }
        catch(Exception $exc)
        {
            //dd($exc);
            /*$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);*/
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of doctors for the hospital
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorsByHospitalId($hospitalId)
    {
        $doctors = null;
        //$jsonResponse = null;
        $responseJson = null;
        $count = 0;

        try
        {
            $doctors = $this->hospitalService->getDoctorsByHospitalId($hospitalId);

            if(!empty($doctors))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_SUCCESS));
                $responseJson->setCount(sizeof($doctors));
                /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_SUCCESS));
                $jsonResponse->setObj($doctors);*/
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            }

            //$responseJson->setCount($count);
            $responseJson->setObj($doctors);
            $responseJson->sendSuccessResponse();

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
        return $responseJson;
    }

    /**
     * Get list of hospitals for the doctor
     * @param $email
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalsForDoctor(Request $request)
    {
        $hospitals = null;
        $email = $request->get('email');
        //$jsonResponse = null;
        $responseJson = null;
        //$count = 0;

        try
        {
            $hospitals = $this->hospitalService->getHospitalsForDoctor($email);

            if(!empty($hospitals))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_LIST_SUCCESS));
                $responseJson->setCount(sizeof($hospitals));
                /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_SUCCESS));
                $jsonResponse->setObj($doctors);*/
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_HOSPITALS_FOUND));
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            }

            //$responseJson->setCount($count);
            $responseJson->setObj($hospitals);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }


    //Get Appointment details

    /**
     * Get list of appointments for the hospital and the doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId)
    {
        $appointments = null;
        //$jsonResponse = null;
        $responseJson = null;

        try
        {
            //$appointments = HospitalServiceFacade::getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId);
            $appointments = $this->hospitalService->getAppointmentsByHospitalAndDoctor($hospitalId, $doctorId);

            if(!empty($appointments))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($appointments));
                /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_DOCTOR_LIST_SUCCESS));
                $jsonResponse->setObj($doctors);*/
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_APPOINTMENT_LIST_FOUND));
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            }

            $responseJson->setObj($appointments);
            $responseJson->sendSuccessResponse();

            //dd($prescriptionResult);
        }
        catch(HospitalException $hospitalExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_ERROR));
            /*$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);*/
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            /*$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);*/
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::APPOINTMENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    //Get Patient List
    /**
     * Get list of patients for the hospital and patient name
     * @param $hospitalId, $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientsByHospital($hospitalId, Request $patientRequest)
    {
        $patients = null;
        $responseJson = null;
        //$jsonResponse = null;
        $keyword = $patientRequest->get('keyword');
        //dd('Inside patients by hospital');
        try
        {
            $patients = $this->hospitalService->getPatientsByHospital($hospitalId, $keyword);

            if(!empty($patients))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patients));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_FOUND));
            }

            $responseJson->setObj($patients);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient details by patient id
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDetailsById($patientId)
    {
        $patientDetails = null;
        $responseJson = null;
        //$jsonResponse = null;

        //dd('Inside patient details '.$patientId);
        try
        {
            //$patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $patientDetails = $this->hospitalService->getPatientDetailsById($patientId);

            if(!empty($patientDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($patientDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_DETAILS_FOUND));
            }

            $responseJson->setObj($patientDetails);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Login using Email, password and hospital
     * @param $loginRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    //public function login()
    //public function login(Request $loginRequest)
    public function login(DoctorLoginRequest $loginRequest)
    {
        //dd('Test');
        $loginInfo = $loginRequest->all();
        $jsonResponse = null;
        $doctorDetails = null;
        $responseJson = null;
        //$userSession = null;

        try
        {
           /* $loginDetails['doctor']['id'] = 1;
            $loginDetails['doctor']['name'] = 'Baskar';

            $jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::USER_LOGIN_SUCCESS));
            $jsonResponse->setObj($loginDetails);*/

            if (Auth::attempt(['email' => $loginInfo['email'], 'password' => $loginInfo['password']]))
            {
                if(( Auth::user()->hasRole('doctor')) &&  (Auth::user()->delete_status == 1))
                {
                    $userSession = new UserSession();
                    $userSession->setLoginUserId(Auth::user()->id);
                    $userSession->setDisplayName(ucfirst(Auth::user()->name));
                    $userSession->setLoginUserType(UserType::USERTYPE_DOCTOR);
                    $userSession->setAuthDisplayName(ucfirst(Auth::user()->name));

                    Session::put('loggedUser', $userSession);

                    $userId = Auth::user()->id;
                    $userName = ucfirst(Auth::user()->name);

                    $doctorDetails = HospitalServiceFacade::getDoctorDetails($userId);
                    $hospitals = $this->hospitalService->getHospitalsByDoctorId($userId);

                    /*$loginDetails['doctor']['id'] = $userId;
                    $loginDetails['doctor']['name'] = $userName;
                    //$loginDetails['doctor']['details'] = "MBBS MD (Cardiology) 10 years";
                    $loginDetails['doctor']['details'] = $doctorDetails;*/

                    //$details = (object)$doctorDetails;

                    $loginDetails['id'] = $userId;
                    $loginDetails['name'] = $userName;
                    $loginDetails['department'] = $doctorDetails[0]->department;
                    $loginDetails['designation'] = $doctorDetails[0]->designation;
                    $loginDetails['hospitals'] = $hospitals;
                    //$loginDetails['dept'] = $doctorDetails[0]->doctorId;
                    //$doctorDetails['department'] =
                    //$loginDetails['department'] = $doctorDetails['department'];
                    //dd($doctorDetails->department);
                    //$loginDetails['department'] = $doctorDetails['details'];

                    $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::USER_LOGIN_SUCCESS));
                    $responseJson->setCount(sizeof($doctorDetails));
                    $responseJson->setObj($loginDetails);
                    $responseJson->sendSuccessResponse();

                    /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::USER_LOGIN_SUCCESS));
                    $jsonResponse->setObj($loginDetails);*/

                }
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
                $responseJson->sendSuccessResponse();
                //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
                //$msg = "Login Details Incorrect! Try Again.";
                //return redirect('hospital/login')->with('message',$msg);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of hospitals for the doctor
     * @param $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getHospitalsByDoctorId($doctorId)
    {
        $hospitals = null;
        $responseJson = null;
        //$jsonResponse =
        //dd($doctorId);

        //dd('Inside patient details '.$patientId);
        try
        {
            //$patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $hospitals = $this->hospitalService->getHospitalsByDoctorId($doctorId);
            //dd($hospitals);

            if(!empty($hospitals))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_LIST_SUCCESS));
                $responseJson->setCount(sizeof($hospitals));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_HOSPITALS_FOUND));
            }

            $responseJson->setObj($hospitals);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }


    public function doctorloginform()
    {
        //dd('HI');
        $feeReceiptDetails = null;
        $responseJson = null;
        $hospitals = null;

        try
        {
            $hospitals = $this->hospitalService->getHospitals();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            //$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            //$responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            //$responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return view('portal.doctor-login',compact('hospitals'));
        //return $responseJson;
    }

    public function doctorlogin(DoctorLoginRequest $loginRequest)
    {
        //dd('Test');
        $loginInfo = $loginRequest->all();
        //dd($loginInfo);
        //dd($loginInfo);
        //$userSession = null;

        try
        {
            if (Auth::attempt(['email' => $loginInfo['email'], 'password' => $loginInfo['password']]))
            {
                //dd(Auth::user());

                /*
                $userSession = new UserSession();
                $userSession->setLoginUserId(Auth::user()->id);
                $userSession->setDisplayName(ucfirst(Auth::user()->name));
                $userSession->setLoginUserType(UserType::USERTYPE_DOCTOR);
                $userSession->setAuthDisplayName(ucfirst(Auth::user()->name));

                Session::put('loggedUser', $userSession);
                */
                //dd(Auth::user());
                $DisplayName=Session::put('DisplayName', ucfirst(Auth::user()->name));
                $LoginUserId=Session::put('LoginUserId', Auth::user()->id);
                $DisplayName=Session::put('DisplayName', ucfirst(Auth::user()->name));
                $AuthDisplayName=Session::put('AuthDisplayName', ucfirst(Auth::user()->name));
                $AuthDisplayPhoto=Session::put('AuthDisplayPhoto', "no-image.jpg");


                if( Auth::user()->hasRole('doctor')  && (Auth::user()->delete_status==1) )
                {
                    $LoginUserType=Session::put('LoginUserType', 'doctor');

                    $doctorid = Auth::user()->id;
                    //dd($doctorid);
                    //$hospitalId = HospitalServiceFacade::getHospitalId(UserType::USERTYPE_DOCTOR, $doctorid);
                    //dd($hospitalId);

                    Session::put('LoginUserHospital', $loginInfo['hospital']);

                    $hospitalInfo = HospitalServiceFacade::getProfile($loginInfo['hospital']);
                    //dd($hospitalInfo);
                    Session::put('LoginHospitalDetails', $hospitalInfo[0]->hospital_name.' '.$hospitalInfo[0]->address);

                    $doctorInfo = HospitalServiceFacade::getDoctorDetails($doctorid);
                    //dd($doctorInfo);
                    Session::put('LoginDoctorDetails', $doctorInfo[0]->doctorDetails);

                    return redirect('doctor/'.Auth::user()->id.'/dashboard');
                }
                else
                {
                    Auth::logout();
                    Session::flush();
                    $msg="Login Details Incorrect! Please try Again.";
                    return redirect('/doctor/login')->with('message',$msg);
                }

                //return redirect('hospital/login')->with('message',$msg);

            }
            else
            {
                //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
                $msg = "Login Details Incorrect! Try Again.";
                return redirect('/login')->with('message',$msg);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd("1");
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }
        catch(Exception $exc)
        {
            //dd("2".$exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }

    }

    public function getDoctorDetails($doctorId)
    {
        $doctorDetails = null;
        //$jsonResponse = null;
        $responseJson = null;
        //dd($doctorId);

        try
        {
            //$doctorDetails = HospitalServiceFacade::getDoctorDetails($doctorId);
            $doctorDetails = $this->hospitalService->getDoctorDetails($doctorId);
            //dd($doctorDetails);

            if(!empty($doctorDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::DOCTOR_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($doctorDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_DOCTOR_DETAILS_FOUND));
            }

            $responseJson->setObj($doctorDetails);
            $responseJson->sendSuccessResponse();


            /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::DOCTOR_DETAILS_SUCCESS));
            $jsonResponse->setObj($doctorDetails);*/
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    //Get Patient Profile
    /**
     * Get patient profile by patient id
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientProfile($patientId)
    {
        $patientProfile = null;
        $responseJson = null;

        try
        {
            //$patientProfile = HospitalServiceFacade::getPatientProfile($patientId);
            $patientProfile = $this->hospitalService->getPatientProfile($patientId);

            if(!empty($patientProfile))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SUCCESS));
                $responseJson->setCount(sizeof($patientProfile));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_PROFILE_FOUND));
            }

            $responseJson->setObj($patientProfile);
            $responseJson->sendSuccessResponse();
            //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SUCCESS));
            //$jsonResponse->setObj($patientProfile);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    //Get Prescription List
    /**
     * Get list of prescriptions for the selected hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */
    public function getPrescriptions($hospitalId, $doctorId)
    {
        $prescriptions = null;
        $responseJson = null;
        //$jsonResponse = null;
        try
        {
            //$prescriptions = HospitalServiceFacade::getPrescriptions($hospitalId, $doctorId);
            $prescriptions = $this->hospitalService->getPrescriptions($hospitalId, $doctorId);

            if(!empty($prescriptions))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_SUCCESS));
                $responseJson->setCount(sizeof($prescriptions));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PRESCRIPTION_LIST_FOUND));
            }

            $responseJson->setObj($prescriptions);
            $responseJson->sendSuccessResponse();


            /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_SUCCESS));
            $jsonResponse->setObj($prescriptions);*/
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);

        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    /**
     * Get list of prescriptions for the patient
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptionByPatient($patientId)
    {
        $prescriptions = null;
        $responseJson = null;
        $responseJson = null;
        //$jsonResponse = null;

        try
        {
            //$prescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            $prescriptions = $this->hospitalService->getPrescriptionByPatient($patientId);

            if(!empty($prescriptions))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_SUCCESS));
                $responseJson->setCount(sizeof($prescriptions));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PRESCRIPTION_LIST_FOUND));
            }

            $responseJson->setObj($prescriptions);
            $responseJson->sendSuccessResponse();

            /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_SUCCESS));
            $jsonResponse->setObj($prescriptions);*/
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    /**
     * Get prescription details for the patient by prescription Id
     * @param $prescriptionId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptionDetails($prescriptionId)
    {
        $prescriptionDetails = null;
        $responseJson = null;
        //$jsonResponse = null;

        try
        {
            //$prescriptionDetails = HospitalServiceFacade::getPrescriptionDetails($prescriptionId);
            $prescriptionDetails = $this->hospitalService->getPrescriptionDetails($prescriptionId);

            if(!empty($prescriptionDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($prescriptionDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::NO_PRESCRIPTION_DETAILS_FOUND));
            }

            $responseJson->setObj($prescriptionDetails);
            $responseJson->sendSuccessResponse();

            /*$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SUCCESS));
            $jsonResponse->setObj($prescriptionDetails);*/
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    /**
     * Check if a patient is a new patient or follow up patient
     * @param $hospitalId, $doctorId, $patientId
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function checkIsNewPatient(Request $newPatientRequest)
    {
        $responseJson = null;
        $jsonResponse = null;

        $hospitalId = $newPatientRequest->get('hospital');
        $doctorId = $newPatientRequest->get('doctor');
        $patientId = $newPatientRequest->get('patient');

        //dd('Hospital Id'.' '.$hospitalId.' Patient Id'.' '.$patientId. ' DoctorId'.' '.$doctorId);

        $isNewPatient = null;

        try
        {
            //$isNewPatient = HospitalServiceFacade::checkIsNewPatient($hospitalId, $doctorId, $patientId);
            $isNewPatient = $this->hospitalService->checkIsNewPatient($hospitalId, $doctorId, $patientId);

            $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS);
            $responseJson->setObj($isNewPatient);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::NEW_PATIENT_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::NEW_PATIENT_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        //return $jsonResponse;
        return $responseJson;
    }

    /**
     * Get prescription details for the patient by prescription Id
     * @param $prescriptionId, $email, $mobile
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPrescriptionDetailsForMail($prescriptionId, $email, $mobile)
    {
        $prescriptionDetails = null;
        $responseJson = null;
        //dd('Inside prescription details');

        try
        {
            //$prescriptionDetails = HospitalServiceFacade::getPrescriptionDetails($prescriptionId);
            $prescriptionDetails = $this->hospitalService->getPrescriptionDetails($prescriptionId);

            if(!empty($prescriptionDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($prescriptionDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PRESCRIPTION_DETAILS_FOUND));
            }

            $responseJson->setObj($prescriptionDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get lab details for the patient by lab Id
     * @param $labId, $email, $mobile
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabDetailsForMail($labId, $email, $mobile)
    {
        $labDetails = null;
        $responseJson = null;
        //dd('Inside prescription details');

        try
        {
            //$labDetails = HospitalServiceFacade::getLabTestDetails($labId);
            $labDetails = $this->hospitalService->getLabTestDetails($labId);

            if(!empty($labDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($labDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_LAB_DETAILS_FOUND));
            }

            $responseJson->setObj($labDetails);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendErrorResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient profile
     * @param $patientProfileRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    //public function savePatientProfile(Request $patientProfileRequest)
    public function savePatientProfile(PatientProfileRequest $patientProfileRequest)
    {
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $responseJson = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = $this->hospitalService->savePatientProfile($patientProfileVM);

            //$status = HospitalServiceFacade::savePatientProfile($patientProfileVM);
            //$patient = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        /*catch(UserNotFoundException $userExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$userExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($userExc);
        }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient profile
     * @param $patientProfileRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    //public function savePatientProfile(Request $patientProfileRequest)
    public function editPatientProfile(EditPatientProfileRequest $patientProfileRequest)
    {
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $responseJson = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = $this->hospitalService->savePatientProfile($patientProfileVM);

            //$status = HospitalServiceFacade::savePatientProfile($patientProfileVM);
            //$patient = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        /*catch(UserNotFoundException $userExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$userExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($userExc);
        }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save new appointment for the patient
     * @param $patientProfileRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    /**
     * Save Prescription for the patient
     * @param
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPrescription(Request $patientPrescriptionRequest)
    {
        $patientPrescriptionVM = null;
        $status = true;
        $responseJson = null;
        //$string = ""

        try
        {
            $patientPrescriptionVM = PatientPrescriptionMapper::setPrescriptionDetails($patientPrescriptionRequest);
            //$status = HospitalServiceFacade::savePatientPrescription($patientPrescriptionVM);
            $status = $this->hospitalService->savePatientPrescription($patientPrescriptionVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }

            //return $patientPrescriptionVM
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
            //return $jsonResponse;
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    //Search by Patient Name
    /**
     * Get patient names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByName(Request $patientNameRequest)
    {
        $patientNames = null;
        $responseJson = null;

        $keyword = $patientNameRequest->get('name');
        //return $keyword;

        try
        {
            //$patientNames = HospitalServiceFacade::searchPatientByName($keyword);
            $patientNames = $this->hospitalService->searchPatientByName($keyword);

            if(!empty($patientNames))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patientNames));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_FOUND));
            }

            $responseJson->setObj($patientNames);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    //Search by Patient Pid
    /**
     * Get patient details by PID
     * @param $pid
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    //public function searchPatientByPid($pid)
    public function searchPatientByPid(Request $patientPidRequest)
    {
        $patient = null;
        $responseJson = null;
        //$pid = \Input::get('pid');
        $pid = $patientPidRequest->get('pid');
        //return $pid;
        try
        {
            //$patient = HospitalServiceFacade::searchPatientByPid($pid);
            $patient = $this->hospitalService->searchPatientByPid($pid);

            if(!empty($patient))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patient));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_FOUND));
            }

            $responseJson->setObj($patient);
            $responseJson->sendSuccessResponse();
            //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
            //$jsonResponse->setObj($patient);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient by Pid or Name
     * @param $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchByPatientByPidOrName(Request $patientSearchRequest)
    {
        $patient = null;
        $responseJson = null;
        //$pid = \Input::get('pid');
        $keyword = $patientSearchRequest->get('keyword');

        try
        {
            //$patient = HospitalServiceFacade::searchByPatientByPidOrName($keyword);
            $patient = $this->hospitalService->searchByPatientByPidOrName($keyword);

            if(!empty($patient))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patient));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_FOUND));
            }

            $responseJson->setObj($patient);
            $responseJson->sendSuccessResponse();


        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient by Name for the hospital
     * @param $keyword, $patientRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function searchPatientByHospitalAndName($hospitalId, Request $patientRequest)
    {
        $patients = null;
        $responseJson = null;
        //$pid = \Input::get('pid');
        $keyword = $patientRequest->get('keyword');

        try
        {
            //$patient = HospitalServiceFacade::searchByPatientByPidOrName($keyword);
            $patients = $this->hospitalService->searchPatientByHospitalAndName($hospitalId, $keyword);

            if(!empty($patients))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patients));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_LIST_FOUND));
            }

            $responseJson->setObj($patients);
            $responseJson->sendSuccessResponse();


        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    //Drugs
    /**
     * Get brand names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getTradeNames(Request $brandRequest)
    {
        $brands = null;
        $responseJson = null;
        //$keyword = \Input::get('keyword');
        $keyword = $brandRequest->get('brands');
        //$keyword = $brandRequest->get('keyword');
        //$keyword = $brandRequest->all();

        try
        {
            //$brands = HospitalServiceFacade::getBrandNames($keyword);
            $brands = $this->hospitalService->getTradeNames($keyword);

            if(!empty($brands))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::BRAND_LIST_SUCCESS));
                $responseJson->setCount(sizeof($brands));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_BRAND_LIST_FOUND));
            }

            $responseJson->setObj($brands);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::BRAND_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::BRAND_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get formulation names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFormulationNames(Request $formulationRequest)
    {
        $formulations = null;
        $responseJson = null;
        //$keyword = \Input::get('keyword');
        $keyword = $formulationRequest->get('formulations');

        try
        {
            //$brands = HospitalServiceFacade::getBrandNames($keyword);
            $formulations = $this->hospitalService->getFormulationNames($keyword);

            if(!empty($formulations))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FORMULATION_LIST_SUCCESS));
                $responseJson->setCount(sizeof($formulations));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_FORMULATION_LIST_FOUND));
            }

            $responseJson->setObj($formulations);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FORMULATION_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FORMULATION_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    //Lab Tests
    /**
     * Get all lab tests
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTests(Request $labRequest)
    {
        $labTests = null;
        $responseJson = null;

        try
        {
            //$labTests = HospitalServiceFacade::getLabTests();
            $keyword = $labRequest->get('labtests');

            $labTests = $this->hospitalService->getLabTests($keyword);

            if(!empty($labTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_LIST_SUCCESS));
                $responseJson->setCount(sizeof($labTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            }

            $responseJson->setObj($labTests);
            $responseJson->sendSuccessResponse();

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of lab tests for the selected hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsForPatient($hospitalId, $doctorId)
    {
        $patientLabTests = null;
        $responseJson = null;
        //$jsonResponse = null;
        //dd('Inside prescriptions');
        try
        {
            //$patientLabTests = HospitalServiceFacade::getLabTestsForPatient($hospitalId, $doctorId);
            $patientLabTests = $this->hospitalService->getLabTestsForPatient($hospitalId, $doctorId);

            if(!empty($patientLabTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patientLabTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_LABTEST_FOUND));
            }

            $responseJson->setObj($patientLabTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of labtests for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestsByPatient($patientId)
    {
        $patientLabTests = null;
        //dd('Inside Lab test for patient');
        $responseJson = null;
        //dd('Inside prescriptions');
        try
        {
            //$patientLabTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            $patientLabTests = $this->hospitalService->getLabTestsByPatient($patientId);

            if(!empty($patientLabTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patientLabTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_LABTEST_FOUND));
            }

            $responseJson->setObj($patientLabTests);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get lab test details for the given lab test id
     * @param $labTestId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetails($labTestId)
    {
        $labTestDetails = null;
        $responseJson = null;
        //dd('Inside labtest details');

        try
        {
            //$labTestDetails = HospitalServiceFacade::getLabTestDetails($labTestId);
            $labTestDetails = $this->hospitalService->getLabTestDetails($labTestId);
            //dd($labTestDetails);

            if(!empty($labTestDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LAB_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($labTestDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::NO_LAB_DETAILS_FOUND));
            }

            $responseJson->setObj($labTestDetails);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LAB_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save new appointments for the patient
     * @param $patientLabTestRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    //public function saveNewAppointment(Request $appointmentRequest)
    public function saveNewAppointment(NewAppointmentRequest $appointmentRequest)
    //public function saveNewAppointment(Request $appointmentRequest)
    {
        $appointmentsVM = null;
        $status = true;
        $responseJson = null;
        try
        {
            $appointmentsVM = PatientProfileMapper::setPatientAppointment($appointmentRequest);
            //$status = HospitalServiceFacade::saveNewAppointment($appointmentsVM);
            $status = $this->hospitalService->saveNewAppointment($appointmentsVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_NEW_APPOINTMENT_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_NEW_APPOINTMENT_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_NEW_APPOINTMENT_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save labtests for the patient
     * @param $patientLabTestRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientLabTests(Request $patientLabTestRequest)
    {
        $patientLabTestVM = null;
        $status = true;
        $responseJson = null;
        //$string = ""

        try
        {
            $patientLabTestVM = PatientPrescriptionMapper::setLabTestDetails($patientLabTestRequest);
            //$status = HospitalServiceFacade::savePatientLabTests($patientLabTestVM);
            $status = $this->hospitalService->savePatientLabTests($patientLabTestVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::LABTESTS_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LABTESTS_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }

        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LABTESTS_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
            //return $jsonResponse;
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::LABTESTS_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }


    /**
     * Web Login using Email, password and hospital
     * @param $loginRequest
     * @throws $hospitalException
     * @return array | null
     * @author Vimal
     */

    public function userlogin(Request $loginRequest)
    {
        $loginInfo = $loginRequest->all();
        //dd($loginInfo);
        //$userSession = null;

        try
        {
            if (Auth::attempt(['email' => $loginInfo['email'], 'password' => $loginInfo['password']]))
            {
                //dd(Auth::user());

                /*
                $userSession = new UserSession();
                $userSession->setLoginUserId(Auth::user()->id);
                $userSession->setDisplayName(ucfirst(Auth::user()->name));
                $userSession->setLoginUserType(UserType::USERTYPE_DOCTOR);
                $userSession->setAuthDisplayName(ucfirst(Auth::user()->name));

                Session::put('loggedUser', $userSession);
                */
                //dd(Auth::user());
                $DisplayName=Session::put('DisplayName', ucfirst(Auth::user()->name));
                $LoginUserId=Session::put('LoginUserId', Auth::user()->id);
                $DisplayName=Session::put('DisplayName', ucfirst(Auth::user()->name));
                $AuthDisplayName=Session::put('AuthDisplayName', ucfirst(Auth::user()->name));
                $AuthDisplayPhoto=Session::put('AuthDisplayPhoto', "no-image.jpg");

                if(( Auth::user()->hasRole('hospital')) &&  (Auth::user()->delete_status==1) )
                    {
                        $LoginUserType=Session::put('LoginUserType', 'hospital');

                        $hospitalInfo = HospitalServiceFacade::getProfile(Auth::user()->id);

                        Session::put('LoginHospitalDetails', $hospitalInfo[0]->hospital_name.' '.$hospitalInfo[0]->address);

                        //$hospitalId = HospitalServiceFacade::getHospitalId(UserType::USERTYPE_DOCTOR, $doctorid);

                        return redirect('fronthospital/'.Auth::user()->id.'/dashboard');
                    }
                    else if( Auth::user()->hasRole('doctor')  && (Auth::user()->delete_status==1) )
                    {
                        //Auth::logout();
                        //Session::flush();
                        //$msg="Login Details Incorrect! Please try Again. OR Missing Hospital Details";
                        //return redirect('/doctor/login')->with('message',$msg);

                        //dd('ISSUES');

                        $LoginUserType=Session::put('LoginUserType', 'doctor');

                        $doctorid = Auth::user()->id;
                        //dd($doctorid);

                        $hospitalsInfo = HospitalServiceFacade::getHospitalsByDoctorId($doctorid);
                        //dd($hospitalsInfo);
                        Session::put('LoginUserHospitals',$hospitalsInfo);

                        Session::put('LoginUserHospital', '');
                        Session::put('LoginHospitalDetails', '');
                        /*
                        $hospitalId = HospitalServiceFacade::getHospitalId(UserType::USERTYPE_DOCTOR, $doctorid);
                        //dd($hospitalId);
                        Session::put('LoginUserHospital', $hospitalId[0]->hospital_id);

                        $hospitalInfo = HospitalServiceFacade::getProfile($hospitalId[0]->hospital_id);
                        //dd($hospitalInfo);
                        Session::put('LoginHospitalDetails', $hospitalInfo[0]->hospital_name.' '.$hospitalInfo[0]->address);
                        */
                        $doctorInfo = HospitalServiceFacade::getDoctorDetails($doctorid);
                        //dd($doctorInfo);
                        Session::put('LoginDoctorDetails', $doctorInfo[0]->doctorDetails);
//dd('CIU');
                        return redirect('doctor/'.Auth::user()->id.'/dashboard');
                    }
                    else if( Auth::user()->hasRole('patient') && (Auth::user()->delete_status==1) )
                    {
                        $LoginUserType=Session::put('LoginUserType', 'patient');
                        return redirect('patient/'.Auth::user()->id.'/dashboard');
                    }
                    else if( Auth::user()->hasRole('lab') && (Auth::user()->delete_status==1) )
                    {
                        $LoginUserType=Session::put('LoginUserType', 'lab');
                        //dd($LoginUserType);
                        //GET LAB HOSTPIALID BY LABID
                        $labid = Auth::user()->id;
                        $hospitalId = HospitalServiceFacade::getHospitalId(UserType::USERTYPE_LAB, $labid);

                        Session::put('LoginUserHospital', $hospitalId[0]->hospital_id);
                        return redirect('lab/'.Auth::user()->id.'/dashboard');
                    }
                    else if( Auth::user()->hasRole('pharmacy') && (Auth::user()->delete_status==1) )
                    {
                        $LoginUserType=Session::put('LoginUserType', 'pharmacy');

                        //GET PHARMACY HOSTPIALID BY PHARMACYID
                        $phid = Auth::user()->id;
                        $hospitalId = HospitalServiceFacade::getHospitalId(UserType::USERTYPE_PHARMACY, $phid);
                        //dd($hospitalId[0]->hospital_id);
                        Session::put('LoginUserHospital', $hospitalId[0]->hospital_id);
                        return redirect('pharmacy/'.Auth::user()->id.'/dashboard');
                    }
                    else if(Auth::user()->hasRole('admin'))
                    {
                        $LoginUserType=Session::put('LoginUserType', 'admin');
                        return redirect('admin/'.Auth::user()->id.'/dashboard');
                    }
                    /*else if(Auth::user()->hasRole('fronthospital'))
                    {
                        $LoginUserType=Session::put('LoginUserType', 'admin');
                        return redirect('admin/'.Auth::user()->id.'/dashboard');
                    }*/
                    else
                    {
                        Auth::logout();
                        Session::flush();
                        $msg="Login Details Incorrect! Please try Again.";
                        return redirect('/login')->with('message',$msg);
                    }

                    //return redirect('hospital/login')->with('message',$msg);

            }
            else
            {
                //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
                $msg = "Login Details Incorrect! Try Again.";
                return redirect('/login')->with('message',$msg);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd("1");
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            $prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }
        catch(Exception $exc)
        {
            //dd("2".$exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            $prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }

    }

    public function getPatientsByHospitalForFront($hospitalId, Request $patientRequest)
    {
        //dd('HI');
        $patients = null;
        $keyword = $patientRequest->get('keyword');

        try
        {
            $patients = HospitalServiceFacade::getPatientsByHospital($hospitalId, $keyword);
            //dd($patients);
            //return json_encode('test');

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

        return view('portal.hospital-patients',compact('patients'));
    }


//VIMAL

    public function getProfile($hospitalId)
    {
        $hospitalProfile = null;
        //dd('Inside get profile function in pharmacy controller');

        try
        {
            $hospitalProfile = $this->hospitalService->getProfile($hospitalId);
            //dd($hospitalProfile);
        }
        catch(HospitalException $profileExc)
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

        return view('portal.hospital-profile',compact('hospitalProfile'));

        //return $pharmacyProfile;
    }

    /**
     * Get all specialties
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getAllSpecialties()
    {
        //dd('HI');
        $specialties = null;

        try
        {
            $specialties = $this->hospitalService->getAllSpecialties();

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

        //return view('portal.hospital-patients',compact('patients'));
        return $specialties;
    }

    public function editProfile($hospitalId, HelperService $helperService)
    {
        $hospitalProfile = null;
        //dd('Inside get profile function in pharmacy controller');

        try
        {
            $hospitalProfile = $this->hospitalService->getProfile($hospitalId);
            //dd($hospitalProfile);
            $cities = $helperService->getCities();
            //dd($cities);
        }
        catch(HospitalException $profileExc)
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

        return view('portal.hospital-editprofile',compact('hospitalProfile','cities'));

        //return $pharmacyProfile;
    }


    public function editHospital(Request $hospitalRequest)
    {


        //$pharmacyVM = null;
        //$status = true;
        //$string = ""
        //dd($pharmacyRequest);
        try
        {
            $hospitalId = Auth::user()->id;
            $hospitalProfile = $this->hospitalService->getProfile($hospitalId);
            $message= "Profile Details Updated Successfully";


            /*$hospitalVM = HospitalMapper::setPhamarcyDetails($hospitalRequest);
            //dd($pharmacyVM);
            $status = $this->pharmacyService->editPharmacy($pharmacyVM);
            //dd($status);

            /*if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_SUCCESS));
            }*/

            /*if($status) {
                $pharmacyId=$pharmacyVM->getPharmacyId();
                //dd($pharmacyId);
                $pharmacyProfile = $this->pharmacyService->getProfile($pharmacyId);
                $message= "Profile Details Updated Successfully";
            }*/

        }
        catch(HospitalException $profileExc)
        {
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

        return view('portal.hospital-profile',compact('hospitalProfile','message'));
        // dd($pharmacyProfile);
        //return view('portal.pharmacy-profile',compact('pharmacyProfile','message'));

        //return $jsonResponse;
    }


    public function editChangePassword($pharmacyId)
    {
        $pharmacyProfile = null;
        //dd('Inside get profile function in pharmacy controller');

        try
        {
            //$pharmacyProfile = $this->pharmacyService->getProfile($pharmacyId);
            //dd($pharmacyProfile);
        }
        catch(HospitalException $profileExc)
        {
            ////dd($hospitalExc);
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

        return view('portal.hospital-changepassword');

        //return $pharmacyProfile;
    }


    public function addPatientsByHospitalForFront($hospitalId)
    {
        //dd('HI');
        $patients = null;
        try
        {
            //$patients = HospitalServiceFacade::getPatientsByHospital($hospitalId);

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

        return view('portal.hospital-addpatient');
    }


    public function savePatientsByHospitalForFront(Request $patientProfileRequest)
    {
        //dd('HI');
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $jsonResponse = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Profile Added Successfully.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Details Invalid / Incorrect! Try Again.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
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

        $msg = "Patient Details Invalid / Incorrect! Try Again.";
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
        //return $jsonResponse;

    }


    public function addPatientWithAppointmentByHospitalForFront($hospitalId)
    {
        //dd('HI');
        $patients = null;
        try
        {
            $patients = HospitalServiceFacade::getPatientsByHospital($hospitalId, $keyword = null);
            $doctors = HospitalServiceFacade::getDoctorsByHospitalId($hospitalId);
            $specialties = HospitalServiceFacade::getAllSpecialties();

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

        return view('portal.hospital-addpatientwithappointment',compact('patients','doctors','specialties'));
    }


    public function savePatientWithAppointmentByHospitalForFront(Request $patientProfileRequest)
    {
        //dd('HI');
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $jsonResponse = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Profile Added Successfully.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Details Invalid / Incorrect! Try Again.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
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

        $msg = "Patient Details Invalid / Incorrect! Try Again.";
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
        //return $jsonResponse;

    }



    public function addAppointmentByHospitalForFront($hospitalId,$patientId)
    {
        //dd('HI');
        $doctors = null;
        $patientProfile = null;
        try
        {
            //dd($patientId);
            $doctors = HospitalServiceFacade::getDoctorsByHospitalId($hospitalId);
            //$patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $patientProfile = HospitalServiceFacade::getPatientProfile($patientId);
            //dd($doctors);
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

            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.hospital-addappointment',compact('doctors','patientProfile'));
    }


    public function saveAppointmentByHospitalForFront(Request $appointmentRequest)
    //public function saveAppointmentByHospitalForFront(NewAppointmentRequest $appointmentRequest)
    {
        //dd($appointmentRequest);
        $appointmentsVM = null;
        $status = true;
        $jsonResponse = null;

        try
        {
            $appointmentsVM = PatientProfileMapper::setPatientAppointment($appointmentRequest);
            $status = HospitalServiceFacade::saveNewAppointment($appointmentsVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Appointment Added Successfully.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$appointmentRequest->patientId.'/completeappointment')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Appointment Details Invalid / Incorrect! Try Again.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$appointmentRequest->patientId.'/completeappointment')->with('message',$msg);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
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

        $msg = "Patient Appointment Details Invalid / Incorrect! Try Again.";
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patients')->with('message',$msg);
        //return $jsonResponse;

    }

    public function completeAppointmentByHospitalForFront($hospitalId,$patientId)
    {
        //dd('HI');
        $doctors = null;
        $patientProfile = null;
        try
        {
            //dd($patientId);
            $doctors = HospitalServiceFacade::getDoctorsByHospitalId($hospitalId);
            //$patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $patientProfile = HospitalServiceFacade::getPatientProfile($patientId);
            //dd($doctors);
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

            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }

        return view('portal.hospital-completeappointment',compact('doctors','patientProfile'));
    }

    public function getPatientsByDoctorForFront($doctorId, $hospitalId, Request $doctorRequest)
    {
        //dd('HI');
        $patients = null;
        //$keyword = $doctorRequest->get('keyword');

        try
        {
            //$hospitalInfo = HospitalDoctor::where('doctor_id','=',$doctorId)->first();
            //$hospitalId=$hospitalInfo['hospital_id'];

            //dd($hospitalId);
            $patients = HospitalServiceFacade::getPatientsByHospitalAndDoctor($hospitalId, $doctorId);

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

        return view('portal.doctor-patients',compact('patients'));
    }

    public function getPatientAllDetails($patientId)
    {
        $patientDetails = null;
        $patientPrescriptions = null;
        $labTests = null;
        //$jsonResponse = null;
        //dd('Inside patient details');
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientDetailsById($patientId);
            $patientPrescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            $labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
        }
        catch(HospitalException $hospitalExc)
        {
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

        //Modify to return to the appropriate view
        return 'test';
        //return $jsonResponse;
    }

    /**
     * Get patient appointments
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientAppointments($patientId)
    {
        $appointments = null;
        //dd($patientId);

        try
        {
            $appointments = HospitalServiceFacade::getPatientAppointments($patientId);
            //dd($appointments);
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

        return $appointments;
    }

    public function sendEmail(Request $mailRequest)
    {
        //dd($mailRequest);

        $title = $mailRequest->input('title');
        $content = $mailRequest->input('content');

        $data = array('name' => "Learning laravel", 'title' => $title, 'content' => $content);

        //return response()->json($title);

        try
        {

            Mail::send('emails.send', $data, function ($m) {
                $m->from('info@daiwiksoft.com', 'Learning Laravel');
                //$m->to('baskar2271@yahoo.com')->subject('Learning laravel test mail');
                $m->to('baskar2271@yahoo.com')->subject('Learning laravel test mail');
            });
        }
        catch(Exception $exc)
        {
            return response()->json(['message' => $exc->getMessage()]);
        }

        return response()->json(['message' => 'Request completed']);
    }

    /**
     * Get the doctor names for the hospital
     * @param $hospitalId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getDoctorNames($hospitalId, Request $nameRequest)
    {
        $doctorNames = null;
        $responseJson = null;
        //dd('HI');
        $keyword = $nameRequest->get('keyword');
        //dd($keyword);
        //return $keyword;
        try
        {
            //$patientNames = HospitalServiceFacade::searchPatientByName($keyword);
            $doctorNames = $this->hospitalService->getDoctorNames($hospitalId, $keyword);
            //dd($doctorNames);

            if(!empty($doctorNames))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::DOCTOR_NAME_SUCCESS));
                $responseJson->setCount(sizeof($doctorNames));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            }

            $responseJson->setObj($doctorNames);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get patient names by keyword
     * @param $keyword
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientNames($hospitalId, Request $nameRequest)
    {
        $patientNames = null;
        $responseJson = null;

        $keyword = $nameRequest->get('keyword');
        //dd($keyword);
        //return $keyword;
        try
        {
            //$patientNames = HospitalServiceFacade::searchPatientByName($keyword);
            $patientNames = $this->hospitalService->getPatientNames($hospitalId, $keyword);
            //dd($patientNames);

            if(!empty($patientNames))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patientNames));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            }

            $responseJson->setObj($patientNames);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }


    public function getPatientNamesForHospital($hospitalId, Request $nameRequest)
    {
        $patientNames = null;
        $responseJson = null;

        $keyword = $nameRequest->get('query');


        $data = '{"query": '.$keyword.',"suggestions": ["United Arab Emirates", "United Kingdom", "United States"]}';
        return $data;
        //dd($keyword);
        //return $keyword;
        try
        {
            //$patientNames = HospitalServiceFacade::searchPatientByName($keyword);
            $patientNames = $this->hospitalService->getPatientNames($hospitalId, $keyword);
            //dd($patientNames);

            if(!empty($patientNames))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($patientNames));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            }

            $responseJson->setObj($patientNames);
            $responseJson->sendSuccessResponse();
            //dd($jsonResponse);
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }
    public function PatientDetailsByHospitalForFront($hid,$patientId)
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
            $patientPrescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            $labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointments($patientId);
            $patientAppointment = HospitalServiceFacade::getPatientAppointmentsByHospital($patientId, $hid);
            //dd($patientAppointment);
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

        return view('portal.hospital-patient-details',compact('patientDetails','patientPrescriptions','labTests','patientAppointment'));

    }

    public function PatientEditByHospitalForFront($hid,$patientId)
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
            //$patientPrescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            //$labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointments($patientId);
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

        return view('portal.hospital-patient-edit',compact('patientDetails'));

    }

    public function updatePatientsByHospitalForFront(Request $patientProfileRequest)
    {
        //dd('HI');
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $jsonResponse = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Profile Updated Successfully.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patients')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Details Invalid / Incorrect! Try Again.";
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patients')->with('message',$msg);
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

        $msg = "Patient Details Invalid / Incorrect! Try Again.";
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
        //return $jsonResponse;

    }

    //Fee Receipts

    /**
     * Get list of fee receipts for the hospital and doctor
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFeeReceipts($hospitalId, $doctorId)
    {
        $feeReceipts = null;
        $responseJson = null;
        //dd($doctorId);

        try
        {
            $feeReceipts = $this->hospitalService->getFeeReceipts($hospitalId, $doctorId);
            //dd($patientNames);

            if(!empty($feeReceipts))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($feeReceipts));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_FEE_RECEIPT_LIST));
            }

            $responseJson->setObj($feeReceipts);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get list of fee receipts for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getFeeReceiptsByPatient($patientId)
    {
        $feeReceipts = null;
        $responseJson = null;
        //dd($doctorId);

        try
        {
            $feeReceipts = $this->hospitalService->getFeeReceiptsByPatient($patientId);
            //dd($patientNames);

            if(!empty($feeReceipts))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($feeReceipts));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_ERROR));
            }

            $responseJson->setObj($feeReceipts);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get fee receipt details, doctor details, patient details
     * @param $hospitalId, $doctorId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getReceiptDetails($receiptId)
    {
        $feeReceiptDetails = null;
        $responseJson = null;
        //dd($receiptId);

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($patientNames);

            if(!is_null($feeReceiptDetails) && !empty($feeReceiptDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($feeReceiptDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_FEE_RECEIPT_DETAILS_FOUND));
            }

            $responseJson->setObj($feeReceiptDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save fee receipt
     * @param $feeReceiptRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function saveFeeReceipt(FeeReceiptRequest $feeReceiptRequest)
    {
        $feeReceiptVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            $feeReceiptVM = PatientProfileMapper::setFeeReceipt($feeReceiptRequest);
            $status = $this->hospitalService->saveFeeReceipt($feeReceiptVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Forward fee receipt details by SMS
     * @param $receiptId, $mobile
     * @throws HospitalException
     * @return array | null
     * @author Baskar
     */

    public function forwardFeeReceiptBySMS($receiptId, $mobile, Request $request)
    {
        //dd($request['mobile']);
        $mobile=$request['mobile'];
        $feeReceiptDetails = null;
        $responseJson = null;
        $status = true;

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($feeReceiptDetails);

            if(!is_null($feeReceiptDetails) && !empty($feeReceiptDetails))
            {
                $status = $this->sendFeeReceiptAsSMS($feeReceiptDetails, $mobile);
                $msg = "Message Sent Successfully";
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_ERROR));
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            //return $jsonResponse;
            return redirect('fronthospital/rest/api/receipt/'.$receiptId.'/details')->with('message',$msg);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            //$jsonResponse = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PRESCRIPTION_DETAILS_SAVE_ERROR));
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            return redirect('fronthospital/rest/api/receipt/'.$receiptId.'/details')->with('message',$msg);
        }

        //return $responseJson;
        return redirect('fronthospital/rest/api/receipt/'.$receiptId.'/details')->with('success',$msg);
    }

    /**
     * Forward fee receipt details by Email
     * @param $receiptId, $mail
     * @throws HospitalException
     * @return array | null
     * @author Baskar
     */

    public function forwardFeeReceiptApiByMail($receiptId, $email)
    {
        $feeReceiptDetails = null;
        $responseJson = null;
        $status = true;

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($feeReceiptDetails);

            if(!is_null($feeReceiptDetails) && !empty($feeReceiptDetails))
            {
                $subject = "Fee Receipt";
                $name = "ePrescription and Lab Tests Application";
                $title = "Fee Receipt";
                //$content = $prescriptionDetails;
                $to = $email;
                $data = array('name' => $name, 'title' => $title, 'feeReceiptDetails' => $feeReceiptDetails);


                Mail::send('emails.hospital-fee', $data, function ($m) use($to, $subject){
                    //$m->from('prescriptionapp1@gmail.com', $name);
                    //$m->to($to)->subject($subject);
                    $m->from('prescriptionapp1@gmail.com', 'ePrescription and Lab Tests Application');;
                    //$m->to('alagirivimal@gmail.com')->subject('ePrescription and Lab Tests Application');
                    $m->to($to)->subject($subject);
                });

                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEERECEIPT_EMAIL_SUCCESS));
                //$responseJson->setObj("Mail Sent Successfully");
                $responseJson->sendSuccessResponse();

                //dd($responseJson);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEERECEIPT_EMAIL_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEERECEIPT_EMAIL_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
        //return view('portal.patient-labtest-details',compact('prescriptionDetails'));
    }

    /**
     * Forward fee receipt details by Email
     * @param $receiptId, $mail
     * @throws HospitalException
     * @return array | null
     * @author Baskar
     */

    public function forwardFeeReceiptByMail($receiptId, $email, Request $request)
    {
        //dd($request['email']);
        $email=$request['email'];
        $feeReceiptDetails = null;
        $responseJson = null;
        $status = true;
        $msg = null;

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($feeReceiptDetails);

            if(!is_null($feeReceiptDetails) && !empty($feeReceiptDetails))
            {
                $subject = "Fee Receipt";
                $name = "ePrescription and Lab Tests Application";
                $title = "Fee Receipt";
                //$content = $prescriptionDetails;
                $to = $email;
                $data = array('name' => $name, 'title' => $title, 'feeReceiptDetails' => $feeReceiptDetails);

                Mail::send('emails.hospital-fee', $data, function ($m) use($to, $subject){
                    //$m->from('prescriptionapp1@gmail.com', $name);
                    //$m->to($to)->subject($subject);
                    $m->from('prescriptionapp1@gmail.com', 'ePrescription and Lab Tests Application');;
                    //$m->to('alagirivimal@gmail.com')->subject('ePrescription and Lab Tests Application');
                    $m->to($to)->subject($subject);
                });
                $msg = "Message Sent Successfully";
                //dd("EMail Sent");
                //dd($feeReceiptDetails);
            }

        }
        catch(HospitalException $hospitalExc)
        {
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
        }
        catch(Exception $exc)
        {
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
        }


        return redirect('fronthospital/rest/api/receipt/'.$receiptId.'/details')->with('success',$msg);
        //return view('portal.hospital-fee-details');

        //return $responseJson;
        //return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addpatient')->with('message',$msg);
    }

    /**
     * Forward fee receipt details by SMS
     * @param $receiptId, $mobile
     * @throws HospitalException
     * @return array | null
     * @author Baskar
     */

    public function forwardFeeReceiptApiBySMS($receiptId, $mobile)
    {
        $feeReceiptDetails = null;
        $responseJson = null;
        $status = true;

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($feeReceiptDetails);

            if(!is_null($feeReceiptDetails) && !empty($feeReceiptDetails))
            {
                $status = $this->sendFeeReceiptAsSMS($feeReceiptDetails, $mobile);
            }

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEERECEIPT_SMS_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEERECEIPT_SMS_ERROR));
            }

            //$responseJson->setObj($response->getStatusCode());
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $pharmacyExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            $responseJson->sendErrorResponse($pharmacyExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FEE_RECEIPT_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    private function sendFeeReceiptAsSMS($feeReceiptDetails, $mobile)
    {
        $patientName = $feeReceiptDetails['patientDetails']->name;
        $doctorName = $feeReceiptDetails['doctorDetails']->name;
        $hospitalName = $feeReceiptDetails['hospitalDetails']->hospital_name;
        $doctorFee = $feeReceiptDetails['feeDetails']['fee'];
        //dd($doctorFee);
        $feeInWords = $feeReceiptDetails['feeDetails']['inWords'];
        $status = true;

        $message = "Patient Name : ".$patientName."%0a"
            ." Doctor Name: ".$doctorName."%0a"
            ." Hospital Name: ".$hospitalName."%0a"
            ." Received Fee: ".$doctorFee." (In Words ".$feeInWords.") with thanks towards doctor consultation charges"."%0a";

        $client = new Client();
        $response = $client->get('http://bhashsms.com/api/sendmsg.php?user=Daiwiksoft&pass=Daiwik2612&sender=daiwik&phone='.$mobile.'&text='.$message.'&priority=ndnd&stype=normal');

        if($response->getStatusCode() != 200)
        {
            $status = false;
        }

        return $status;
    }


    public function getDoctorsForFront($hospitalId, Request $nameRequest)
    {
        $doctorNames = null;
        $responseJson = null;
        //dd('HI');
        $keyword = $nameRequest->get('keyword');
        //dd($keyword);
        //return $keyword;
        try
        {
            //$patientNames = HospitalServiceFacade::searchPatientByName($keyword);
            $doctors = $this->hospitalService->getDoctorNames($hospitalId, $keyword);
            //dd($doctors);

        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::HOSPITAL_NO_DOCTORS_FOUND));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-doctors',compact('doctors'));
    }


    public function getFeeReceiptsForFront($hospitalId, $doctorId)
    {
        $feeReceipts = null;
        $responseJson = null;
        //dd($doctorId);

        try
        {
            $feeReceipts = $this->hospitalService->getFeeReceipts($hospitalId, $doctorId);
            //dd($feeReceipts);
            /*
            if(!empty($feeReceipts))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_SUCCESS));
                $responseJson->setCount(sizeof($feeReceipts));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::FEE_RECEIPT_LIST_ERROR));
            }

            $responseJson->setObj($feeReceipts);
            $responseJson->sendSuccessResponse();
            */
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

        return view('portal.hospital-doctor-fees',compact('feeReceipts'));
        //return $responseJson;
    }

    public function getReceiptDetailsForFront($receiptId)
    {
        $feeReceiptDetails = null;
        $responseJson = null;
        //dd($receiptId);

        try
        {
            $feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);

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

        return view('portal.hospital-fee-details',compact('feeReceiptDetails','receiptId'));
        //return $responseJson;
    }

    public function addFeeReceiptForFront($hospitalId)
    {
        //dd('HI');
        $feeReceiptDetails = null;
        $responseJson = null;
        //dd($hospitalId);
        $keyword = null;

        try
        {

            $patients = $this->hospitalService->getPatientsByHospital($hospitalId, $keyword);
            //dd($patients);

            $doctors = $this->hospitalService->getDoctorsByHospitalId($hospitalId);
            //dd($doctors);
            //$feeReceiptDetails = $this->hospitalService->getReceiptDetails($receiptId);
            //dd($feeReceiptDetails);

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

        return view('portal.hospital-fee-add',compact('patients','doctors'));
        //return $responseJson;
    }



    public function saveFeeReceiptForFront(FeeReceiptRequest $feeReceiptRequest)
    {
        $feeReceiptVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            $feeReceiptVM = PatientProfileMapper::setFeeReceipt($feeReceiptRequest);
            $status = $this->hospitalService->saveFeeReceipt($feeReceiptVM);
            //dd($status);

            if($status)
            {
                $msg=trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS);

            }
            else
            {
                $msg=trans('messages.'.ErrorEnum::FEE_RECEIPT_SAVE_ERROR);
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addfeereceipt')->with('message',$msg);
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

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/addfeereceipt')->with('success',$msg);

        //return $responseJson;

    }


    public function onlinePayment()
    {

        try
        {


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

        return view('portal.hospital-online-payment');
        //return $responseJson;
    }

    public function processPayment(Request $paymentRequest)
    {
       // dd($paymentRequest->all());

        $parameters = $paymentRequest->all();
        /*
        $parameters = [

            'tid' => '45646489556322',
            'order_id' => '1232212',
            'amount' => '1200.00',
            'firstname' => 'Baskaran',
            'email' => 'baskar2271@yahoo.com',
            'phone' => '9988844455',
            'productinfo' => 'test',
        ];
        */
        //dd($parameters);
        try
        {
            //$order = Indipay::prepare($parameters);
            $order = Indipay::gateway('PayUMoney')->prepare($parameters);
            //dd($order);
            return Indipay::process($order);
            //dd($order);


        }
        catch(Exception $exc)
        {
            //dd($exc);
        }



        //return Indipay::process($order);

    }


    public function successPayment(Request $request)
    {

        try
        {

            // For default Gateway
            $response = Indipay::response($request);

            // For Otherthan Default Gateway
            $response = Indipay::gateway('NameOfGatewayUsedDuringRequest')->response($request);

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

        return view('portal.hospital-online-payment-success',compact('response'));
        //return $responseJson;
    }


    public function failurePayment(Request $request)
    {

        try
        {

            // For default Gateway
            $response = Indipay::response($request);

            // For Otherthan Default Gateway
            $response = Indipay::gateway('NameOfGatewayUsedDuringRequest')->response($request);

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

        //dd($response);
        return view('portal.hospital-online-payment-failure',compact('response'));
        //return $responseJson;
    }


    public function changeHospital(Request $loginRequest)
    {
        $loginInfo = $loginRequest->all();
        //dd($loginInfo['hospital']);
        //$userSession = null;

        try
        {
            if (!empty($loginInfo))
            {

                $hospital_id = $loginInfo['hospital'];
                //dd($hospital_id);
                Session::put('LoginUserHospital', $hospital_id);

                $hospitalInfo = HospitalServiceFacade::getProfile($hospital_id);
                //dd($hospitalInfo);
                Session::put('LoginHospitalDetails', $hospitalInfo[0]->hospital_name.' '.$hospitalInfo[0]->address);

                return redirect('doctor/'.Auth::user()->id.'/dashboard');

            }
            else
            {
                //$prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::DOCTOR_LOGIN_FAILURE));
                $msg = "Please Choose Hospital Details.";
                return redirect('doctor/'.Auth::user()->id.'/dashboard')->with('message',$msg);

            }

        }
        catch(HospitalException $hospitalExc)
        {
            //dd("1");
            $errorMsg = $hospitalExc->getMessageForCode();
            $msg = AppendMessage::appendMessage($hospitalExc);
            Log::error($msg);
            $prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }
        catch(Exception $exc)
        {
            //dd("2".$exc);
            $msg = AppendMessage::appendGeneralException($exc);
            Log::error($msg);
            $prescriptionResult = new ResponseJson(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::FAILURE));
        }

    }

    /*Symptom section -- Begin */

    /**
     * Get all the symptoms
     * @param none
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getMainSymptoms()
    {
        $mainSymptoms = null;
        $responseJson = null;
        //dd('Inside doctor api controller');

        try
        {
            //dd($this->hospitalService);
            $mainSymptoms = $this->hospitalService->getMainSymptoms();

            if(!is_null($mainSymptoms) && !empty($mainSymptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($mainSymptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_MAIN_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($mainSymptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::MAIN_SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get all the sub symptoms for main symptom
     * @param $mainSymptomsId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getSubSymptomsForMainSymptoms($mainSymptomsId)
    {
        $subSymptoms = null;
        $responseJson = null;
        //dd($mainSymptomsId);

        try
        {
            $subSymptoms = $this->hospitalService->getSubSymptomsForMainSymptoms($mainSymptomsId);
            //dd($subSymptoms);

            if(!is_null($subSymptoms) && !empty($subSymptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($subSymptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SUB_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($subSymptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SUB_SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get all the symptoms for sub symptom
     * @param $subSymptomId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getSymptomsForSubSymptoms($subSymptomId)
    {
        $symptoms = null;
        $responseJson = null;
        //dd($subSymptomId);

        try
        {
            $symptoms = $this->hospitalService->getSymptomsForSubSymptoms($subSymptomId);
            //dd($symptoms);

            if(!is_null($symptoms) && !empty($symptoms))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_SUCCESS));
                $responseJson->setCount(sizeof($symptoms));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_SYMPTOMS_LIST_FOUND));
            }

            $responseJson->setObj($symptoms);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::SYMPTOMS_LIST_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Get personal history for the patient
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPersonalHistory($patientId, Request $patientSearchRequest)
    {
        $personalHistoryDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $personalHistoryDate = date('Y-m-d', strtotime($examinationDate));
            $personalHistoryDetails = $this->hospitalService->getPersonalHistory($patientId, $personalHistoryDate);
            //dd($personalHistoryDetails);

            if(!is_null($personalHistoryDetails) && !empty($personalHistoryDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_SUCCESS));
                $responseJson->setCount(sizeof($personalHistoryDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PERSONAL_HISTORY_FOUND));
            }

            $responseJson->setObj($personalHistoryDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PERSONAL_HISTORY_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return view('portal.hospital-patient-medical-personal-illness-detail',compact('personalHistoryDetails'));
    }

    /**
     * Get patient past illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientPastIllness($patientId, Request $patientSearchRequest)
    {
        $pastIllness = null;
        $responseJson = null;

        try
        {
            //dd($patientId);
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $pastIllnessDate = date('Y-m-d', strtotime($examinationDate));
            //dd($generalExaminationDate);
            $pastIllness = $this->hospitalService->getPatientPastIllness($patientId, $pastIllnessDate);
            //dd($pastIllness);

            if(!is_null($pastIllness) && !empty($pastIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($pastIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_PAST_ILLNESS_DETAILS_FOUND));
            }

            $responseJson->setObj($pastIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return view('portal.hospital-patient-medical-past-illness-detail',compact('pastIllness'));
    }

    /**
     * Get patient family illness
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientFamilyIllness($patientId, Request $patientSearchRequest)
    {
        $familyIllness = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $familyIllnessDate = date('Y-m-d', strtotime($examinationDate));
            $familyIllness = $this->hospitalService->getPatientFamilyIllness($patientId, $familyIllnessDate);
            //dd($familyIllness);

            if(!is_null($familyIllness) && !empty($familyIllness))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($familyIllness));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_FAMILY_ILLNESS_DETAILS_FOUND));
            }

            $responseJson->setObj($familyIllness);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-medical-family-illness-detail',compact('familyIllness'));
    }

    /**
     * Get patient general examination
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientGeneralExamination($patientId, Request $patientSearchRequest)
    {
        $generalExamination = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $generalExaminationDate = date('Y-m-d', strtotime($examinationDate));
            $generalExamination = $this->hospitalService->getPatientGeneralExamination($patientId, $generalExaminationDate);
            //dd($generalExamination);

            if(!is_null($generalExamination) && !empty($generalExamination))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($generalExamination));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_GENERAL_EXAMINATION_DETAILS_FOUND));
            }

            $responseJson->setObj($generalExamination);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-medical-general-detail',compact('generalExamination'));
    }

    /**
     * Get patient pregnancy details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPregnancyDetails($patientId, Request $patientSearchRequest)
    {
        $pregnancyDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $pregnancyDate = date('Y-m-d', strtotime($examinationDate));
            $pregnancyDetails = $this->hospitalService->getPregnancyDetails($patientId, $pregnancyDate);
            //dd($familyIllness);

            if(!is_null($pregnancyDetails) && !empty($pregnancyDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($pregnancyDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_PREGNANCY_DETAILS_FOUND));
            }

            $responseJson->setObj($pregnancyDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-medical-pregnancy-detail',compact('pregnancyDetails'));
    }

    /**
     * Get patient scan details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientScanDetails($patientId, Request $patientSearchRequest)
    {
        $scanDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $scanDate = date('Y-m-d', strtotime($examinationDate));
            $scanDetails = $this->hospitalService->getPatientScanDetails($patientId, $scanDate);
            //dd($scanDetails);

            if(!is_null($scanDetails) && !empty($scanDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SCAN_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($scanDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_SCAN_DETAILS_FOUND));
            }

            $responseJson->setObj($scanDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SCAN_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-medical-scan-detail',compact('scanDetails'));

    }

    /**
     * Get patient symptom details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientSymptoms($patientId, Request $patientSearchRequest)
    {
        $symptomDetails = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $symptomDate = date('Y-m-d', strtotime($examinationDate));
            $symptomDetails = $this->hospitalService->getPatientSymptoms($patientId, $symptomDate);
            //dd($familyIllness);

            if(!is_null($symptomDetails) && !empty($symptomDetails))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($symptomDetails));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_SYMPTOM_DETAILS_FOUND));
            }

            $responseJson->setObj($symptomDetails);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-medical-symptom-detail',compact('symptomDetails'));

    }

    /**
     * Get Ajax Sub Symptom details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function ajaxGetSubSymptoms(Request $patientSearchRequest)
    {

        $mainSymptomsId=$patientSearchRequest->get('categoryId');
        $subSymptoms= HospitalServiceFacade::getSubSymptomsForMainSymptoms($mainSymptomsId);

        $OptionHTML = "";
        $OptionHTML .= '<option value="0">Sub Symptom</option>';
        foreach($subSymptoms as $subSymptomValue)
        {
            $OptionHTML .= '<option value="'.$subSymptomValue->id.'">'.$subSymptomValue->sub_symptom_name.'</option>';
        }

        return $OptionHTML;
    }

    /**
     * Get Ajax Sub Symptom details
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function ajaxGetSymptomsName(Request $patientSearchRequest)
    {

        $subSymptomsId = $patientSearchRequest->get('categoryId');
        $symptomsName = HospitalServiceFacade::getSymptomsForSubSymptoms($subSymptomsId);

        $OptionHTML = "";
        $OptionHTML .= '<option value="0">Symptom Name</option>';
        foreach ($symptomsName as $symptomsNameValue) {
            $OptionHTML .= '<option value="' . $symptomsNameValue->id . '">' . $symptomsNameValue->symptom_name . '</option>';
        }

        return $OptionHTML;
    }
        /**
     * Get patient drug history
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientDrugHistory($patientId)
    {
        $drugSurgeryHistory = null;
        $responseJson = null;

        try
        {
            $drugSurgeryHistory = $this->hospitalService->getPatientDrugHistory($patientId);
            //dd($drugSurgeryHistory);

            if(!is_null($drugSurgeryHistory) && !empty($drugSurgeryHistory))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SUCCESS));
                $responseJson->setCount(sizeof($drugSurgeryHistory));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_DRUG_HISTORY_FOUND));
            }

            $responseJson->setObj($drugSurgeryHistory);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return view('portal.hospital-patient-medical-past-drug-detail',compact('drugSurgeryHistory'));

    }

    /**
     * Get patient examination dates
     * @param $patientId
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getExaminationDates($patientId)
    {
        $examinationDates = null;
        $responseJson = null;

        try
        {
            $examinationDates = $this->hospitalService->getExaminationDates($patientId);
            //dd($examinationDates);

            if(!is_null($examinationDates) && !empty($examinationDates))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_SUCCESS));
                $responseJson->setCount(sizeof($examinationDates));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_EXAMINATION_DATES_FOUND));
            }

            $responseJson->setObj($examinationDates);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_EXAMINATION_DATES_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        return $responseJson;
    }

    /**
     * Save patient personal history
     * @param $personalHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePersonalHistory(Request $personalHistoryRequest)
    {
        $patientExaminationVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientHistoryVM = PatientProfileMapper::setPersonalHistory($personalHistoryRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePersonalHistory($patientHistoryVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalHistoryRequest->patientId.'/medical-details#personal')->with('success',trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalHistoryRequest->patientId.'/medical-details#personal')->with('message',trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PERSONAL_HISTORY_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalHistoryRequest->patientId.'/add-medical-personal');


    }

    /**
     * Save patient general examination details
     * @param $personalHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientGeneralExamination(Request $personalExaminationRequest)
    {
        $patientExaminationVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientExaminationVM = PatientProfileMapper::setGeneralExamination($personalExaminationRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientGeneralExamination($patientExaminationVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalExaminationRequest->patientId.'/medical-details#general')->with('success',trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalExaminationRequest->patientId.'/medical-details#general')->with('success',trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_GENERAL_EXAMINATION_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$personalExaminationRequest->patientId.'/add-medical-general');

    }

    /**
     * Save patient past illness details
     * @param $pastIllnessRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPastIllness(Request $pastIllnessRequest)
    {
        //dd($pastIllnessRequest);
        $patientPastIllnessVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientPastIllnessVM = PatientProfileMapper::setPatientPastIllness($pastIllnessRequest);
            //dd($patientPastIllnessVM);
            $status = $this->hospitalService->savePatientPastIllness($patientPastIllnessVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pastIllnessRequest->patientId.'/medical-details#past')->with('success',trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pastIllnessRequest->patientId.'/medical-details#past')->with('success',trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;


        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pastIllnessRequest->patientId.'/add-medical-past');

    }

    /**
     * Save patient family illness details
     * @param $familyIllnessRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientFamilyIllness(Request $familyIllnessRequest)
    {
        //dd($familyIllnessRequest);
        $patientFamilyIllnessVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientFamilyIllnessVM = PatientProfileMapper::setPatientFamilyIllness($familyIllnessRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientFamilyIllness($patientFamilyIllnessVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$familyIllnessRequest->patientId.'/medical-details#family')->with('success',trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$familyIllnessRequest->patientId.'/medical-details#family')->with('success',trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_FAMILY_ILLNESS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$familyIllnessRequest->patientId.'/add-medical-family');

    }


    /**
     * Save patient pregnancy details
     * @param $pregnancyRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientPregnancyDetails(Request $pregnancyRequest)
    {

        //dd($pregnancyRequest->patientId);
        //dd($pregnancyRequest);
        $patientPregnancyVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientPregnancyVM = PatientProfileMapper::setPatientPregnancyDetails($pregnancyRequest);
            //dd($patientPregnancyVM);
            $status = $this->hospitalService->savePatientPregnancyDetails($patientPregnancyVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pregnancyRequest->patientId.'/medical-details#pregnancy')->with('success',trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pregnancyRequest->patientId.'/medical-details#pregnancy')->with('success',trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PREGNANCY_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //dd($responseJson);
        //return $responseJson;

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$pregnancyRequest->patientId.'/add-medical-pregnancy');


    }

    /**
     * Save patient scan details
     * @param $scanRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
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
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientScanDetails($patientScanVM);

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


        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$scanRequest->patientId.'/add-medical-scan');

    }

    /**
     * Save patient symptom details
     * @param $symptomsRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientSymptoms(Request $symptomsRequest)
    {
        $patientSymVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientSymVM = PatientProfileMapper::setPatientSymptomDetails($symptomsRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientSymptoms($patientSymVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$symptomsRequest->patientId.'/medical-details#symptom')->with('success',trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_SUCCESS));

            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$symptomsRequest->patientId.'/medical-details#symptom')->with('success',trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));

            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_SYMPTOM_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$symptomsRequest->patientId.'/add-medical-symptom');

    }



    /**
     * Save patient ultra sound details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientUltraSoundTests(Request $examinationRequest)
    {
        //dd($examinationRequest);
        $patientUltraSoundVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientUltraSoundVM = PatientProfileMapper::setPatientUltraSoundExamination($examinationRequest);
            //dd($patientUltraSoundVM);
            $status = $this->hospitalService->savePatientUltraSoundTests($patientUltraSoundVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#ultra')->with('success',trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#ultra')->with('success',trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_SAVE_ERROR));
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
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#ultra');
    }

    /**
     * Save patient urine examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
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
            $status = $this->hospitalService->savePatientUrineTests($patientUrineVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#urine')->with('success',trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SAVE_ERROR));
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
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#urine');
    }

    /**
     * Save patient motion examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
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
            $status = $this->hospitalService->savePatientMotionTests($patientMotionVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#motion')->with('success',trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#motion')->with('success',trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SAVE_ERROR));
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
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#blood');
    }

    /**
     * Save patient patient blood examination details
     * @param $examinationRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
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
            //dd($patientMotionVM);
            $status = $this->hospitalService->savePatientBloodTests($patientBloodVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details#blood')->with('success',trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$examinationRequest->patientId.'/lab-details');
    }

    /**
     * Save patient drug and surgery history
     * @param $drugHistoryRequest
     * @throws $hospitalException
     * @return true | false
     * @author Baskar
     */

    public function savePatientDrugHistory(Request $drugHistoryRequest)
    {
        $patientDrugsVM = null;
        $status = true;
        $responseJson = null;

        try
        {
            //dd($personalHistoryRequest->all());
            $patientDrugsVM = PatientProfileMapper::setPatientDrugHistory($drugHistoryRequest);
            //dd($patientHistoryVM);
            $status = $this->hospitalService->savePatientDrugHistory($patientDrugsVM);

            if($status)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_SUCCESS));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$drugHistoryRequest->patientId.'/medical-details#drug')->with('success',trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_SUCCESS));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
                $responseJson->sendSuccessResponse();
                return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$drugHistoryRequest->patientId.'/medical-details#drug')->with('success',trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
            }
        }
        catch(HospitalException $hospitalExc)
        {
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
            $responseJson->sendErrorResponse($hospitalExc);
        }
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_DRUG_HISTORY_SAVE_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return redirect('fronthospital/rest/api/'.Auth::user()->id.'/patient/'.$drugHistoryRequest->patientId.'/add-medical-drug');

    }


    /*Symptom section -- End */


    public function PatientMedicalDetailsByHospitalForFront($hid,$patientId)
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
            $patientExaminations = HospitalServiceFacade::getExaminationDates($patientId);


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

        return view('portal.hospital-patient-medical-details',compact('patientExaminations','patientDetails'));

    }

    public function AddPatientMedicalGeneralByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientGeneralExaminations = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientGeneralExaminations = HospitalServiceFacade::getAllGeneralExaminations();
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

        return view('portal.hospital-patient-medical-add-general',compact('patientGeneralExaminations','patientDetails'));

    }

    public function AddPatientMedicalFamilyByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientFamilyIllness = null;
        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientFamilyIllness = HospitalServiceFacade::getAllFamilyIllness();

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

        return view('portal.hospital-patient-medical-add-family-illness',compact('patientFamilyIllness','patientDetails'));

    }

    public function AddPatientMedicalPastByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientPastIllness = null;
        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientPastIllness = HospitalServiceFacade::getAllPastIllness();

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

        return view('portal.hospital-patient-medical-add-past-illness',compact('patientPastIllness','patientDetails'));

    }

    public function AddPatientMedicalPersonalByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientPersonalHistory = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientPersonalHistory = HospitalServiceFacade::getAllPersonalHistory();

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

        return view('portal.hospital-patient-medical-add-personal-illness',compact('patientPersonalHistory','patientDetails'));

    }

    /**
     * Get patient lab tests by hospital and fee status
     * @param $patientId, $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientLabTests($hospitalId, $patientId, Request $labTestRequest)
    {
        $patientLabTests = null;
        $feeStatus = $labTestRequest->get('feeStatus');
        //dd($feeStatus);

        try
        {
            $patientLabTests = $this->hospitalService->getPatientLabTests($hospitalId, $patientId, $feeStatus);
            //dd($patientLabTests);
            //return view('portal.ho-hospitalregister', compact('patientLabTests', 'patientLabTests'));

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
     * Get patient lab test details by patient and labtesttype
     * @param $patientId, $hospitalId, $feeStatus
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getLabTestDetailsByPatient($labTestId, Request $labDetailsRequest)
    {
        $labTestDetails = null;
        $labTestType = $labDetailsRequest->get('testType');
        //dd($labTestType);

        try
        {
            $labTestDetails = $this->hospitalService->getLabTestDetailsByPatient($labTestType, $labTestId);
            dd($labTestDetails);
            //return view('portal.ho-hospitalregister', compact('patientLabTests', 'patientLabTests'));

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

    public function AddPatientMedicalScanByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientScans = null;

        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientScans = HospitalServiceFacade::getAllScans();

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

        return view('portal.hospital-patient-medical-add-scan',compact('patientScans','patientDetails'));

    }

    public function AddPatientMedicalDrugByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;

        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

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

        return view('portal.hospital-patient-medical-add-past-drug',compact('patientDetails'));

    }

    public function AddPatientMedicalPregnancyByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientPregnancyDetails = null;

        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);
            $patientPregnancyDetails = HospitalServiceFacade::getAllPregnancy();
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

        return view('portal.hospital-patient-medical-add-pregnancy',compact('patientDetails','patientPregnancyDetails'));

    }

    public function AddPatientMedicalSymptomByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;

        try
        {

            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $mainSymptoms = HospitalServiceFacade::getMainSymptoms();
            $mainSymptoms_id=0;
            $subSymptoms = HospitalServiceFacade::getSubSymptomsForMainSymptoms($mainSymptoms_id);
            $subSymptoms_id=0;
            $symptomsForSubSymptoms = HospitalServiceFacade::getSymptomsForSubSymptoms($subSymptoms_id);

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

        return view('portal.hospital-patient-medical-add-symptom',compact('patientDetails','mainSymptoms','subSymptoms','symptomsForSubSymptoms'));

    }


    //LAB


    public function PatientLabDetailsByHospitalForFront($hid,$patientId)
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
            $patientExaminations = HospitalServiceFacade::getExaminationDates($patientId);
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

        return view('portal.hospital-patient-lab-details',compact('patientExaminations','patientDetails'));

    }


    public function AddPatientLabBloodTestsByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientBloodTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientBloodTests = DB::select('select * from blood_examination where status = ?', [1]);
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

        return view('portal.hospital-patient-lab-add-blood',compact('patientBloodTests','patientDetails'));

    }


    public function AddPatientLabMotionTestsByHospitalForFront($hid,$patientId)
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

        return view('portal.hospital-patient-lab-add-motion',compact('patientMotionTests','patientDetails'));

    }


    public function AddPatientLabUrineTestsByHospitalForFront($hid,$patientId)
    {
        $patientDetails = null;
        $patientUrineTests = null;
        try
        {
            $patientDetails = HospitalServiceFacade::getPatientProfile($patientId);

            $patientUrineTests = DB::select('select * from urine_examination where status = ?', [1]);

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

        return view('portal.hospital-patient-lab-add-urine',compact('patientUrineTests','patientDetails'));

    }

    public function AddPatientLabUltraSoundTestsByHospitalForFront($hid,$patientId)
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

        return view('portal.hospital-patient-lab-add-ultrasound',compact('patientUltraSoundTests','patientDetails'));

    }


    /**
     * Get patient urine tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUrineTests($patientId, Request $patientSearchRequest)
    {
        $urineTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $urineTests = $this->hospitalService->getPatientUrineTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($urineTests) && !empty($urineTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($urineTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_URINE_DETAILS_FOUND));
            }

            $responseJson->setObj($urineTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_URINE_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-lab-urine-tests-detail',compact('urineTests'));
    }

    /**
     * Get patient motion tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientMotionTests($patientId, Request $patientSearchRequest)
    {
        $motionTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $motionTests = $this->hospitalService->getPatientMotionTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($motionTests) && !empty($motionTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($motionTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_MOTION_DETAILS_FOUND));
            }

            $responseJson->setObj($motionTests);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_MOTION_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-lab-motion-tests-detail',compact('motionTests'));
    }

    /**
     * Get patient blood tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientBloodTests($patientId, Request $patientSearchRequest)
    {
        $bloodTests = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $bloodTests = $this->hospitalService->getPatientBloodTests($patientId, $examinationDate);
            //dd($bloodTests);

            if(!is_null($bloodTests) && !empty($bloodTests))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_SUCCESS));
                $responseJson->setCount(sizeof($bloodTests));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_BLOOD_DETAILS_FOUND));
            }

            //$responseJson->setObj($bloodTests);
            //$responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_BLOOD_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;

        return view('portal.hospital-patient-lab-blood-tests-detail',compact('bloodTests'));
    }

    /**
     * Get patient ultrasound tests
     * @param $patientId, $patientSearchRequest
     * @throws $hospitalException
     * @return array | null
     * @author Baskar
     */

    public function getPatientUltraSoundTests($patientId, Request $patientSearchRequest)
    {
        $ultraSound = null;
        $responseJson = null;

        try
        {
            $examinationDate = $patientSearchRequest->get('examinationDate');
            //dd($examinationDate);
            //$generalExaminationDate = \DateTime::createFromFormat('Y-m-d', $examinationDate);
            $examinationDate = date('Y-m-d', strtotime($examinationDate));
            $ultraSound = $this->hospitalService->getPatientUltraSoundTests($patientId, $examinationDate);
            //dd($familyIllness);

            if(!is_null($ultraSound) && !empty($ultraSound))
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR));
                $responseJson->setCount(sizeof($ultraSound));
            }
            else
            {
                $responseJson = new ResponsePrescription(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::NO_PATIENT_ULTRASOUND_DETAILS_FOUND));
            }

            $responseJson->setObj($ultraSound);
            $responseJson->sendSuccessResponse();
        }
        catch(HospitalException $hospitalExc)
        {
            //dd($hospitalExc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.$hospitalExc->getUserErrorCode()));
            $responseJson->sendErrorResponse($hospitalExc);
        }
            /*catch(HospitalException $hospitalExc)
            {
                $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_PAST_ILLNESS_DETAILS_ERROR));
                $responseJson->sendErrorResponse($hospitalExc);
            }*/
        catch(Exception $exc)
        {
            //dd($exc);
            $responseJson = new ResponsePrescription(ErrorEnum::FAILURE, trans('messages.'.ErrorEnum::PATIENT_ULTRASOUND_DETAILS_ERROR));
            $responseJson->sendUnExpectedExpectionResponse($exc);
        }

        //return $responseJson;
        return view('portal.hospital-patient-lab-ultrasound-tests-detail',compact('ultraSound'));
    }



    /* DOCTOR VIEW & EDIT PATIENTS */


    public function PatientDetailsByDoctorForFront($did,$hid,$patientId)
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
            $patientPrescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            $labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointments($patientId);
            $patientAppointment = HospitalServiceFacade::getPatientAppointmentsByHospital($patientId, $hid);
            //dd($patientAppointment);
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

        return view('portal.doctor-patient-details',compact('patientDetails','patientPrescriptions','labTests','patientAppointment'));

    }

    public function PatientEditByDoctorForFront($did,$hid,$patientId)
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
            //$patientPrescriptions = HospitalServiceFacade::getPrescriptionByPatient($patientId);
            //$labTests = HospitalServiceFacade::getLabTestsByPatient($patientId);
            //$patientAppointment = HospitalServiceFacade::getPatientAppointments($patientId);
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

        return view('portal.doctor-patient-edit',compact('patientDetails'));

    }

    public function updatePatientsByDoctorForFront(Request $patientProfileRequest)
    {
        //dd('HI');
        //return "HI";
        $patientProfileVM = null;
        $status = true;
        $jsonResponse = null;
        //return $patientProfileRequest->all();

        try
        {
            $patientProfileVM = PatientProfileMapper::setPatientProfile($patientProfileRequest);
            $status = HospitalServiceFacade::savePatientProfile($patientProfileVM);

            if($status)
            {
                //$jsonResponse = new ResponseJson(ErrorEnum::SUCCESS, trans('messages.'.ErrorEnum::PATIENT_PROFILE_SAVE_SUCCESS));

                $msg = "Patient Profile Updated Successfully.";
                return redirect('doctor/rest/api/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patients')->with('success',$msg);
            }
            else
            {
                $msg = "Patient Details Invalid / Incorrect! Try Again.";
                return redirect('doctor/rest/api/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patients')->with('message',$msg);
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

        $msg = "Patient Details Invalid / Incorrect! Try Again.";
        return redirect('doctor/rest/api/'.Auth::user()->id.'/hospital/'.Session::get('LoginUserHospital').'/patients')->with('message',$msg);
        //return $jsonResponse;

    }

}
