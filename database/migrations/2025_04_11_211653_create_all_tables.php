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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('profile_picture')->nullable();
            $table->enum('role', ['admin', 'puskesmas']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puskesmas_id')->constrained()->cascadeOnDelete();
            $table->string('nik', 16)->nullable()->unique();
            $table->string('bpjs_number', 20)->nullable();
            $table->string('name');
            $table->text('address')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('has_ht')->default(false);
            $table->boolean('has_dm')->default(false);
            $table->timestamps();
        });

        Schema::create('ht_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('puskesmas_id')->constrained()->cascadeOnDelete();
            $table->date('examination_date');
            $table->integer('systolic');
            $table->integer('diastolic');
            $table->integer('year');
            $table->integer('month');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });

        Schema::create('dm_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('puskesmas_id')->constrained()->cascadeOnDelete();
            $table->date('examination_date');
            $table->enum('examination_type', ['hba1c', 'gdp', 'gd2jpp', 'gdsp']);
            $table->decimal('result', 8, 2);
            $table->integer('year');
            $table->integer('month');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });

        Schema::create('yearly_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puskesmas_id')->constrained()->cascadeOnDelete();
            $table->enum('disease_type', ['ht', 'dm']);
            $table->integer('year');
            $table->integer('target_count');
            $table->timestamps();
            
            $table->unique(['puskesmas_id', 'disease_type', 'year']);
        });

        Schema::create('user_refresh_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('refresh_token', 100);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_refresh_tokens');
        Schema::dropIfExists('yearly_targets');
        Schema::dropIfExists('dm_examinations');
        Schema::dropIfExists('ht_examinations');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('puskesmas');
        Schema::dropIfExists('users');
    }
};