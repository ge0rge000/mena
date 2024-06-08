<?php

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrueAnswer;
use App\Models\ChoiceResult;
use App\Models\PargraphResult;
use App\Models\FinalResult;


class ResultComponent extends Controller
{

    public function checkanswerchoice(Request $request){

            if($request->get('choices')==null){

                return response(
                    [ 'message'=>"no choice contain",
                     'status'=> false,
                     'data'=> null]
                ,200);

            }else{
            if(ChoiceResult::where("exam_id", $request->get('exam_id'))->where("user_id", $request->get('user_id'))->exists()) {
                $re=ChoiceResult::where("exam_id", $request->get('exam_id'))->where("user_id", $request->get('user_id'))->first();
                return response(
                ['result'=>$re->result]
            ,200);
            }else{
                $choicestudent=[];

                $choices = $request->get('choices');
                $result=0;
                 
         foreach ($choices as $key => $choice) {
    // Append a new element to choicestudent
    $choicestudent[] = ["question_id" => $key, "choice" => $choice];
   
    // Get the true answer
    $choice_true = TrueAnswer::where('question_id', $key)->first();
    
    if ($choice_true != null) {
        $true_choice = $choice_true->ans;
            
        if ($true_choice == $choice) {
           
      
            
            // Update the result
            $result += $choice_true->question->mark_question;
        }
    }
}

                  
             $data=ChoiceResult::create(
             [
                'choices' => $choicestudent,
                'exam_id' =>$request->get('exam_id'),
                'user_id' => $request->get('user_id'),
                'result' => $result,
            ]
            );

            }
            return response(
                ['result'=>$data->result]
            ,200);

    }
}


}




