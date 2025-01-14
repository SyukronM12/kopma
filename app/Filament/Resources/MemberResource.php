<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
// use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
// use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// use Illuminate\Support\Facades\Gate;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    // protected static ?string $navigationGroup = 'Member Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->unique('members', 'email', ignoreRecord: true)
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel()
                    ->required()
                    ->rule('regex:/^([0-9\s\-\+\(\)]*)$/')
                    ->placeholder('Format: 08xxxxxxxxxx'),
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required()
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone'),
                Tables\Columns\TextColumn::make('address')
                    ->label('Address'),
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
            // RelationManager\LoanRelationManager::class
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Membership';
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
