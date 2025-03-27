<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
           if (!Schema::hasColumn('reservations','stripe_session_id')){
            $table->string('stripe_session_id')->nullable();
           }
           if (!Schema::hasColumn('reservations','status')){
            $table->string('status')->nullable();
           }
           if (!Schema::hasColumn('reservations','stripe_payment_intent_id')){
            $table->string('stripe_payment_intent_id')->nullable();
           }

        });
    }

    /*
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            //
        });
    }
};
