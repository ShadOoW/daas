<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Exceptions\DoctorNotFoundException;

class DoctorController extends Controller
{
    // Simulate a response from Ministry of Health for doctors IDs, Names
    private $DOCTORS = [
        ['id' => 1, 'name' => 'Mikael Seström'],
        ['id' => 2, 'name' => 'Carina Axel'],
        ['id' => 3, 'name' => 'Martin Eriksson'],
    ];

    /**
     * List all Doctors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $response = [];
        foreach($this->DOCTORS as $doctor) {
            $response[] = array_merge(
                $doctor,
                ['appointments_count' => Appointment::where('doctor', $doctor['id'])->count()]
            );
        }

        return response()->json($response);
    }

    /**
     * Get a Doctor by ID
     *
     * @param number $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws DoctorNotFoundException
     */
    public function get($id)
    {
        $key = array_search($id, array_column($this->DOCTORS, 'id'));
        if($key !== false) {
            return response()->json($this->DOCTORS[
                array_search($id, array_column($this->DOCTORS, 'id'))
            ]);
        } else {
            throw new DoctorNotFoundException('Doctor not found by ID ' . $id);
        }
    }
}
