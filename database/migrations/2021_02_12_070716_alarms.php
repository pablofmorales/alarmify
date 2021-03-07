<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Alarms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {

            $table->id('id');
            $table->unsignedBigInteger('application_id');
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->char('status', 1);
            $table->timestamps();
            $table->foreign('application_id')->references('id')->on('applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alarms');
    }
}
