<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodpodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodpods', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index()->nullable();
            $table->string('identifier')->nullable();

            $table->dateTime('test_date');
            $table->float('age', 4,2);
            $table->string('gender');
            $table->float('height_cm',4,1);
            $table->float('height_in',3,1);
            $table->string('id_1')->nullable();
            $table->string('id_2')->nullable();
            $table->string('ethnicity');
            $table->string('operator');
            $table->integer('test_no');
            $table->string('density_model');
            $table->string('tgv_model');
            $table->float('fat_percentage',3,1);
            $table->float('ffm_percentage',3,1);
            $table->float('fat_mass_kg',5,3);
            $table->float('fat_mass_lb',5,3);
            $table->float('fat_free_mass_kg',5,3);
            $table->float('fat_free_mass_lb',6,3);
            $table->string('body_mass_kg');
            $table->string('body_mass_lb');
            $table->integer('estimate_rmr_kcal_day')->nullable();
            $table->integer('estimate_tee_kcal_day')->nullable();
            $table->string('activity_level')->nullable();
            $table->float('body_volume',6,3);
            $table->float('bd_kg_l',5,3);
            $table->string('volume1_l');
            $table->string('volume2_l');
            $table->string('volume3_l')->nullable();
            $table->float('dfm_kg_l',5,4)->nullable();
            $table->float('dffm_kg_l',5,3)->nullable();
            $table->float('tgv_l',4,3);
            $table->float('predicted_tgv_l',4,3);
            $table->string('bsa_cm2');
            $table->longText('comments')->nullable();


            $table->foreign('identifier')->references('identifier')->on('patients')->onDelete('cascade');

            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('bodpods');
    }
}
