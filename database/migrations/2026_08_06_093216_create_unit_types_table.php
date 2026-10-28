<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();

            $table->unsignedTinyInteger('bedrooms')->default(1);
            $table->unsignedTinyInteger('bathrooms')->default(1);
            $table->decimal('size', 10, 2)->nullable(); 
            $table->string('size_unit')->default('sqm');

            $table->decimal('base_price', 15, 2)->nullable();
            $table->enum('price_period', [
                'monthly',
                'yearly',
                'daily',
                'weekly',
                'one_time',
            ])->default('monthly');

            $table->boolean('is_active')->default(true);

            $table->string('floor_plan')->nullable();
            $table->text('amenities')->nullable();

            $table->timestamps();

            $table->index('name');
            $table->index('code');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_types');
    }
};

