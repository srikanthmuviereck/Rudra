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
        Schema::create('security', function (Blueprint $table) {
            $table->id();
            $table->string('scrt_id')->unique();
            $table->string('name');
            $table->bigInteger('mobile')->unique();
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('area');
            $table->string('city');
            $table->string('state');            
            $table->string('address');
            $table->integer('pin');
            $table->string('api_token')->unique();
            $table->longtext('fcm_id');
            $table->string('device_name');
            $table->string('device_model');
            $table->string('os_version');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('status');
            $table->string('password');
            $table->string('supervised_by');
            $table->string('assign');
            $table->string('building_id');
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
        Schema::dropIfExists('security');
    }
};
