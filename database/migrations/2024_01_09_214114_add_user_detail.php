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
            $table->renameColumn('name','first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('phone');
            $table->date('joined_date')->nullable();
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_active')->default(true);
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'name');
            $table->dropColumn('middle_name');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('joined_date');
            $table->dropColumn('address');
            $table->dropColumn('photo');
            $table->dropColumn('is_active');

        });    }
};
