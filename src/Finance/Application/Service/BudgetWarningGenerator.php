<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Budget;
use InvalidArgumentException;

final class BudgetWarningGenerator implements WarningGeneratorInterface
{
    public function generateWarning(object $object, string $className): Warning
    {
        if (!$object instanceof Budget) {
            throw new InvalidArgumentException('Expected Invoice object');
        }

        /** @var Budget $object */
        $warning = new Warning(
            $className,
            $object->getId()->toString(),
            'budżet poniżej zera'
        );

        return $warning;
    }
}
