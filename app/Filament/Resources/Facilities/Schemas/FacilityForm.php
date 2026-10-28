<?php

namespace App\Filament\Resources\Facilities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacilityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Facility Information')
                    ->description('Basic information about the estate facility.')
                    ->icon('heroicon-o-building-office-2')
                    ->columns(2)
                    ->schema([

                        Select::make('estate_id')
                            ->label('Estate')
                            ->relationship('estate', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-o-map'),

                        TextInput::make('name')
                            ->label('Facility Name')
                            ->placeholder('Swimming Pool')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-o-home-modern'),

                        TextInput::make('code')
                            ->label('Facility Code')
                            ->placeholder('FAC-001')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->live(onBlur: true)
                            ->prefixIcon('heroicon-o-qr-code'),

                        Select::make('category')
                            ->label('Category')
                            ->searchable()
                            ->native(false)
                            ->required()
                            ->options([
                                'Recreation' => 'Recreation',
                                'Sports' => 'Sports',
                                'Security' => 'Security',
                                'Parking' => 'Parking',
                                'Utility' => 'Utility',
                                'Community' => 'Community',
                                'Children' => 'Children',
                                'Commercial' => 'Commercial',
                                'Health' => 'Health',
                                'Religious' => 'Religious',
                            ]),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Provide a brief description...')
                            ->rows(4)
                            ->columnSpanFull(),

                    ]),

                Section::make('Location Details')
                    ->description('Specify where the facility is located.')
                    ->icon('heroicon-o-map-pin')
                    ->columns(3)
                    ->schema([

                        TextInput::make('location')
                            ->placeholder('Near Main Entrance')
                            ->prefixIcon('heroicon-o-map-pin'),

                        TextInput::make('block')
                            ->placeholder('Block A')
                            ->prefixIcon('heroicon-o-building-office'),

                        TextInput::make('floor')
                            ->placeholder('Ground Floor')
                            ->prefixIcon('heroicon-o-building-library'),

                    ]),

                Section::make('Capacity & Booking')
                    ->description('Manage booking and usage information.')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(3)
                    ->schema([

                        TextInput::make('capacity')
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()
                            ->suffix('People')
                            ->prefixIcon('heroicon-o-user-group'),

                        Select::make('is_bookable')
                            ->label('Bookable')
                            ->native(false)
                            ->required()
                            ->options([
                                1 => 'Yes',
                                0 => 'No',
                            ]),

                        TextInput::make('booking_fee')
                            ->numeric()
                            ->default(0)
                            ->prefix('KES')
                            ->minValue(0)
                            ->step(0.01)
                            ->prefixIcon('heroicon-o-banknotes'),

                    ]),

                Section::make('Maintenance Schedule')
                    ->description('Track maintenance dates.')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->columns(2)
                    ->collapsible()
                    ->schema([

                        DatePicker::make('last_maintenance')
                            ->native(false),

                        DatePicker::make('next_maintenance')
                            ->native(false),

                    ]),

                Section::make('Status')
                    ->icon('heroicon-o-shield-check')
                    ->columns(2)
                    ->schema([

                        Select::make('status')
                            ->required()
                            ->native(false)
                            ->options([
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                                'Maintenance' => 'Maintenance',
                                'Closed' => 'Closed',
                            ])
                            ->default('Active'),

                        Select::make('is_available')
                            ->label('Available')
                            ->required()
                            ->native(false)
                            ->options([
                                1 => 'Available',
                                0 => 'Unavailable',
                            ]),

                    ]),

                Section::make('Facility Image')
                    ->description('Upload an image for easier identification.')
                    ->icon('heroicon-o-photo')
                    ->schema([

                        FileUpload::make('image')
                            ->image()
                            ->directory('facilities')
                            ->imageEditor()
                            ->imagePreviewHeight('220')
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),

                    ]),

                Section::make('System Information')
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