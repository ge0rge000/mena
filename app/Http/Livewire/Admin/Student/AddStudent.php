<?php

namespace App\Http\Livewire\Admin\Student;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;


class AddStudent extends Component
{
    public $code,$name,$year,$mobile_father,$case =null;
    public function generateUniqueCode()
    {

        $characters = '0123456789';
        $charactersNumber = strlen($characters);
        $codeLength = 6;

        $code = '';

        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }

        if (User::where('mobile_phone', $code)->exists()) {
            $this->generateUniqueCode();
        }

        $this->code= $code;
    }
    public function store(Request $request)
    {
        $new_user = new User();
        $new_user->name = $this->name;
        $new_user->year_type = $this->year;
        $new_user->mobile_father = $this->mobile_father;
        $new_user->mobile_phone = $this->code;
        $new_user->case_reverse = $this->case;
        $new_user->device_id =12;
        $new_user->wallet =0    ;       //change this with device id
        $new_user->save();
        $this->finish();
        session()->flash("success_message","you add a new student");
        return redirect()->back();
    }
    public function finish()
    {
        $this->code=null;
        $this->name=null;
        $this->year=null;
        $this->mobile_father=null;
        $this->case=null;
    }
    public function render()
    {
        $table = 'users';
        $column = 'case_reverse';

        $enumValues = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
        $enumOptions = [];

        if (isset($matches[1])) {
            $enumOptions = explode(',', $matches[1]);
            $enumOptions = array_map(function ($value) {
                return trim($value, "'");
            }, $enumOptions);
        }
        $table = 'users';
        $column = 'year_type';

        $enumValues = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
        $year_type = [];

        if (isset($matches[1])) {
            $year_type = explode(',', $matches[1]);
            $year_type = array_map(function ($value) {
                return trim($value, "'");
            }, $year_type);
        }
        return view('livewire.admin.student.add-student',
        ['enumOptions'=>$enumOptions,
        'year_type'=>$year_type
        ])->layout('layouts.admin');
    }
}
