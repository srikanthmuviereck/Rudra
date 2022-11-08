<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor_field_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('building_id')->nullable();
            $table->string('check_uniform')->nullable();
            $table->string('meet_client_update')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('night_check_update')->nullable();
            $table->string('current_strength_details')->nullable();
            $table->string('post_vacancy')->nullable();
            $table->string('client_feedback')->nullable();
            $table->string('day_visit_update')->nullable();
            $table->string('guards_training')->nullable();
            $table->longtext('guards_images')->nullable();
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
        Schema::dropIfExists('supervisor_field_trackings');
    }
};
