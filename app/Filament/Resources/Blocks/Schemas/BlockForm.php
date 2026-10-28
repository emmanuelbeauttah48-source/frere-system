<?php

namespace App\Filament\Resources\Blocks\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('General Information')
                    ->description('Basic details about the residential block.')
                    ->icon('heroicon-o-building-office')
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
                            ->label('Block Name')
                            ->placeholder('Block A')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-o-home-modern')
                            ->autocomplete(false),

                        TextInput::make('code')
                            ->label('Block Code')
                            ->placeholder('BLK-A')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->maxLength(50)
                            ->prefixIcon('heroicon-o-qr-code')
                            ->helperText('Unique identifier for this block.'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'Active' => 'Active',
                                'Inactive' => 'Inactive',
                                'Maintenance' => 'Maintenance',
                                'Under Construction' => 'Under Construction',
                            ])
                            ->default('Active')
                            ->native(false)
                            ->searchable()
                            ->required(),

                        Textarea::make('description')
                            ->label('Description')
                            ->placeholder('Enter a brief description of the block...')
                            ->rows(4)
                            ->columnSpanFull()
                            ->maxLength(1000),
                    ]),

                Section::make('Building Statistics')
                    ->description('Define the size and capacity of this block.')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(3)
                    ->schema([

                        TextInput::make('total_floors')
                            ->label('Floors')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(1)
                            ->step(1)
                            ->prefixIcon('heroicon-o-building-library')
                            ->suffix('Floors'),

                        TextInput::make('total_units')
                            ->label('Units')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(1)
                            ->step(1)
                            ->prefixIcon('heroicon-o-squares-2x2')
                            ->suffix('Units'),

                        Placeholder::make('capacity_info')
                            ->label('Information')
                            ->content('These values are used for occupancy reports and analytics.'),

                    ]),

                Section::make('Management')
                    ->description('Administrative settings.')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->columns(2)
                    ->collapsible()
                    ->collapsed()
                    ->schema([

                        Placeholder::make('created')
                            ->label('Created At')
                            ->content(fn ($record) => $record?->created_at?->format('d M Y H:i') ?? 'Will be generated automatically'),

                        Placeholder::make('updated')
                            ->label('Last Updated')
                            ->content(fn ($record) => $record?->updated_at?->diffForHumans() ?? 'Not yet available'),

                    ]),

            ]);
    }
}