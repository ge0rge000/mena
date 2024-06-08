<?php

namespace App\Http\Livewire\Admin\Slider;

use Livewire\Component;
use App\Models\Slider;
use Livewire\WithFileUploads;
use Storage;
class SlideAddComponent extends Component
{

    use WithFileUploads;
    public $image;
    public $title;
    protected $rules = [
        'image' => 'required',
        'title' => 'required',
    ];

    public function addslider(){
        $this->validate();
        $slider=new Slider;
        $slider->title=$this->title;

        if($this->image!=null){
            $imagename=time().'.'.$this->image->extension();
                $disk = Storage::disk('photos');
                $path = $disk->putFileAs('sliders', $this->image, $imagename);
            $slider->image=$path;

                }
     $slider->save();
     return redirect()->route("show_slider");

    }



    public function render()
    {
        return view('livewire.admin.slider.slide-add-component')->layout('layouts.admin');
    }
}
