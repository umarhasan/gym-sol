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
        Schema::create('daily_audit', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->string('daily_audit_by')->nullable();
            $table->text('details')->nullable();
            $table->string('date')->nullable();
            $table->string('paid_to')->nullable();
            $table->integer('club_id')->nullable();
            $table->string('invoice_url')->nullable();
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
        Schema::dropIfExists('daily_audit');
    }
};
