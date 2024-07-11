<?php

namespace App\Http\Livewire\Admin\StudentQuestion;

use Livewire\Component;
use App\Models\StudentQuestion;

class ShowQuestions extends Component
{
    public function render()
    {
        $questions = StudentQuestion::with('user')->get();
        return view('livewire.admin.student-question.show-questions', ['questions' => $questions])->layout('layouts.admin');
    }
}
