<?php

namespace App\Filament\Resources\Floors\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FloorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Location Information')
                    ->description('Select where this floor belongs.')
                    ->icon('heroicon-o-map')
                    ->columns(2)
                    ->schema([

                        Select::make('estate_id')
                            ->label('Estate')
                            ->relationship('estate', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-building-office-2'),

                        Select::make('block_id')
                            ->label('Block')
                            ->relationship('block', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-building-office'),

                    ]),

                Section::make('Floor Information')
                    ->description('Basic information about this floor.')
                    ->icon('heroicon-o-building-library')
                    ->columns(3)
                    ->schema([

                        TextInput::make('name')
                            ->label('Floor Name')
                            ->placeholder('Ground Floor')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-o-home-modern'),

                        TextInput::make('code')
                            ->label('Floor Code')
                            ->placeholder('FLR-001')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-o-qr-code'),

                        TextInput::make('floor_number')
                            ->label('Floor Number')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(1)
                            ->prefixIcon('heroicon-o-hashtag'),

                        Textarea::make('description')
                            ->rows(4)
                            ->placeholder('Optional description...')
                            ->columnSpanFull(),

                    ]),

                Section::make('Occupancy')
                    ->description('Manage the units on this floor.')
                    ->icon('heroicon-o-chart-bar-square')
                    ->columns(3)
                    ->schema([

                        TextInput::make('total_units')
                            ->label('Total Units')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-home'),

                        TextInput::make('occupied_units')
                            ->label('Occupied Units')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-user-group'),

                        TextInput::make('vacant_units')
                            ->label('Vacant Units')
                            ->numeric()
                            ->required()
                            ->default(0)
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-key'),

                    ]),

                Section::make('Floor Status')
                    ->description('Current operational status.')
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->schema([

                        Select::make('status')
                            ->required()
                            ->native(false)
                            ->default('Active')
                            ->options([
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                                'Maintenance' => 'Maintenance',
                                'Reserved' => 'Reserved',
                            ]),

                        Placeholder::make('occupancy')
                            ->label('Occupancy')
                            ->content(function ($record) {

                                if (!$record || $record->total_units == 0) {
                                    return 'Calculated automatically';
                                }

                                return round(
                                    ($record->occupied_units / $record->total_units) * 100,
                                    1
                                ) . '% Occupied';
                            }),

                    ]),

                Section::make('System Information')
                    ->description('Automatically managed by the system.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([

                        Placeholder::make('created_at')
                            ->label('Created')
                            ->content(fn ($record) =>
                                $record?->created_at?->format('d M Y H:i')
                                ?? 'Will be generated automatically'
                            ),

                        Placeholder::make('updated_at')
                            ->label('Last Updated')
                            ->content(fn ($record) =>
                                $record?->updated_at?->diffForHumans()
                                ?? 'Not available'
                            ),

                    ]),

            ]);
    }
}