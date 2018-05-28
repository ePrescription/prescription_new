<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientProfileWebRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function __construct(Factory $validationFactory)
    {

        $validationFactory->extend(
            'invaliddate',
            function ($attribute, $value, $parameters) {
                $isValid = true;
                $doctorId = $this->get('doctorId');
                $hospitalId = $this->get('hospitalId');
                //$appDate = $this->get('appointmentDate');
                $appDate = date("Y-m-d", strtotime($this->get('appointmentDate')));
                $appTime = $this->get('appointmentTime');

                $currentDate = Carbon::now()->format('Y-m-d');
                $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
                //dd($currentDate);
                $currentTime = date('H:i', strtotime($currentDateTime));
                $appointmentTime = date('H:i', strtotime($appTime));

               // dd($appDate."  ".$currentDate);
                if($appDate < $currentDate)
                {
                    //dd('Inside less');
                    return false;
                }
                else if($appDate == $currentDate)
                {
                    //dd('Inside equal to');
                    //dd($currentTime);
                    //dd($appointmentTime);
                    if($appointmentTime < $currentTime)
                    {
                        return false;
                    }
                    else
                    {
                        return true;
                    }
                }
                else
                {
                    return true;
                }

            },
            'Invalid date. Please check appointment date!!!'
        );

        $validationFactory->extend(
            'invalidtime',
            function ($attribute, $value, $parameters) {
                $isValid = true;
                $doctorId = $this->get('doctorId');
                $hospitalId = $this->get('hospitalId');
                $appDate = $this->get('appointmentDate');
                $appTime = $this->get('appointmentTime');

                $currentDate = Carbon::now()->format('Y-m-d H:i:s');
                //dd($currentDate);
                $currentTime = date('H:i', strtotime($currentDate));
                $appointmentTime = date('H:i', strtotime($appTime));
                //dd($appointmentTime);

                if($appDate < $currentDate)
                {
                    return false;
                }
                else
                {
                    return true;
                }

            },
            'Invalid date or time. Please check appointment date or time!!!'
        );

        $validationFactory->extend(
            'duplicate',
            function ($attribute, $value, $parameters) {

                $doctorId = $this->get('doctorId');
                $hospitalId = $this->get('hospitalId');
                //$date = date("Y-m-d", strtotime($input['appointmentDate']));
                $appDate = date("Y-m-d", strtotime($this->get('appointmentDate')));
                $currentAppTime = $this->get('appointmentTime');

                //dd($currentAppTime);

                $appDuration = strtotime("+30 minutes", strtotime($currentAppTime));

                $minutes = date('i', strtotime($currentAppTime));
                $hours = date('H', strtotime($currentAppTime));
                $min = $minutes - ($minutes % 5);

                //dd($min);

                $mm = $minutes % 30;
                //dd($mm);

                /*if($min == 15)
                {
                    //dd('inside minutes');
                    //$min = date('i', $minutes - ($minutes % 5));
                    $min = $minutes - ($minutes % 5);
                    //dd($min);
                }
                else
                {
                    $min = "00";
                }*/
                /*else
                {
                    //dd('Inside else');
                    $min = $minutes;
                    //dd($min);
                }*/
                $lowestTime = $hours.":".$min;
                $upperTime = date('H:i', strtotime("+4 minutes", strtotime($lowestTime)));

                //dd($lowestTime.' '.$upperTime);
                //dd($upperTime);
                //$upperTime = date(""strtotime("+30 minutes", strtotime($lowestTime));

                //$lowerMinute = $minutes - 30;
                //$upperMinute = $minutes + 30;

                /*$data = array();
                $data['lower'] = $lowestTime;
                $data['upper'] = $upperTime;

                return json_encode($data);*/

                $query = DB::table('doctor_appointment as da')->where('da.doctor_id', $doctorId);
                $query->where('da.hospital_id', $hospitalId);
                $query->whereDate('da.appointment_date', '=', $appDate);
                /*$query->where(function($query) use($lowestTime, $upperTime)
                {
                    $query->where('da.appointment_time', $lowestTime);
                    $query->OrWhere('da.appointment_time', $upperTime);
                });*/
                //$query->where('da.appointment_time', $appDuration);
                //$query->where('da.appointment_time', $lowestTime);
                //$query->OrWhere('da.appointment_time', $upperTime);
                //$query->OrWhere('da.appointment_time', $upperTime);
                $query->where(function($query) use($lowestTime, $upperTime){
                    $query->where('da.appointment_time', '>=', $lowestTime);
                    $query->where('da.appointment_time', '<=', $upperTime);
                });

                //dd($appDate."  ".$upperTime."  ".$lowestTime);
                //$query->whereBetween('da.appointment_time', [$appTime, $appDuration]);

                //dd($query->toSql());
                $recCount = $query->count();
                //dd($recCount);

                //if(!is_null())

                //if()
                //$appTime = $appointments->appointment_time;

                //$minutes = date('i', strtotime($appTime));



                //return json_encode($data);

                /*if($currentAppTime >= $appTime && $currentAppTime <=  $appDuration)
                {
                    return true;
                }
                else
                {
                    return false;
                }*/


                /*$rec = $query->count();*/

                if($recCount == 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }


            },
            'No appointment available for the requested time!!!'
        );

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $profile = (object) $this->all();
        //$profile1 = $this->get('appointment');
        //$profile1 = json_encode($profile);
        //dd($profile);

        /*foreach($this->get('appointment') as $key => $val)
        {
            //dd($val);
            $rules['appointmentTime'] = ['regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^', 'duplicate'];
        }*/
        //dd($profile->appointment[0]['appointmentCategory']);

        $rules = [];

        $rules['name'] = 'required';
        //$rules['address'] = 'required';

        //$rules['telephone'] = 'required | numeric | digits:10';
        //$rules['email'] = 'required | email';
        /*if($profile->patientId == 0)
        {
            $rules['email'] = 'email | unique:users,email';
        }*/
        //$rules['dob'] = 'date_format:Y-m-d';
        $rules['doctorId'] = 'required';
        $rules['hospitalId'] = 'required';

        $rules['appointmentDate'] = ['required', 'date_format:Y-m-d', 'invaliddate'];
        $time = date( "H:i:s", strtotime($profile->appointmentTime));
        $profile->appointmentTime = $time;
        $rules['appointmentTime'] = ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^'];
        //$rules['appointmentTime'] = ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^', 'duplicate'];

        if($profile->referralType == 'External')
        {
            $rules['referralDoctor'] = 'required';
            $rules['referralHospital'] = 'required';
            $rules['hospitalLocation'] = 'required';
        }

        /*$appTime = $profile->appointment[0]['appointmentTime'];
        $category = $profile->appointment[0]['appointmentCategory'];

        //dd($category);

        if(empty($category))
        {
            $rules['appointmentCategory'] = 'required';
        }

        if(!empty($appTime))
        {
            $rules['appointmentTime'] = ['regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^', 'duplicate'];
        }*/
        //dd($appTime);

        //$rules[$profile->appointment[0]['appointmentCategory']] = 'required';

        //$rules['appointmentCategory'] = 'required';
        /*$rules['appointmentDate'] = ['required', 'date_format:Y-m-d', 'invaliddate'];
        $rules['appointmentTime'] = ['required', 'regex:^(([0-1][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?)$^', 'duplicate'];*/
        //$rules['age'] = 'required | numeric';
        //$rules['gender'] = 'required';

        //dd($rules);
        return $rules;
    }
}
