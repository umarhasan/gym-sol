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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('dob')->nullable();
            $table->integer('fees')->nullable();
            $table->string('gender')->default('male');
            $table->text('image');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('created_by')->nullable();
            $table->integer('is_active')->default(0);
            $table->integer('club_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->integer('is_welcome_msg_sent')->default(0);
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
};
