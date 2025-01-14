<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\Saving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Event Name')
                    ->required()
                    ->maxlength(255),
                Forms\Components\TextArea::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->rows(3),
                Forms\Components\TextInput::make('budegt')
                    ->label('Budget')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->rules([
                        fn() => function (string $attribute, $value, \Closure $fail) {
                            $totalSavings = Saving::where('status', 'approved')->sum('amount');
                            if ($value > $totalSavings)
                                $fail("Budget exceeds total available reserves (Rp {$totalSavings})");
                        }
                    ]),
                Forms\Components\TextInput::make('actual_cost')
                    ->label('Actual Cost')
                    ->numeric()
                    ->prefix('Rp')
                    ->nullable(),
                Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'planned' => 'Planned',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('planned'),
                Forms\Components\TextArea::make('notes')
                    ->label('Notes')
                    ->nullable()
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Acara')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('budget')
                    ->label('Anggaran')
                    ->money('idr')
                    ->sortable(),

                Tables\Columns\TextColumn::make('actual_cost')
                    ->label('Biaya Aktual')
                    ->money('idr')
                    ->sortable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'planned' => 'gray',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    }),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'planned' => 'Planned',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),

                Tables\Filters\Filter::make('start_date')
                    ->form([
                        Forms\Components\DatePicker::make('start_date_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('start_date_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['start_date_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                            );
                    })

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
        return 'Management';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
