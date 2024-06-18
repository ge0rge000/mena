<?php

namespace App\Http\Livewire\Admin\Student;

use Livewire\Component;

class StudentSearch extends Component
{
    public function render()
    {
        return view('livewire.admin.student.student-search')->layout('layouts.admin');
    }
}
