<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingResource\Pages;
// use App\Filament\Resources\SavingResource\RelationManagers;
use App\Models\Saving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;
    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->label('Member')
                    ->relationship('member', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Saving Amount')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'obligatory' => 'Obligatory',
                        'voluntary' => 'Voluntary',
                        'primary' => 'Primary',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Saving Date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->label('Member Name'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Saving Amount')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'primary' => 'info',
                        'obligatory' => 'danger',
                        'voluntary' => 'gray',
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->label('Saving Date')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'obligatory' => 'Obligatory',
                        'voluntary' => 'Voluntary',
                        'primary' => 'Primary',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Finance';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\SavingLists::route('/'),
            'create' => Pages\CreateSaving::route('/create'),
            'edit' => Pages\EditSaving::route('/{record}/edit'),
        ];
    }
}
