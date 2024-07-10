<?php

namespace App\Http\Livewire\Admin\Video;

use Livewire\Component;
use App\Models\Lecture;
use App\Models\Unit;

class LectureVideos extends Component
{
    public $lecture_id, $units, $lectures = [], $unid_id, $videos;

    public function mount()
    {
        $this->units = Unit::all();
        $this->lectures = Lecture::all()->toArray();
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'unid_id' && $this->unid_id) {
            $this->lectures = Lecture::where('unit_id', $this->unid_id)->get()->toArray();
        }

        if ($propertyName == 'lecture_id' && $this->lecture_id) {
            $lecture = Lecture::find($this->lecture_id);
            $this->videos = $lecture ? $lecture->videos->map(function($video) {
                $video->embed_link = $this->convertToEmbedLink($video->link);
                return $video;
            }) : null;
        }
    }

    private function convertToEmbedLink($link)
    {
        parse_str(parse_url($link, PHP_URL_QUERY), $query);
        return isset($query['v']) ? 'https://www.youtube.com/embed/' . $query['v'] : null;
    }

    public function deleteVideo($videoId)
    {
        $video = Video::findOrFail($videoId);
        $video->delete();
        $this->updated('lecture_id'); // Refresh the video list
        session()->flash('message', 'Video deleted successfully.');
    }
    public function confirmDeletion($videoId)
    {
        $this->dispatchBrowserEvent('confirmDeletion', ['videoId' => $videoId]);
    }
    
    public function render()
    {
        return view('livewire.admin.video.lecture-videos')->layout('layouts.admin');
    }
}
