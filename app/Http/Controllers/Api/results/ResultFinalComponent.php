<?php

namespace App\Http\Controllers\Api\Results;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalResult;
use App\Models\ChoiceResult;

class ResultFinalComponent extends Controller
{
    public function getResult($id_user)
    {
        $results = ChoiceResult::where('user_id', $id_user)->get();

        // Check if any results were found
        if ($results->isEmpty()) {
            return response(
                [
                    'message' => "No exam results found for this user.",
                    'status' => false,
                ],
                404
            );
        }

        // Collecting the exam names and results
        $exams = [];
        foreach ($results as $result) {
            if ($result->exam) {
                $exams[] = [
                    'name_exam' => $result->exam->name_exam,
                    'result' => $result->result
                ];
            }
        }

        return response(
            [
                'message' => "Exams with results are retrieved.",
                'status' => true,
                'exams' => $exams
            ],
            200
        );
    }
}
