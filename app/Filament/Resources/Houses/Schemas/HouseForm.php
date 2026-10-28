<?php

namespace App\Filament\Resources\Houses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Location Information')
                    ->description('Select where this house is located.')
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

                        Select::make('floor_id')
                            ->label('Floor')
                            ->relationship('floor', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-building-library'),

                        Select::make('unit_type_id')
                            ->label('Unit Type')
                            ->relationship('unitType', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-home-modern'),

                    ]),

                Section::make('House Details')
                    ->description('Basic information about the house.')
                    ->icon('heroicon-o-home')
                    ->columns(3)
                    ->schema([

                        TextInput::make('house_number')
                            ->label('House Number')
                            ->required()
                            ->maxLength(100)
                            ->prefixIcon('heroicon-o-hashtag'),

                        TextInput::make('house_code')
                            ->label('House Code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->prefixIcon('heroicon-o-qr-code'),

                        TextInput::make('title')
                            ->label('Title')
                            ->placeholder('Executive Apartment')
                            ->prefixIcon('heroicon-o-tag'),

                        TextInput::make('bedrooms')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-moon'),

                        TextInput::make('bathrooms')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(0)
                            ->prefixIcon('heroicon-o-sparkles'),

                        TextInput::make('area')
                            ->numeric()
                            ->suffix('m²')
                            ->prefixIcon('heroicon-o-arrows-pointing-out')
                            ->step(0.01),

                        Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),

                    ]),

                Section::make('Pricing')
                    ->description('Rental and payment information.')
                    ->icon('heroicon-o-banknotes')
                    ->columns(3)
                    ->schema([

                        TextInput::make('monthly_rent')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->step(0.01)
                            ->minValue(0),

                        TextInput::make('deposit')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->step(0.01)
                            ->minValue(0),

                        TextInput::make('service_charge')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->step(0.01)
                            ->minValue(0),

                    ]),

                Section::make('Utility Information')
                    ->description('Utility meter details.')
                    ->icon('heroicon-o-bolt')
                    ->columns(2)
                    ->schema([

                        TextInput::make('electricity_meter')
                            ->label('Electricity Meter')
                            ->prefixIcon('heroicon-o-bolt'),

                        TextInput::make('water_meter')
                            ->label('Water Meter')
                            ->prefixIcon('heroicon-o-beaker'),

                    ]),

                Section::make('Occupancy')
                    ->description('Current occupancy information.')
                    ->icon('heroicon-o-user-group')
                    ->columns(2)
                    ->schema([

                        Select::make('is_occupied')
                            ->label('Occupied')
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ])
                            ->native(false)
                            ->required(),

                        DatePicker::make('occupied_since')
                            ->native(false),

                        Select::make('is_available')
                            ->label('Available')
                            ->options([
                                1 => 'Available',
                                0 => 'Unavailable',
                            ])
                            ->native(false)
                            ->required(),

                        Select::make('status')
                            ->required()
                            ->native(false)
                            ->default('Vacant')
                            ->options([
                                'Vacant' => 'Vacant',
                                'Occupied' => 'Occupied',
                                'Reserved' => 'Reserved',
                                'Maintenance' => 'Maintenance',
                                'Unavailable' => 'Unavailable',
                            ]),

                    ]),

                Section::make('House Photo')
                    ->description('Upload a representative image of the house.')
                    ->icon('heroicon-o-photo')
                    ->schema([

                        FileUpload::make('photo')
                            ->image()
                            ->directory('houses')
                            ->imageEditor()
                            ->imagePreviewHeight('220')
                            ->downloadable()
                            ->openable(),

                    ]),

                Section::make('System Information')
                    ->description('Automatically generated by the system.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed()
                    ->columns(2)
                    ->schema([

                        Placeholder::make('created_at')
                            ->label('Created')
                            ->content(fn ($record) =>
                                $record?->created_at?->format('d M Y H:i')
                                ?? 'Will be generated automatically'),

                        Placeholder::make('updated_at')
                            ->label('Last Updated')
                            ->content(fn ($record) =>
                                $record?->updated_at?->diffForHumans()
                                ?? 'Not available'),

                    ]),

            ]);
    }
}