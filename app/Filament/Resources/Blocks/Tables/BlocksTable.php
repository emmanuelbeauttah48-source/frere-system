<?php

namespace App\Filament\Resources\Blocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class BlocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()

            ->columns([

                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('estate.name')
                    ->label('Estate')
                    ->icon('heroicon-o-building-office-2')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => "Estate ID: {$record->estate_id}"),

                TextColumn::make('name')
                    ->label('Block')
                    ->icon('heroicon-o-home-modern')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('code')
                    ->label('Code')
                    ->badge()
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Code copied!')
                    ->searchable(),

                TextColumn::make('total_floors')
                    ->label('Floors')
                    ->icon('heroicon-o-building-library')
                    ->badge()
                    ->color('warning')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('total_units')
                    ->label('Units')
                    ->icon('heroicon-o-squares-2x2')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                        'warning' => 'Maintenance',
                        'gray' => 'Under Construction',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Active',
                        'heroicon-o-x-circle' => 'Inactive',
                        'heroicon-o-wrench-screwdriver' => 'Maintenance',
                        'heroicon-o-hammer' => 'Under Construction',
                    ]),

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
                    ->label('Last Updated')
                    ->since()
                    ->icon('heroicon-o-clock')
                    ->toggleable(),
            ])

            ->filters([
                SelectFilter::make('estate')
                    ->relationship('estate', 'name'),

                SelectFilter::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Maintenance' => 'Maintenance',
                        'Under Construction' => 'Under Construction',
                    ]),
            ])

            ->recordActions([
                EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->color('danger'),
                ]),
            ])

            ->defaultSort('id', 'desc')

            ->emptyStateHeading('No Blocks Found')
            ->emptyStateDescription('Create your first residential block.')
            ->emptyStateIcon('heroicon-o-building-office');
    }
}