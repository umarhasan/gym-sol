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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->integer('uid')->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('father_name', 100)->nullable();
            $table->integer('nationality')->nullable();
            $table->integer('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('nic', 50)->nullable();
            $table->string('current_addr', 255)->nullable();
            $table->string('permanent_addr', 255)->nullable();
            $table->string('tel_number', 50)->nullable();
            $table->string('mob_number_1', 20)->nullable();
            $table->string('mob_number_2', 20)->nullable();
            $table->string('emergency_no', 20)->nullable();
            $table->string('emergency_cont_person', 100)->nullable();
            $table->date('join_date')->nullable();
            $table->date('confirmation_date')->nullable();
            $table->date('terminate_date')->nullable();
            $table->integer('marital_status')->default(1);
            $table->integer('employee_status')->nullable();
            $table->integer('dept_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('is_overtime')->nullable();
            $table->integer('is_latetime')->nullable();
            $table->integer('no_of_leave_encashment')->default(0);
            $table->double('fixed_le_amount')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps(3);
            $table->softDeletes(3);
            $table->timestamp('modified_at')->nullable(3);
            $table->integer('modified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
};
