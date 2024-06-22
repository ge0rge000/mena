<?php

namespace App\Http\Livewire\Admin\Video;

use Livewire\Component;
use App\Models\FreeVideo;

class AddFreeVideo extends Component
{
    public $status; // Default value
    public $name, $description, $link;

    public function store()
    {
        // dd($this->status);
        $this->validate([
            'link' => 'required',
            'name' => 'required',
            'description' => 'required',
            'status' => 'boolean', // Validation rule for status
        ]);

        $new_video = new FreeVideo;
        $new_video->name = $this->name;
        $new_video->description = $this->description;
        $new_video->link = $this->link;
        $new_video->status = $this->status==1 ? 1 : 0; // Explicitly set 1 or 0
        $new_video->save();

        return redirect()->route('lecture_index');
    }

    public function render()
    {
        return view('livewire.admin.video.add-free-video')->layout('layouts.admin');
    }
}
