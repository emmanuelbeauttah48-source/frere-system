<?php

namespace App\Filament\Resources\Tenants\Schemas;

use App\Models\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Tenant Profile')
                    ->description('Basic identification and profile information.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([

                        FileUpload::make('profile_photo')
                            ->label('Profile Photo')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->directory('tenants/profile-photos')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Upload a clear tenant photo. Maximum size: 2MB.')
                            ->columnSpanFull(),

                        TextInput::make('first_name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('e.g. Emmanuel'),

                        TextInput::make('middle_name')
                            ->label('Middle Name')
                            ->maxLength(100)
                            ->placeholder('Optional'),

                        TextInput::make('last_name')
                            ->label('Last Name')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('e.g. Beauttah'),

                        TextInput::make('tenant_code')
                            ->label('Tenant ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(function () {
                                $nextId = (Tenant::max('id') ?? 0) + 1;

                                return 'TEN-' . str_pad(
                                    $nextId,
                                    5,
                                    '0',
                                    STR_PAD_LEFT
                                );
                            })
                            ->maxLength(50)
                            ->readOnly(),

                        TextInput::make('national_id')
                            ->label('National ID / Passport')
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('e.g. 12345678'),

                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->native(false)
                            ->maxDate(now()),

                        Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ])
                            ->native(false)
                            ->searchable(),

                    ])
                    ->columns(2),

                Section::make('Contact Information')
                    ->description('How the estate management can contact the tenant.')
                    ->icon('heroicon-o-phone')
                    ->schema([

                        TextInput::make('phone')
                            ->label('Primary Phone')
                            ->tel()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(30)
                            ->placeholder('e.g. 0712 345 678'),

                        TextInput::make('alternative_phone')
                            ->label('Alternative Phone')
                            ->tel()
                            ->maxLength(30)
                            ->placeholder('Optional'),

                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('tenant@example.com'),

                        Textarea::make('address')
                            ->label('Current Address')
                            ->rows(3)
                            ->placeholder('Enter the tenant\'s current address...')
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Section::make('Emergency Contact')
                    ->description('A person to contact in case of an emergency.')
                    ->icon('heroicon-o-shield-exclamation')
                    ->schema([

                        TextInput::make('emergency_contact_name')
                            ->label('Contact Name')
                            ->maxLength(255)
                            ->placeholder('Full name'),

                        TextInput::make('emergency_contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(30)
                            ->placeholder('Phone number'),

                        TextInput::make('emergency_contact_relationship')
                            ->label('Relationship')
                            ->maxLength(100)
                            ->placeholder('e.g. Spouse, Parent, Brother'),

                    ])
                    ->columns(3),

                Section::make('Employment Information')
                    ->description('Employment and occupation details.')
                    ->icon('heroicon-o-briefcase')
                    ->schema([

                        TextInput::make('occupation')
                            ->label('Occupation')
                            ->maxLength(255)
                            ->placeholder('e.g. Software Developer'),

                        TextInput::make('employer')
                            ->label('Employer / Company')
                            ->maxLength(255)
                            ->placeholder('e.g. ABC Company Ltd'),

                    ])
                    ->columns(2),

                Section::make('Tenancy Information')
                    ->description('Manage the tenant\'s current status and tenancy dates.')
                    ->icon('heroicon-o-building-office-2')
                    ->schema([

                        Select::make('status')
                            ->label('Tenant Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'former' => 'Former Tenant',
                                'blacklisted' => 'Blacklisted',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false)
                            ->searchable(),

                        DatePicker::make('move_in_date')
                            ->label('Move-in Date')
                            ->native(false),

                        DatePicker::make('move_out_date')
                            ->label('Move-out Date')
                            ->native(false)
                            ->afterOrEqual('move_in_date'),

                        Textarea::make('notes')
                            ->label('Additional Notes')
                            ->rows(4)
                            ->placeholder('Add any additional information about this tenant...')
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

            ]);
    }
}