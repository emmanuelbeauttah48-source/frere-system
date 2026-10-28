<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {

            $table->id();

            $table->foreignId('estate_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('block_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('code', 50)->unique();

            $table->integer('floor_number');

            $table->text('description')->nullable();

            $table->unsignedInteger('total_units')->default(0);

            $table->unsignedInteger('occupied_units')->default(0);

            $table->unsignedInteger('vacant_units')->default(0);

            $table->enum('status', [
                'Active',
                'Inactive',
                'Maintenance',
                'Reserved',
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
            $table->softDeletes();

            $table->index('estate_id');
            $table->index('block_id');
            $table->index('floor_number');
            $table->index('status');

            $table->unique(['block_id', 'floor_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};