<?php

namespace App\Http\Controllers\Api\Results;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChoiceResult;
use App\Models\Question;
use App\Models\TrueAnswer;

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

        $examResults = [];
        foreach ($results as $result) {
            $exam = $result->exam;
            $questionsDetails = [];

            foreach ($result->choices as $choice) {
                $question = ChoiceResult::find($choice['question_id']);
                $trueAnswer = TrueAnswer::where('question_id', $choice['question_id'])->first();

                if ($question && $trueAnswer) {
                    $questionsDetails[] = [
                        'question_id' => $question->id,
                        'question_text' => $question->text,
                        'selected_choice' => $choice['choice'],
                        'correct_choice' => $trueAnswer->ans
                    ];
                }
            }

            $examResults[] = [
                'name_exam' => $exam->name_exam,
                'result' => $result->result,
                'questions' => $questionsDetails
            ];
        }

        return response(
            [
                'message' => "Exams with results are retrieved.",
                'status' => true,
                'exams' => $examResults
            ],
            200
        );
    }
}
