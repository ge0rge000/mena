<?php

namespace App\Http\Livewire\Admin\StudentSubscribe;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Unit;

class SubscribeIndex extends Component
{
    public $searchTerm,$results,$selectedStudent;

    public function updated()
    {   
        if ($this->searchTerm) {
            $this->results = User::where('mobile_phone', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('code', 'like', '%' . $this->searchTerm . '%')
                                ->orWhere('name', 'like', '%' . $this->searchTerm . '%')->get();
        } else {
            $this->results = null;
        }
        $lectures=Lecture::where('status','active')->get();
        $units=Unit::all();
    }
    
    public function render()
    {
        return view('livewire.admin.student-subscribe.subscribe-index')->layout('layouts.admin');
    }
}
