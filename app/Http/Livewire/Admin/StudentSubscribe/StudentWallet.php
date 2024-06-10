<?php

namespace App\Http\Livewire\Admin\StudentSubscribe;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Unit;

class StudentWallet extends Component
{
    public $searchTerm,$results,$selectedStudent,$table,$wallet,$old_balance;

    public function updated()
    {   
        if ($this->searchTerm) {
            $this->results = User::where('utype', 'USR')
                                ->where('mobile_phone', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('code', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('name', 'like', '%' . $this->searchTerm . '%')->get();
           
        } else {
            $this->results = null;
        }
        $lectures=Lecture::where('status','active')->get();
        $units=Unit::all();
    }
    public function selectStudent($studentId)
    {
        $this->selectedStudent = User::with(['lectures', 'units'])->find($studentId);
        $this->old_balance=$this->selectedStudent->wallet;
        $this->lectures = $this->selectedStudent->lectures;
        $this->units = $this->selectedStudent->units;
    }
    public function recharge()
    {
        $this->validate([
            'wallet' => 'required|regex:/^[1-9]\d*$/',
        ]);
        // dd($this->wallet);
        $this->selectedStudent->update([
            'wallet'=>$this->wallet+$this->old_balance
        ]);
        session()->flash("success_message", "You added a new Balance to the student.");
        return redirect()->route('student_wallet');

    }

    public function render()
    {
        return view('livewire.admin.student-subscribe.student-wallet')->layout('layouts.admin');
    }
}
