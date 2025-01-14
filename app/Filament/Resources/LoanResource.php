<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
// use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('member_id')
                    ->label('Member')
                    ->relationship('member', 'name')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Loan Amount')
                    ->numeric()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $interest = $get('interest_rate') ?? 0;
                        $duration = $get('duration') ?? 0;
                        $total = $state + ($state * ($interest / 100) * ($duration / 12));
                        $set('total_payment', $total);
                    }),
                Forms\Components\TextInput::make('interest_rate')
                    ->label('Interest Rate (%)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->label('Duration (Months)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('total_payment')
                    ->label('Total Payment')
                    ->numeric()
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
                Forms\Components\DatePicker::make('loan_date')
                    ->label('Loan Date')
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
                    ->label('Loan Amount')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->label('Interest Rate (%)'),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration (Months)'),
                Tables\Columns\TextColumn::make('total_payment')
                    ->label('Total Payment')
                    ->money('idr'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('loan_date')
                    ->label('Loan Date')
                    ->date(),
            ])
            ->filters([
                //
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
            'index' => Pages\LoanLists::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
