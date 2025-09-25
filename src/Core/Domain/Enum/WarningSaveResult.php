<?php

namespace App\Core\Domain\Enum;

enum WarningSaveResult: string
{
    case INSERTED = 'inserted';
    case UPDATED = 'updated';
}
