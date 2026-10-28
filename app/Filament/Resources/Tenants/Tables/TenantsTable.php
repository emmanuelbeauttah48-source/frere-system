<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            /*
            |--------------------------------------------------------------------------
            | Table Columns
            |--------------------------------------------------------------------------
            */

            ->columns([

                ImageColumn::make('profile_photo')
                    ->label('')
                    ->circular()
                    ->disk('public')
                    ->defaultImageUrl(
                        url('/images/default-avatar.png')
                    )
                    ->size(45)
                    ->toggleable(),

                TextColumn::make('tenant_code')
                    ->label('Tenant ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Tenant ID copied')
                    ->weight('bold')
                    ->color('primary'),

                TextColumn::make('full_name')
                    ->label('Tenant')
                    ->getStateUsing(fn ($record) => $record->full_name)
                    ->searchable([
                        'first_name',
                        'middle_name',
                        'last_name',
                    ])
                    ->sortable([
                        'first_name',
                        'last_name',
                    ])
                    ->weight('bold')
                    ->description(
                        fn ($record) => $record->email ?: 'No email provided'
                    ),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-o-phone')
                    ->iconColor('gray'),

                TextColumn::make('occupation')
                    ->label('Occupation')
                    ->searchable()
                    ->placeholder('Not provided')
                    ->toggleable(),

                TextColumn::make('move_in_date')
                    ->label('Move-in')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('Not set')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(
                        fn (string $state): string => match ($state) {
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                            'former' => 'Former',
                            'blacklisted' => 'Blacklisted',
                            default => ucfirst($state),
                        }
                    )
                    ->color(
                        fn (string $state): string => match ($state) {
                            'active' => 'success',
                            'inactive' => 'warning',
                            'former' => 'gray',
                            'blacklisted' => 'danger',
                            default => 'gray',
                        }
                    )
                    ->icon(
                        fn (string $state): string => match ($state) {
                            'active' => 'heroicon-o-check-circle',
                            'inactive' => 'heroicon-o-pause-circle',
                            'former' => 'heroicon-o-archive-box',
                            'blacklisted' => 'heroicon-o-no-symbol',
                            default => 'heroicon-o-question-mark-circle',
                        }
                    ),

                TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            /*
            |--------------------------------------------------------------------------
            | Filters
            |--------------------------------------------------------------------------
            */

            ->filters([

                SelectFilter::make('status')
                    ->label('Tenant Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'former' => 'Former Tenant',
                        'blacklisted' => 'Blacklisted',
                    ])
                    ->multiple(),

                Filter::make('recently_registered')
                    ->label('Recently Registered')
                    ->query(
                        fn (Builder $query): Builder =>
                            $query->where(
                                'created_at',
                                '>=',
                                now()->subDays(30)
                            )
                    ),

                Filter::make('currently_active')
                    ->label('Currently Active')
                    ->query(
                        fn (Builder $query): Builder =>
                            $query->where('status', 'active')
                    ),

                Filter::make('has_email')
                    ->label('Has Email')
                    ->query(
                        fn (Builder $query): Builder =>
                            $query->whereNotNull('email')
                                ->where('email', '!=', '')
                    ),

                Filter::make('has_profile_photo')
                    ->label('Has Profile Photo')
                    ->query(
                        fn (Builder $query): Builder =>
                            $query->whereNotNull('profile_photo')
                                ->where('profile_photo', '!=', '')
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | Record Actions
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->iconButton(),

                DeleteAction::make()
                    ->iconButton(),

            ])

            /*
            |--------------------------------------------------------------------------
            | Bulk Actions
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ])

            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            ->searchPlaceholder('Search tenants by name, ID, phone...')

            /*
            |--------------------------------------------------------------------------
            | Pagination
            |--------------------------------------------------------------------------
            */

            ->defaultPaginationPageOption(25)

            /*
            |--------------------------------------------------------------------------
            | Table Behaviour
            |--------------------------------------------------------------------------
            */

            ->striped()

            ->persistSortInSession()

            ->persistSearchInSession()

            ->persistFiltersInSession()

            ->persistColumnSearchesInSession()

            ->deferLoading()

            ->emptyStateHeading('No tenants found')

            ->emptyStateDescription(
                'Start by adding your first tenant to the estate management system.'
            )

            ->emptyStateIcon('heroicon-o-users');

    }
}