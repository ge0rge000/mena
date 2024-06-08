<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Session;
class HOME extends Component
{
   public $mqttMessage;
    public function extractInputAndValue($str) {
        $matches = [];
        preg_match("/'INPUT'\s*:\s*'(\w+)',\s*'VALUE'\s*:\s*'(\w+)'/", $str, $matches);
        if(count($matches) == 3) {
            return ['INPUT' => $matches[1], 'VALUE' => $matches[2]];
        }
        return [];
    }
    public function render()
    {
        $output = shell_exec('python3 ' . app_path('script.py'));
        dd($output);
        $data = $this->extractInputAndValue($output);

        $this->mqttMessage = $data;

  
        return view('livewire.h-o-m-e');
    }
}
