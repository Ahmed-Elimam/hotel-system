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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'national_id')) {
                $table->unsignedBigInteger('national_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'avatar_image')) {
                $table->string('avatar_image', 255)->default('avatar.jpg');
            }
            if (!Schema::hasColumn('users', 'last_login_date')) {
                $table->timestamp('last_login_date')->nullable();
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 50)->nullable();
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female'])->nullable();
            }
            if (!Schema::hasColumn('users', 'country_id')) {
                $table->unsignedBigInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('countries');
            }
            if (!Schema::hasColumn('users', 'creator_id')) {
                $table->unsignedBigInteger('creator_id')->nullable();
                $table->foreign('creator_id')->references('id')->on('users');
            }
            if (!Schema::hasColumn('users', 'approver_id')) {
                $table->unsignedBigInteger('approver_id')->nullable();
                $table->foreign('approver_id')->references('id')->on('users');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'national_id')) {
                $table->dropColumn('national_id');
            }
            if (Schema::hasColumn('users', 'avatar_image')) {
                $table->dropColumn('avatar_image');
            }
            if (Schema::hasColumn('users', 'last_login_date')) {
                $table->dropColumn('last_login_date');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('users', 'country_id')) {
                $table->dropForeign(['country_id']);
                $table->dropColumn('country_id');
            }
            if (Schema::hasColumn('users', 'creator_id')) {
                $table->dropForeign(['creator_id']);
                $table->dropColumn('creator_id');
            }
            if (Schema::hasColumn('users', 'approver_id')) {
                $table->dropForeign(['approver_id']);
                $table->dropColumn('approver_id');
            }
        });
    }
};
