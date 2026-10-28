<?php

namespace App\Filament\Resources\UnitTypes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UnitTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Unit Type Information')
                    ->description(
                        'Define the basic identity and description of this unit type.'
                    )
                    ->icon('heroicon-o-home-modern')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('name')
                                    ->label('Unit Type Name')
                                    ->placeholder('e.g. Two Bedroom Apartment')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),

                                TextInput::make('code')
                                    ->label('Unit Type Code')
                                    ->placeholder('e.g. 2BR-001')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->alphaDash()
                                    ->helperText(
                                        'Use a unique code for identification and reporting.'
                                    ),
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder(
                                'Describe this unit type, its layout and key features...'
                            )
                            ->rows(4)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                Section::make('Unit Specifications')
                    ->description(
                        'Specify the standard physical characteristics of this unit type.'
                    )
                    ->icon('heroicon-o-building-office-2')
                    ->schema([

                        Grid::make(4)
                            ->schema([

                                TextInput::make('bedrooms')
                                    ->label('Bedrooms')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->maxValue(20)
                                    ->default(0)
                                    ->required()
                                    ->suffix('Rooms'),

                                TextInput::make('bathrooms')
                                    ->label('Bathrooms')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->maxValue(20)
                                    ->default(1)
                                    ->required()
                                    ->suffix('Rooms'),

                                TextInput::make('size')
                                    ->label('Unit Size')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(999999.99)
                                    ->step(0.01)
                                    ->suffix('sqm')
                                    ->helperText('Size in square metres.'),

                                Select::make('size_unit')
                                    ->label('Size Unit')
                                    ->options([
                                        'sqm' => 'Square Metres (m²)',
                                        'sqft' => 'Square Feet (ft²)',
                                    ])
                                    ->default('sqm')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Pricing & Billing')
                    ->description(
                        'Configure the standard price and billing period for this unit type.'
                    )
                    ->icon('heroicon-o-banknotes')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('base_price')
                                    ->label('Base Price')
                                    ->numeric()
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->prefix('KES')
                                    ->placeholder('0.00')
                                    ->helperText(
                                        'Default price assigned to houses using this unit type.'
                                    ),

                                Select::make('price_period')
                                    ->label('Billing Period')
                                    ->options([
                                        'daily' => 'Per Day',
                                        'weekly' => 'Per Week',
                                        'monthly' => 'Per Month',
                                        'yearly' => 'Per Year',
                                        'one_time' => 'One Time',
                                    ])
                                    ->default('monthly')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Additional Information')
                    ->description(
                        'Store additional information related to this unit type.'
                    )
                    ->icon('heroicon-o-information-circle')
                    ->schema([

                        Grid::make(2)
                            ->schema([

                                TextInput::make('floor_plan')
                                    ->label('Floor Plan')
                                    ->placeholder('e.g. 2BR-standard-v1')
                                    ->maxLength(255)
                                    ->helperText(
                                        'Reference name or path for the floor plan.'
                                    ),

                                Textarea::make('amenities')
                                    ->label('Standard Amenities')
                                    ->placeholder(
                                        'e.g. Balcony, fitted kitchen, parking, water supply...'
                                    )
                                    ->rows(3)
                                    ->maxLength(1000),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Unit Type Status')
                    ->description(
                        'Control whether this unit type can be used for new houses.'
                    )
                    ->icon('heroicon-o-check-circle')
                    ->schema([

                        Select::make('is_active')
                            ->label('Status')
                            ->options([
                                true => 'Active',
                                false => 'Inactive',
                            ])
                            ->default(true)
                            ->required()
                            ->native(false)
                            ->helperText(
                                'Inactive unit types remain in the system but cannot be used for new assignments.'
                            ),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

