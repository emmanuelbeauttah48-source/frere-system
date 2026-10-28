<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('estate_id')
                ->constrained('estates')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            $table->unsignedInteger('total_floors')->default(0);
            $table->unsignedInteger('total_units')->default(0);

            $table->enum('status', [
                'Active',
                'Inactive',
                'Maintenance',
                'Under Construction',
            ])->default('Active');

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};