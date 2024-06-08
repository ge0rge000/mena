<?php

namespace App\Http\Livewire\Admin\Files;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;
use App\Models\Unit;

use Livewire\Component;

class AddFile extends Component
{
    // public function mount(Request $request,$year)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|unique:posts|max:255',
    //         'body' => 'required',
    //     ]);
    // }

    public function store(Request $request)
    {
        $new_file = new Files();
        $file = $request->file;
        $file_name = $file->getClientOriginalName();
        // $full_file_path = 'files/' . $file_name;
        
        $new_file->title = $request->file_title;
        $new_file->description = $request->description;
        $new_file->year_type = $request->year;
        $new_file->month = $request->month;
        $new_file->name = $file_name;
        $unit_id=$request->unit;
        $path = 'files';

        $uploaded_file= $file->move($path ,$file_name);

        $new_file->path = $uploaded_file;

        // Storage::disk('google')->putFileAs('1taL0Y0sp_rgvRn_AaCTiNZ_JbXUbiQAr', $file, $file_name);
        // Storage::disk('local')->putFileAs('livewire-tmp', $file, $file_name);
        // $new_file->path = 'livewire-tmp/' . $file_name;

        // $adapter = Storage::disk('google')->getAdapter();
        // $service = $adapter->getService();

        // $results = $service->files->listFiles([
        //     'q' => "name = '{$file_name}'",
        //     'spaces' => 'drive',
        // ]);
        // Update the path directly without querying Google Drive

        // $this->fileId = null;
        // foreach ($results->getFiles() as $file) {
        //     $this->fileId = $file->getId();
        //     $new_file->path=$this->fileId;
        //     break;
        // }
        $new_file->save(); 
        $new_file->units()->attach([
            $unit_id =>[
                'created_at'=>now()
            ]
        ]); 

        session()->flash('success_message', 'Upload file was successful');
        return redirect()->back();
    }


    public function render()
    {
        $units=Unit::all();
        $table = 'files';
        $column = 'year_type';
        $enumValues = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
        $enumOptions = [];

        if (isset($matches[1])) {
            $enumOptions = explode(',', $matches[1]);
            $enumOptions = array_map(function ($value) {
                return trim($value, "'");
            }, $enumOptions);
        }

        $table1 = 'files';
        $column1 = 'month';
        $enumValues = DB::select(DB::raw("SHOW COLUMNS FROM $table1 WHERE Field = '$column1'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumValues, $matches);
        $enumOptions1 = [];

        if (isset($matches[1])) {
            $enumOptions1 = explode(',', $matches[1]);
            $enumOptions1 = array_map(function ($value) {
                return trim($value, "'");
            }, $enumOptions1);
        }
        return view('livewire.admin.files.add-file',[
            'enumOptions'=>$enumOptions,
            'enumOptions1'=>$enumOptions1,
            'units'=>$units,
        ])->layout('layouts.admin');
    }
}
