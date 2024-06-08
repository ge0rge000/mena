<?php

namespace App\Http\Controllers\Api\results;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalResult;
class ResultFinalComponent extends Controller
{
    public function getResult($id_user){
        $results=FinalResult::where('user_id',$id_user)->where('show_Result',"1")->get();
        $exams=$results->exams();
        return response(
            [ 'message'=>"exams with result are get",
             'status'=> true,
             'data'=> $results,
             'exams'=>$exams]
        ,200);

    }
}
