<?php

namespace App\Filament\Resources\Estates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EstateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Estate Details')
                    ->description('Basic information about the estate.')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([

                                TextInput::make('name')
                                    ->label('Estate Name')
                                    ->placeholder('e.g. Frere Town Estate')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('code')
                                    ->label('Estate Code')
                                    ->placeholder('FRR001')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50),

                                TextInput::make('location')
                                    ->label('Location')
                                    ->placeholder('Nyali, Mombasa')
                                    ->maxLength(255),

                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('active')
                                    ->native(false)
                                    ->required(),
                            ]),
                    ]),

                Section::make('Management')
                    ->description('Estate management information.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make([
                            'default' => 1,
                            'md' => 2,
                        ])
                            ->schema([

                                TextInput::make('manager_name')
                                    ->label('Manager Name')
                                    ->placeholder('John Doe')
                                    ->maxLength(255),

                                TextInput::make('contact_phone')
                                    ->label('Phone Number')
                                    ->tel()
                                    ->placeholder('+254 700 000 000')
                                    ->maxLength(20),

                                TextInput::make('contact_email')
                                    ->label('Email Address')
                                    ->email()
                                    ->placeholder('manager@example.com')
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Section::make('Description')
                    ->description('Additional information about the estate.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Textarea::make('description')
                            ->placeholder('Enter a brief description...')
                            ->rows(6)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}