<?php

namespace App\Http\Controllers\Api\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
class SliderController extends Controller
{
    public function slider($year_type){

        $sliders=Slider::where("year_type",$year_type)->get();
        return response(
            [ 'message'=>"sliders are get",
             'status'=> true,
             'data'=> $sliders]
        ,200);
    }
}
