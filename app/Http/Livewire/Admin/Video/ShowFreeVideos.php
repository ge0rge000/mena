<?php

namespace App\Http\Livewire\Admin\Video;

use Livewire\Component;
use App\Models\FreeVideo;

class ShowFreeVideos extends Component
{
    public $freeVideos;

    public function mount()
    {
        $this->freeVideos = FreeVideo::where('status', 1)->get();
        // dd( $this->freeVideos );
    }

    public function render()
    {
        return view('livewire.admin.video.show-free-videos', ['freeVideos' => $this->freeVideos])->layout('layouts.admin');
    }
}
