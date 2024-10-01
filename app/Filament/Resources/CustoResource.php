<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustoResource\Pages;
use App\Models\Custo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustoResource extends Resource
{
    protected static ?string $model = Custo::class;

    protected static ?string $navigationGroup = 'Registro';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->columns(12)
            ->schema([
                Forms\Components\TextInput::make('competencia')
                    ->mask('99/9999')
                    ->placeholder('12/2022')
                   ->regex( '/^(0[1-9]|1[0-2])\/\d{4}$/')
                    ->columnSpan(6)
                    ->required(),
                Forms\Components\DatePicker::make('data_vencimento')
                    ->columnSpan(6)
                    ->required(),
                Forms\Components\TextInput::make('valor_documento')
                    ->prefix('R$')
                    ->placeholder(placeholder: '0,00')
                    ->columnSpan(6)
                    ->required()
                    ->extraInputAttributes(['class' => 'money']),

                Forms\Components\Select::make('status')
                    ->options([
                        0 => 'Pendente',
                        1 => 'Pago',
                    ])
                    ->columnSpan(6)
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name',
                    fn(Builder $query) =>$query->where(
                        'id', auth()->user()->id
                    )
                )
                ->columnSpan(6)
                ->required(),

                Forms\Components\RichEditor::make('descricao')
                    ->columnSpan(12)
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('competencia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_vencimento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor_documento')
                    ->formatStateUsing(fn (string $state): string =>  "R$ {$state}")
                    ->sortable(),
                Tables\Columns\TextColumn::make('descricao')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustos::route('/'),
            'create' => Pages\CreateCusto::route('/create'),
            'edit' => Pages\EditCusto::route('/{record}/edit'),
        ];
    }
}
