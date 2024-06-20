<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class UpdateStudentLectureStatus extends Command
{
    protected $signature = 'update:student-lecture-status';
    protected $description = 'Update status column in student_lecture table based on created_at date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $records = DB::table('student_lecture')->get();

        foreach ($records as $record) {
            // Assuming you want to update status if the created_at is older than one month
            if (Carbon::parse($record->created_at)->lt(Carbon::now()->subMonth())) {
                DB::table('student_lecture')
                    ->where('id', $record->id)
                    ->update(['status' => 0]);
            }
        }

        $this->info('Student lecture status updated successfully.');
    }
}
