<?php

namespace App\Http\Controllers\Api\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StudentController extends Controller
{
    public function checkLectures($id)
    {
        $student =User::with('lectures.unit')->find($id);
        return response()->json($student->lectures);
    }

    public function checkUnits($id)
    {
        $student =User::find($id);
        return response()->json($student->units);
    }
}
