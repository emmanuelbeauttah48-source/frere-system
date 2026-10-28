<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('estate_id')
                ->constrained('estates')
                ->cascadeOnDelete();

            $table->foreignId('block_id')
                ->constrained('blocks')
                ->cascadeOnDelete();

            $table->foreignId('floor_id')
                ->constrained('floors')
                ->cascadeOnDelete();

            $table->foreignId('unit_type_id')
                ->constrained('unit_types')
                ->cascadeOnDelete();
                
            $table->string('house_number', 50);

            $table->string('house_code', 100)
                ->unique();

            $table->string('title')
                ->nullable();

            $table->string('slug')
                ->nullable()
                ->unique();

            $table->unsignedTinyInteger('bedrooms')
                ->default(1);

            $table->unsignedTinyInteger('bathrooms')
                ->default(1);

            $table->unsignedTinyInteger('balconies')
                ->default(0);

            $table->decimal('area', 10, 2)
                ->nullable()
                ->comment('Area in square metres');

            $table->text('description')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->decimal('monthly_rent', 12, 2);

            $table->decimal('deposit', 12, 2)
                ->default(0);

            $table->decimal('service_charge', 12, 2)
                ->default(0);

            $table->enum('rent_frequency', [
                'Monthly',
                'Quarterly',
                'Biannually',
                'Annually',
            ])->default('Monthly');

            $table->string('electricity_meter', 100)
                ->nullable();

            $table->string('water_meter', 100)
                ->nullable();

            $table->string('gas_meter', 100)
                ->nullable();

            $table->boolean('is_occupied')
                ->default(false);

            $table->date('occupied_since')
                ->nullable();

            $table->date('available_from')
                ->nullable();

            $table->enum('status', [
                'Vacant',
                'Occupied',
                'Reserved',
                'Maintenance',
                'Unavailable',
            ])->default('Vacant');

            $table->boolean('is_available')
                ->default(true);

            $table->string('photo')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            $table->index('estate_id');
            $table->index('block_id');
            $table->index('floor_id');
            $table->index('unit_type_id');

            $table->index('status');
            $table->index('is_occupied');
            $table->index('is_available');

            $table->index([
                'estate_id',
                'block_id',
            ]);

            $table->index([
                'block_id',
                'floor_id',
            ]);

            $table->unique([
                'block_id',
                'house_number',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};