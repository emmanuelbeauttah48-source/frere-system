<?php

namespace App\Filament\Resources\Facilities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FacilitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()

            ->columns([

                ImageColumn::make('image')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(asset('images/facility-placeholder.png')),

                TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->alignCenter(),

                TextColumn::make('estate.name')
                    ->label('Estate')
                    ->icon('heroicon-o-building-office-2')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label('Facility')
                    ->icon('heroicon-o-home-modern')
                    ->description(fn ($record) => $record->code)
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                BadgeColumn::make('category')
                    ->colors([
                        'primary',
                    ])
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Location')
                    ->icon('heroicon-o-map-pin')
                    ->searchable(),

                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-user-group')
                    ->suffix(' People')
                    ->sortable(),

                TextColumn::make('booking_fee')
                    ->label('Booking Fee')
                    ->money('KES')
                    ->sortable(),

                IconColumn::make('is_bookable')
                    ->label('Bookable')
                    ->boolean(),

                IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),

                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                        'warning' => 'Maintenance',
                        'gray' => 'Closed',
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 'Active',
                        'heroicon-o-x-circle' => 'Inactive',
                        'heroicon-o-wrench-screwdriver' => 'Maintenance',
                        'heroicon-o-lock-closed' => 'Closed',
                    ]),

                TextColumn::make('next_maintenance')
                    ->label('Next Maintenance')
                    ->date('d M Y')
                    ->sortable(),

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
                    ->toggleable(),

            ])

            ->filters([

                SelectFilter::make('estate')
                    ->relationship('estate', 'name'),

                SelectFilter::make('category')
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

                SelectFilter::make('status')
                    ->options([
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                        'Maintenance' => 'Maintenance',
                        'Closed' => 'Closed',
                    ]),

                SelectFilter::make('is_available')
                    ->options([
                        1 => 'Available',
                        0 => 'Unavailable',
                    ]),

                SelectFilter::make('is_bookable')
                    ->options([
                        1 => 'Bookable',
                        0 => 'Not Bookable',
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

            ->defaultSort('id', 'desc')

            ->emptyStateHeading('No Facilities Found')
            ->emptyStateDescription('Create your first estate facility to get started.')
            ->emptyStateIcon('heroicon-o-building-office-2');
    }
}