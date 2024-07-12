<?php

namespace App\Filament\Resources\QuestionTypeResource\Pages;

use App\Filament\Resources\QuestionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionType extends CreateRecord
{
    protected static string $resource = QuestionTypeResource::class;
    // protected static bool $canCreateAnother = false;
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
