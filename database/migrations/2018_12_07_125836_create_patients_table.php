<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('user_id')->index();
            $table->string('identifier')->unique();
            $table->boolean('valid_identifier');
            $table->string('gender')->nullable();
            $table->string('research_project')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->boolean('manuel_created')->default(false);
            // $table->float('age', 4,2)->nullable();
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
