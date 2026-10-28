<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('estate_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('code', 50)->unique();
            $table->string('category')->nullable();

            $table->text('description')->nullable();

            $table->string('location')->nullable();
            $table->string('floor')->nullable();
            $table->string('block')->nullable();

            $table->unsignedInteger('capacity')->default(0);

            $table->boolean('is_bookable')->default(false);
            $table->decimal('booking_fee', 12, 2)->default(0);

            $table->date('last_maintenance')->nullable();
            $table->date('next_maintenance')->nullable();

            $table->boolean('is_available')->default(true);

            $table->enum('status', [
                'Active',
                'Inactive',
                'Maintenance',
                'Closed'
            ])->default('Active');

            $table->string('image')->nullable();

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
            $table->index('status');
            $table->index('category');
            $table->index('is_available');
            $table->index('is_bookable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};