<?php

namespace App\Filament\Resources\Floors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;

class FloorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()

            ->columns([

                TextColumn::make('id')
                    ->label('#')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('estate.name')
                    ->label('Estate')
                    ->icon('heroicon-o-building-office-2')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('block.name')
                    ->label('Block')
                    ->icon('heroicon-o-building-office')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Floor')
                    ->icon('heroicon-o-building-library')
                    ->description(fn ($record) => $record->code)
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('floor_number')
                    ->label('Level')
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-hashtag')
                    ->sortable(),

                TextColumn::make('total_units')
                    ->label('Units')
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-home')
                    ->sortable(),

                TextColumn::make('occupied_units')
                    ->label('Occupied')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-user-group')
                    ->sortable(),

                TextColumn::make('vacant_units')
                    ->label('Vacant')
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-o-key')
                    ->sortable(),

                TextColumn::make('occupancy_percentage')
                    ->label('Occupancy')
                    ->suffix('%')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 90 => 'danger',
                        $state >= 70 => 'warning',
                        default => 'success',
                    }),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                        'warning' => 'Maintenance',
                        'primary' => 'Reserved',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Active',
                        'heroicon-o-x-circle' => 'Inactive',
                        'heroicon-o-wrench-screwdriver' => 'Maintenance',
                        'heroicon-o-bookmark' => 'Reserved',
                    ]),

                IconColumn::make('is_full')
                    ->label('Full')
                    ->boolean(),

                TextColumn::make('creator.name')
                    ->label('Created By')
                    ->icon('heroicon-o-user')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->date('d M Y')
                    ->description(fn ($record) => $record->created_at->format('H:i'))
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->toggleable(),

            ])

            ->filters([

                SelectFilter::make('estate')
                    ->relationship('estate', 'name'),

                SelectFilter::make('block')
                    ->relationship('block', 'name'),

                SelectFilter::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Maintenance' => 'Maintenance',
                        'Reserved' => 'Reserved',
                    ]),

            ])

            ->recordActions([

                EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),

            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),

            ])

            ->defaultSort('floor_number')

            ->emptyStateHeading('No Floors Found')
            ->emptyStateDescription('Create the first floor for one of your blocks.')
            ->emptyStateIcon('heroicon-o-building-library');
    }
}