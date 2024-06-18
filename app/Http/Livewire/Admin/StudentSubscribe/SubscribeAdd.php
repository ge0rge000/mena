<?php

namespace App\Http\Livewire\Admin\StudentSubscribe;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Unit;

class SubscribeAdd extends Component
{
    public $searchTerm,$results,$selectedStudent,$subscription_type,$month_id,$lecture_id;

    public function updated()
    {   
        if ($this->searchTerm) {
            $this->results = User::where('utype', 'USR')
                                ->where('mobile_phone', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('student_code', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('name', 'like', '%' . $this->searchTerm . '%')->get();
        } else {
            $this->results = null;
        }
        $lectures=Lecture::where('status','active')->get();
        $units=Unit::all();
    }
    public function selectStudent($studentId)
    {
        $this->selectedStudent = User::find($studentId);
        $this->searchTerm = $this->selectedStudent->name;
    }

    public function subscript()
    {
        // Validate the main input
        $this->validate([
            'selectedStudent' => 'required',
            'subscription_type' => 'required|in:month,lecture',
        ]);
    
        // Check the subscription type
        if ($this->subscription_type === 'month') {
            // Validate the month_id
            $this->validate([
                'month_id' => 'required',
            ]);
    
            // Check if the month is already attached to the student
            if ($this->selectedStudent->units()->wherePivot('unit_id', $this->month_id)->exists()) {
                session()->flash("warning_message", "The student already has this month.");
                return redirect()->route('subscript_add');
            } else {
                // Attach the month with additional data including the created_at timestamp
                $this->selectedStudent->units()->attach($this->month_id, ['created_at' => now()]);
                session()->flash("success_message", "You added a new month to the student.");
            }
        } elseif ($this->subscription_type === 'lecture') {
            // Validate the lecture_id
            $this->validate([
                'lecture_id' => 'required',
            ]);
    
            // Check if the lecture is already attached to the student
            if ($this->selectedStudent->lectures()->wherePivot('lecture_id', $this->lecture_id)->exists()) {
                session()->flash("error_message", "The student already has this lecture.");
                return redirect()->route('subscript_add');
            } else {
                // Attach the lecture with additional data including the created_at timestamp
                $this->selectedStudent->lectures()->attach($this->lecture_id, ['created_at' => now()]);
                session()->flash("success_message", "You added a new lecture to the student.");
            }
        }
    
        return redirect()->route('subscript_index');
    }
    

    public function render()
    {
        $lectures=Lecture::where('status','active')->get();
        $units=Unit::all();
        return view('livewire.admin.student-subscribe.subscribe-add',[
            'lectures'=>$lectures,
            'units'=>$units,
        ])->layout('layouts.admin');
    }
}
