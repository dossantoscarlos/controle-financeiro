<?php

namespace App\Filament\Resources\CustoResource\Pages;

use App\Filament\Resources\CustoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCusto extends EditRecord
{
    protected static string $resource = CustoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
