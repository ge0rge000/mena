<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\Auth\AuthController;

use App\Http\Controllers\Api\Unit\GetUnitComponent;
use App\Http\Controllers\Api\Video\VideosShowComponent;
use App\Http\Controllers\Api\Exam\ExamController;
use App\Http\Controllers\Api\Questions\Questions;
use App\Http\Controllers\Api\Questions\StudentQuestions;

use App\Http\Controllers\Api\QuestionAnswers\QuestionAnswers;

use App\Http\Controllers\Api\results\StudentAnswers;

use App\Http\Controllers\Api\Video\HandleVideo;

use App\Http\Controllers\Api\Password\GetvalidatePassword;

use App\Http\Controllers\Api\Slider\SliderController;

use App\Http\Controllers\Api\QuestionMoney\QuestionMoneyController;

use App\Http\Controllers\Api\results\ChoiceComponent;


use App\Http\Controllers\Api\results\ResultFinalComponent;

use App\Http\Controllers\Api\Exam\ResultComponent;

use App\Http\Controllers\Api\Files\HandleFiles;

use App\Http\Controllers\Api\Lectures\LectureController;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);

Route::get('sliders',[SliderController::class,'slider']);

Route::get('student/{id_user}',[ResultFinalComponent::class,'getResult']);

Route::get('student_choices/{id_user}/{id_exam}',[ResultFinalComponent::class,'getResult']);



    Route::get('getunits/{year}',[GetUnitComponent::class,'getcategory']);
    Route::get('videomena/{month}/{year_type}/{id_user}',[VideosShowComponent::class,'checkvalidate']);
    Route::get('exams_return/{year_type}/{id_student}',[ExamController::class,'returnexams']);
    Route::get('questions/{id_exam}',[Questions::class,'returnquestions']);
    Route::get('validatepass/{exam_id}/{password}',[GetvalidatePassword::class,'validatepassword']);
    Route::post('resultchoice',[ResultComponent::class,'checkanswerchoice']);
    Route::post('resultpargraph',[ResultComponent::class,'checkanswerpar']);
    Route::post('resultall',[ResultComponent::class,'getResultExam']);
    Route::get('moneyquestion',[QuestionMoneyController::class,'moneyreturnquestions']);
    // handle pdf
    Route::get('file/pdf/{unit_id}',[HandleFiles::class,'show']);

    //Post & get Student Question & answers
    Route::post('student-questions', [StudentQuestions::class, 'store']);
    Route::get('/student-questions/{unit_id}', [StudentQuestions::class, 'index']);
    Route::get('/student-questions/show/{question_id}', [StudentQuestions::class, 'show']);
    // answers [get answer of specific question - store answers ]
    Route::apiResource('/question/answers', QuestionAnswers::class);

    // Video [show]
    Route::apiResource('/video', HandleVideo::class);

    // student answers and correct answers
    Route::get('/student/answers/{exam_id}/{user_id}', [StudentAnswers::class,'show']);

    Route::get('lecture/{id}',[LectureController::class,'show']);

    Route::get("examed_test/{id_user}",[ResultFinalComponent::class,'getResult']);
