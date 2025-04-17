<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TasksResource\Pages;
use App\Filament\Resources\TasksResource\RelationManagers;
use App\Models\Tasks;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TasksResource extends Resource
{
    protected static ?string $model = Tasks::class;

    protected static ?string $navigationGroup = 'Gestión de Proyectos';
    protected static ?string $navigationLabel = 'Tareas';
    protected static ?string $pluralLabel = 'Tareas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('title')
                ->label('Título')
                ->required(),
            Forms\Components\Textarea::make('description')
                ->label('Descripción'),
            Forms\Components\Select::make('priority')
                ->label('Prioridad')
                ->options([
                    'low' => 'Baja',
                    'medium' => 'Media',
                    'high' => 'Alta',
                ])
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Estado')
                ->options([
                    'pending' => 'Pendiente',
                    'in_progress' => 'En proceso',
                    'completed' => 'Completado',
                ])
                ->label('Estado')
                ->required(),
            Forms\Components\Select::make('assigned_to')
                ->label('Asignado a')
                ->relationship('assignedTo', 'name')
                ->required(),
            Forms\Components\Select::make('created_by')
                ->label('Creado por')
                ->relationship('createdBy', 'name')
                ->required(),
            Forms\Components\FileUpload::make('image')
                ->label('Imagen')
                ->image(),
            Forms\Components\Select::make('reason')
                ->label('Razón')
                ->options([
                    'maintenance' => 'Mantenimiento',
                    'failure' => 'Falla',
                    'creation' => 'Creación',
                    'other' => 'Otro',
                ])
                ->default('other')
                ->required(),
            Forms\Components\DatePicker::make('approximate_completion_date')
                ->label('Fecha de finalización aproximada'),
            Forms\Components\TextInput::make('estimated_time')
                ->label('Tiempo estimado(horas)')
                ->numeric(),
            Forms\Components\Select::make('project_id')
                ->label('Proyecto')
                ->relationship('project', 'name')
                ->required(),
            ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Prioridad')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'Baja',
                        'medium' => 'Media',
                        'high' => 'Alta',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        default => 'secondary',
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('assigned_to')
                    ->label('Asignado a')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Razón')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'maintenance' => 'Mantenimiento',
                        'failure' => 'Falla',
                        'creation' => 'Creación',
                        'other' => 'Otro',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('approximate_completion_date')
                    ->label('Fecha de finalización aproximada')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'in_progress' => 'En progreso',
                        'completed' => 'Completado',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'in_progress' => 'warning',
                        'completed' => 'success',   
                        default => 'secondary',
                    })
                    ->badge(),
                Tables\Columns\TextColumn::make('project_id')
                    ->label('Proyecto')
                    ->numeric()
                    ->sortable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleStatus')
                    ->label('Iniciar')
                    ->icon('heroicon-o-play')
                    ->action(function ($record) {
                        $record->update([
                            'status' => $record->status === 'pending' ? 'in_progress' : 'pending',
                        ]);
                    })
                    ->color(fn ($record) => $record->status === 'pending' ? 'warning' : 'secondary'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTasks::route('/create'),
            'edit' => Pages\EditTasks::route('/{record}/edit'),
        ];
    }
}
