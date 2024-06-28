<?php

namespace App\Http\Livewire\Admin\StudentSubscribe;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Unit;

class SubscribeDelete extends Component
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
    }

    public function selectStudent($studentId)
    {
        $this->selectedStudent = User::find($studentId);
        $this->searchTerm = $this->selectedStudent->name;
    }

    public function deleteLectureSub($id)
    {
        // Find the lecture by ID
        $lecture = Lecture::find($id);
        
        if (!$lecture) {
            session()->flash("error_message", "Lecture not found.");
            return redirect()->route('subscript_delete');
        }
    
        // Detach the lecture subscription from the student
        $this->selectedStudent->lectures()->detach($id);
        
        // Update the student's wallet by adding the lecture's price
        $this->selectedStudent->wallet += $lecture->price;
        
        // Save the updated student information
        $this->selectedStudent->save();
        
        // Flash a message indicating the subscription deletion
        session()->flash("error_message", "You have deleted the lecture subscription.");
        
        // Redirect to the subscription delete route
        return redirect()->route('subscript_delete');
    }

    public function deleteUnitSub($id)
    {
        // Find the unit by ID
        $unit = Unit::find($id);
        
        if (!$unit) {
            session()->flash("error_message", "Unit not found.");
            return redirect()->route('subscript_delete');
        }
    
        // Detach the unit subscription from the student
        $this->selectedStudent->units()->detach($id);
        
        // Update the student's wallet by adding the unit's price
        $this->selectedStudent->wallet += $unit->price;
        
        // Save the updated student information
        $this->selectedStudent->save();
        
        // Flash a message indicating the subscription deletion
        session()->flash("error_message", "You have deleted the unit subscription.");
        
        // Redirect to the subscription delete route
        return redirect()->route('subscript_delete');
    }
    

    public function render()
    {
        return view('livewire.admin.student-subscribe.subscribe-delete')->layout('layouts.admin');
    }
}
