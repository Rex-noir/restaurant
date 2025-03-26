<?php

namespace App\enums;

use Filament\Support\Contracts\HasLabel;

enum MenuOptionTypesEnum: string implements HasLabel
{
    case SELECT = 'select';
    case CHECKBOX = 'checkbox';
    case RADIO = 'radio';
    /**
     * @inheritDoc
     */
    public function getLabel(): string|null
    {
        return match ($this) {
            self::SELECT => 'Select',
            self::CHECKBOX => 'Checkbox',
            self::RADIO => 'Radio',
        };
    }
}
