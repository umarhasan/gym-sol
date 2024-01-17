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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('active_whatsapp_no')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_phone')->nullable();
            $table->text('gym_name')->nullable();
            $table->string('gym_title')->nullable();
            $table->string('city')->nullable();
            $table->string('notification_days')->nullable();
            $table->string('location')->nullable();
            $table->string('about')->nullable();
            $table->string('contact_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('whatsapp_access_token')->nullable();
            $table->text('whatsapp_instant_id')->nullable();
            $table->text('qr_code')->nullable();
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
        Schema::dropIfExists('clubs');
    }
};
