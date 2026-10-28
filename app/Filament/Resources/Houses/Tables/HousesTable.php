<?php

namespace App\Filament\Resources\Houses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class HousesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('photo')
                    ->label('Photo')
                    ->circular()
                    ->defaultImageUrl(asset('images/no-house.png')),

                Tables\Columns\TextColumn::make('house_number')
                    ->label('House No.')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('house_code')
                    ->label('Code')
                    ->searchable()
                    ->copyable()
                    ->badge(),

                Tables\Columns\TextColumn::make('estate.name')
                    ->label('Estate')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('block.name')
                    ->label('Block')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('floor.name')
                    ->label('Floor')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('unitType.name')
                    ->label('Unit Type')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bedrooms')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('bathrooms')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('monthly_rent')
                    ->label('Rent')
                    ->money('KES')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_occupied')
                    ->label('Occupied')
                    ->boolean(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'Vacant',
                        'danger' => 'Occupied',
                        'warning' => 'Maintenance',
                        'info' => 'Reserved',
                        'gray' => 'Unavailable',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('estate')
                    ->relationship('estate', 'name'),

                Tables\Filters\SelectFilter::make('block')
                    ->relationship('block', 'name'),

                Tables\Filters\SelectFilter::make('floor')
                    ->relationship('floor', 'name'),

                Tables\Filters\SelectFilter::make('unitType')
                    ->relationship('unitType', 'name'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Vacant' => 'Vacant',
                        'Occupied' => 'Occupied',
                        'Reserved' => 'Reserved',
                        'Maintenance' => 'Maintenance',
                        'Unavailable' => 'Unavailable',
                    ]),

            ])

            ->defaultSort('house_number')

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}