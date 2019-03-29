<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Exceptions\PatientNotFoundException;

class PatientController extends Controller
{
    // Simulate a response from Ministry of Interior for patients IDs, Names
    private $PATIENTS = [
        ['id' => 1, 'name' => 'Henrik Karlsson'],
        ['id' => 2, 'name' => 'Erik Henriksson'],
        ['id' => 3, 'name' => 'Cecilia Eliasson'],
    ];

    /**
     * List all Patients
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $response = [];
        foreach($this->PATIENTS as $patient) {
            $response[] = array_merge(
                $patient,
                ['appointments_count' => Appointment::where('patient', $patient['id'])->count()]
            );
        }

        return response()->json($response);
    }

    /**
     * Get Patient by ID
     *
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws PatientNotFoundException
     */
    public function get($id)
    {
        // Find Patient index by ID
        $key = array_search($id, array_column($this->PATIENTS, 'id'));

        if($key !== false) {
            $patient = $this->PATIENTS[$key];

            // Populate Patient Appointment
            $patient['appointments_count'] = Appointment::where('patient', $patient['id'])->count();

            // Return result
            return response()->json($patient);
        } else {
            throw new PatientNotFoundException('Patient not found by ID ' . $id);
        }
    }
}
