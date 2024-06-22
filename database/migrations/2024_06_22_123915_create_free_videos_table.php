<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_videos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('link');
            $table->enum('status',[0,1]);
            $table->enum('year_type',['ONE','TWO','THREE']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_videos');
    }
}
