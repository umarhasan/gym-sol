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
        Schema::create('emp_attendance', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->date('attendance_date');
            $table->string('check_in', 20)->nullable();
            $table->string('check_out', 20)->nullable();
            $table->integer('shift_id')->nullable();
            $table->integer('notes')->default(1);
            $table->integer('status')->default(1);
            $table->date('created_at')->nullable();
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
        Schema::dropIfExists('emp_attendance');
    }
};
