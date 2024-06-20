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
        DB::beginTransaction();
        try {
            $updatedRecords = DB::table('student_lecture')
                ->where('created_at', '<', Carbon::now()->subMonth())
                ->update(['status' => 0]);

            DB::commit();

            if ($updatedRecords > 0) {
                $this->info("Updated $updatedRecords student lecture record(s) successfully.");
            } else {
                $this->info('No student lecture records to update.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to update student lecture records: ' . $e->getMessage());
        }
    }
}
