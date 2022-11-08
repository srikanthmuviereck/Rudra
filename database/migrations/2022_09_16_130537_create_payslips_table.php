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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('empid')->nullable();
            $table->string('designation')->nullable();
            $table->string('uan')->nullable();
            $table->string('esino')->nullable();
            $table->string('monthandyear')->nullable();
            $table->string('clientname')->nullable();
            $table->string('bank')->nullable();
            $table->string('bankaccno')->nullable();
            $table->string('bankifsccode')->nullable();
            $table->string('noofduties')->nullable();
            $table->string('overtime')->nullable();
            $table->string('totalworkingdays')->nullable();
            $table->string('basicpay')->nullable();
            $table->string('dapay')->nullable();
            $table->string('otpay')->nullable();
            $table->string('epf')->nullable();
            $table->string('esi')->nullable();
            $table->string('uniformdeduction')->nullable();
            $table->string('advance')->nullable();
            $table->string('others')->nullable();
            $table->string('totaldeduction')->nullable();
            $table->string('gross_salary')->nullable();
            $table->string('net_pay')->nullable();
            $table->string('pdf_file')->nullable();
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
        Schema::dropIfExists('payslips');
    }
};
