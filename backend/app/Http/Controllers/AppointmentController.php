<?php

namespace App\Http\Controllers;

use App\Appointment;
use DateTime;
use Illuminate\Http\Request;
use App\Utils\TimeUtil;

class AppointmentController extends Controller
{
    private $token;

    /**
     * List all existing Appointment
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    /**
     * Create new Appointment
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $appointment = Appointment::create($request->all());
        return response()->json($appointment);
    }

    /**
     * List Appointments by Patient ID
     *
     * @param Request $request
     * @param number $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByPatient(Request $request, $patient)
    {
        $this->token = $request->get('token');
        $appointments = Appointment::where('patient', $patient)->get();

        foreach ($appointments as $appointment) {
            $appointment['name'] = $this->enrichDoctorName($appointment->doctor);
            $appointment['conflicts'] = $this->detectConflict(
                $appointment,
                $appointments,
                'doctor'
            );
        }
        return response()->json($appointments);
    }

    /**
     * List Conflicting Appointments by Doctor ID
     *
     * @param string $token
     * @param number $doctor
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByDoctor($token, $doctor)
    {
        $appointments = Appointment::where('doctor', $doctor)->get();

        foreach ($appointments as $appointment) {
            $appointment['name'] = $this->enrichPatientName($appointment->patient, $token);
            $appointment['conflicts'] = $this->detectConflict(
                $appointment,
                $appointments,
                'patient',
                $token
            );
        }
        return response()->json($appointments);
    }

    /**
     * @param number $id
     * @return string
     */
    public function enrichDoctorName($id) {
        $request = Request::create('/doctor/' . $id, 'GET', ['token' => $this->token]);
        return json_decode(app()->dispatch($request)->content())->name;
    }

    /**
     * @param number $id
     * @return string
     */
    public function enrichPatientName($id) {
        $request = Request::create('/patient/' . $id, 'GET', ['token' => $this->token]);
        return json_decode(app()->dispatch($request)->content())->name;
    }

    /**
     * @param object $seed
     * @param array $heap
     * @param string $entityType
     * @return array
     */
    private function detectConflict($seed, $heap, $entityType) {
        $conflicts = [];
        foreach ($heap as $compareTo) {
            if ($compareTo->id !== $seed->id) {
                if (TimeUtil::testRange(
                    (new DateTime())->setTimestamp($seed->start_time),
                    (new DateTime())->setTimestamp($seed->end_time),
                    (new DateTime())->setTimestamp($compareTo->start_time),
                    (new DateTime())->setTimestamp($compareTo->end_time)
                )) {
                    $name = $entityType === 'patient' ?
                        $this->enrichDoctorName($compareTo->doctor) :
                        $this->enrichPatientName($compareTo->patent);

                    $conflicts[] = [
                        'name' => $name,
                        'start_time' => $compareTo->start_time,
                        'end_time' => $compareTo->end_time,
                    ];
                }
            }
        }

        return $conflicts;
    }
}
