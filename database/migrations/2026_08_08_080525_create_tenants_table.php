<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('tenant_code')->unique();

            $table->string('national_id')->unique()->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();

            $table->string('phone')->unique();
            $table->string('alternative_phone')->nullable();
            $table->string('email')->unique()->nullable();

            $table->string('profile_photo')->nullable();

            $table->text('address')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();

            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();

            $table->enum('status', [
                'active',
                'inactive',
                'former',
                'blacklisted',
            ])->default('active');

            $table->date('move_in_date')->nullable();
            $table->date('move_out_date')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};