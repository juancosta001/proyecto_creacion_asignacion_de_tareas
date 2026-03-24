<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUsers extends EditRecord
{
    protected static string $resource = UsersResource::class;

    protected string $selectedRole = 'desarrollador';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->selectedRole = $data['role'] ?? $this->record->roles->first()?->name ?? 'desarrollador';
        unset($data['role']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles([$this->selectedRole]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Eliminar'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.users.index');
    }
}
