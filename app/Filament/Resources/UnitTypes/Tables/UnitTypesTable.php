<?php

namespace App\Filament\Resources\UnitTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;

class UnitTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Unit Type')
                    ->description(
                        fn ($record) => $record->description
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon(Heroicon::OutlinedHomeModern)
                    ->wrap(),

                TextColumn::make('code')
                    ->label('Code')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Unit type code copied'),

                TextColumn::make('bedrooms')
                    ->label('Beds')
                    ->numeric()
                    ->alignCenter()
                    ->sortable()
                    ->icon(Heroicon::OutlinedBuildingOffice2)
                    ->formatStateUsing(
                        fn ($state) => $state == 0
                            ? 'Studio'
                            : $state
                    ),

                TextColumn::make('bathrooms')
                    ->label('Baths')
                    ->numeric()
                    ->alignCenter()
                    ->sortable()
                    ->icon(Heroicon::OutlinedSparkles),

                TextColumn::make('size')
                    ->label('Floor Area')
                    ->alignCenter()
                    ->sortable()
                    ->formatStateUsing(
                        fn ($state, $record) => $state
                            ? number_format((float) $state, 2) . ' ' . $record->size_unit
                            : 'N/A'
                    ),

                TextColumn::make('base_price')
                    ->label('Base Price')
                    ->money('KES')
                    ->sortable()
                    ->placeholder('Not Set'),

                TextColumn::make('price_period')
                    ->label('Billing')
                    ->badge()
                    ->alignCenter()
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                            'monthly' => 'Monthly',
                            'yearly' => 'Yearly',
                            'one_time' => 'One Time',
                            default => 'N/A',
                        }
                    )
                    ->color('gray'),

                TextColumn::make('houses_count')
                    ->label('Houses')
                    ->counts('houses')
                    ->alignCenter()
                    ->sortable()
                    ->icon(Heroicon::OutlinedHome),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->alignCenter()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->defaultSort('created_at', 'desc')

            ->filters([
                SelectFilter::make('price_period')
                    ->label('Billing Period')
                    ->options([
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                        'one_time' => 'One Time',
                    ]),

                SelectFilter::make('bedrooms')
                    ->label('Bedrooms')
                    ->options([
                        0 => 'Studio',
                        1 => '1 Bedroom',
                        2 => '2 Bedrooms',
                        3 => '3 Bedrooms',
                        4 => '4 Bedrooms',
                        5 => '5+ Bedrooms',
                    ])
                    ->query(function ($query, array $data) {
                        if (
                            isset($data['value']) &&
                            $data['value'] !== null
                        ) {
                            if ($data['value'] == 5) {
                                $query->where('bedrooms', '>=', 5);
                            } else {
                                $query->where(
                                    'bedrooms',
                                    $data['value']
                                );
                            }
                        }
                    }),

                TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('All Unit Types')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])

            ->recordActions([
                EditAction::make()
                    ->icon(Heroicon::OutlinedPencil)
                    ->color('primary'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
