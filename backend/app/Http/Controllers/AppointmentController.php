<?php

namespace App\Http\Controllers;

use App\Appointment;
use DateTime;
use Illuminate\Http\Request;
use App\Utils\TimeUtil;

class AppointmentController extends Controller
{
    private $token;
    private $baseUrl;

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
        $this->baseUrl = $request->getBaseUrl();
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
     * @param Request $request
     * @param number $doctor
     * @return \Illuminate\Http\JsonResponse
     */
    public function listByDoctor(Request $request, $doctor)
    {
        $this->token = $request->get('token');
        $this->baseUrl = $request->getBaseUrl();
        $appointments = Appointment::where('doctor', $doctor)->get();

        foreach ($appointments as $appointment) {
            $appointment['name'] = $this->enrichPatientName($appointment->patient);
            $appointment['conflicts'] = $this->detectConflict(
                $appointment,
                $appointments,
                'patient'
            );
        }
        return response()->json($appointments);
    }

    /**
     * @param number $id
     * @return string
     */
    public function enrichDoctorName($id) {
        $request = Request::create($this->baseUrl . '/doctor/' . $id, 'GET', ['token' => $this->token]);
        return json_decode(app()->dispatch($request)->content())->name;
    }

    /**
     * @param number $id
     * @return string
     */
    public function enrichPatientName($id) {
        $request = Request::create($this->baseUrl . '/patient/' . $id, 'GET', ['token' => $this->token]);
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
