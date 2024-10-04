<?php

namespace App\Filament\Resources\FlowResource\Pages;

use App\Filament\Resources\FlowResource;
use App\InputSchemas\NewsletterInput;
use Filament\Resources\Pages\CreateRecord;

class CreateFlow extends CreateRecord
{
    protected static string $resource = FlowResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['input_schema'] = NewsletterInput::schema();

        return $data;
    }
}
