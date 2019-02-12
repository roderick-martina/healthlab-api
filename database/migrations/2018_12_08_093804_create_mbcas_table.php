<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMbcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mbcas', function (Blueprint $table) {
            $table->increments('id');
            // $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('patient_id')->index();
            $table->string('identifier');
            $table->date('date_of_birth');
            $table->integer('age')->nullable();
            $table->string('gender');
            $table->string('doctor');
            // $table->string('education')->nullable();
            $table->longText('comment')->nullable();
            $table->dateTime('created');
            $table->string('ethnic');
            $table->dateTime('last_modified');
            $table->dateTime('timestamp')->nullable();
            $table->float('bmi_value', 4, 2)->nullable();
            $table->float('sds_bmi_value', 4, 2)->nullable();
            $table->integer('percentile_bmi_value')->nullable();
            $table->float('relative_fat_mass_value', 4, 2)->nullable();
            $table->float('absolute_fat_mass_value', 4, 2)->nullable();
            $table->float('fat_free_mass_value', 4, 2)->nullable();
            $table->float('skeletal_muscle_mass_value', 4, 2)->nullable();
            $table->float('smm_torso_value', 4, 2)->nullable();
            $table->float('smm_rl_value', 4, 2)->nullable(); //check of je hier niet 3,2 van kan maken als het nooit hoger is
            $table->float('smm_ll_value', 4, 2)->nullable();
            $table->float('smm_la_value', 4, 2)->nullable();
            $table->float('smm_ra_value', 4, 2)->nullable();
            $table->float('total_body_water_value', 3, 1)->nullable();
            $table->float('extracellular_water_value', 3, 1)->nullable();

            
            $table->float('waist_circumference_value', 3,1)->nullable();
            $table->float('sds_weight_value', 4, 2)->nullable();
            $table->float('weight_value', 4, 2)->nullable();
            $table->integer('percentile_weight_value')->nullable();
            $table->float('sds_height_value', 3, 2)->nullable();
            $table->float('height_value', 4, 1)->nullable();
            $table->integer('percentile_height_value')->nullable();
            $table->float('total_energy_expenditure_value', 6, 2)->nullable();
            $table->float('resting_energy_expenditure_value', 6, 2)->nullable();
            $table->float('ffmi_value', 4, 2)->nullable();
            $table->float('fmi_value', 4, 2)->nullable();
            $table->float('z_ffmi_value', 3, 2)->nullable();
            $table->float('z_fmi_value', 3, 2)->nullable();
            $table->float('bioelectric_impedance_vector_analysis_r_value', 4, 1)->nullable();
            $table->float('bioelectric_impedance_vector_analysis_xc_value', 4, 2)->nullable();
            $table->float('bioelectric_impedance_vector_analysis_zr_value', 2, 1)->nullable();
            $table->float('bioelectric_impedance_vector_analysis_zxc_value', 2, 1)->nullable();
            $table->float('phaseangle_value', 2, 1)->nullable();
            $table->float('sds_phaseangle_value', 2, 1)->nullable();
            $table->integer('percentile_phaseangle_value')->nullable();
            $table->integer('ecw_by_tbw_value')->nullable();

            
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('identifier')->references('identifier')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mbcas');
    }
}
