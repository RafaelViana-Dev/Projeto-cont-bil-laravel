<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountingResource\Pages;
use App\Filament\Resources\AccountingResource\RelationManagers;
use App\Models\Accounting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput; 
use Filament\Forms\Components\DatePicker; 


class AccountingResource extends Resource
{
    protected static ?string $model = Accounting::class;

    protected static ?string $navigationLabel = 'Contábil';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    #[\Override]
    public static function getModelLabel(): string
    {
        return __('Accounting');
    }

    public static function getPluralLabel(): string
    {
        return __('Registros Contábeis');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Select::make('type')
                    ->label(__('Tipo'))
                    ->options([
                        'receita' => 'Receita',
                        'despesa' => 'Despesa',
                        'transferencia' => 'Transferência',

                        ])
                    ->required()
                    ->native(false),

                    Forms\Components\TextInput::make('description')
                        ->label(__('Descrição'))
                        ->required()
                        ->maxLength(255),
    
                    Forms\Components\TextInput::make('value')
                    ->label(__('Valor'))
                    ->numeric() // Garante que apenas números podem ser inseridos
                    ->inputMode('decimal') // Ajuda com teclados em dispositivos móveis
                    ->step(0.01) // Permite valores com duas casas decimais
                    ->required()
                    ->prefix('R$') // Adiciona um prefixo para indicar moeda
                    ->suffix(''), // Remove o sufixo padrão de numérico se houver

                    Forms\Components\DatePicker::make('date')
                    ->label(__('Data de Ocorrência'))
                    ->required()
                    ->native(false) // Para melhor estilização
                    ->displayFormat('d/m/Y'), // Formato de exibição da data

                    Forms\Components\DatePicker::make('competence_month')
                    ->label(__('Mês de Competência'))
                    ->required()
                    ->native(false) // Para melhor estilização
                    ->displayFormat('m/Y') // Exibir apenas mês e ano
                    ->closeOnDateSelection() // Fechar ao selecionar
                    ->columns(1) // Ocupa uma coluna
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListAccountings::route('/'),
            'create' => Pages\CreateAccounting::route('/create'),
            'edit' => Pages\EditAccounting::route('/{record}/edit'),
        ];
    }
}
