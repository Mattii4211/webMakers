<?php

namespace App\Core\Domain;

use App\Core\Domain\Entity\Warning;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Entity\Invoice;

interface WarningGeneratorInterface
{
    public function generateWarning(Invoice|Budget|Contractor $object, string $className): Warning;
}
