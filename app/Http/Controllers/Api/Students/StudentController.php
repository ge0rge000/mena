<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function checkLectures($id)
    {
        // Retrieve the student with their lectures and units
        $student = User::with('lectures.unit')->find($id);

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        // Extract lecture IDs
        $lectureIds = $student->lectures->pluck('id');

        return response()->json($lectureIds);
    }
    public function checkUnits($id)
    {
        $student = User::find($id);
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        $unitIds = $student->units()->where('status', '=', 1)->pluck('id');

        return response()->json($unitIds);
    }

    public function returnwallet($id)
    {
        $student = User::find($id);

        return (string) $student->wallet;
    }

}
