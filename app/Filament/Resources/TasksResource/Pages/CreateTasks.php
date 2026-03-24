<?php

namespace App\Filament\Resources\TasksResource\Pages;

use App\Filament\Resources\TasksResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTasks extends CreateRecord
{
    protected static string $resource = TasksResource::class;

    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.tasks.index');
    }
}
