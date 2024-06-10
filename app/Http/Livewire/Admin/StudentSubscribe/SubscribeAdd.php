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
                                ->orWhere('code', 'like', '%' . $this->searchTerm . '%')->get();
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
        // dd($this->all());
        $this->validate([
            'selectedStudent' => 'required',
            'subscription_type' => 'required|in:month,lecture',
        ]);

        if ($this->subscription_type === 'month') {
            $this->validate([
                'month_id' => 'required',
            ]);
        
            // Attach the unit with additional data including the created_at timestamp
            $this->selectedStudent->units()->attach($this->month_id, ['created_at' => now()]);
            session()->flash("success_message", "You added a new month to the student.");
        } elseif ($this->subscription_type === 'lecture') {
            $this->validate([
                'lecture_id' => 'required',
            ]);
        
            // Attach the lecture with additional data including the created_at timestamp
            $this->selectedStudent->lectures()->attach($this->lecture_id, ['created_at' => now()]);
            session()->flash("success_message", "You added a new lecture to the student.");
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
