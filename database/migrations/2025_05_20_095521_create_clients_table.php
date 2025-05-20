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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('first_name');
            $table->foreignId('gender_id')->nullable()->constrained('genders')->nullOnDelete();
            $table->date('birth_date');
            $table->string('birth_place');
            $table->string('nationality');
            $table->string('permanent_address');
            $table->string('identity_number');
            $table->string('identity_image');
            $table->string('selfi');
            $table->string('phone');
            $table->string('profession')->nullable();
            $table->integer('children_under_15')->nullable();
            $table->string('email')->nullable();
            $table->string('origin')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->foreignId('identity_id')->nullable()->constrained('identities')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
