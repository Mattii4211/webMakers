<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Invoice;
use InvalidArgumentException;

final class InvoiceWarningGenerator implements WarningGeneratorInterface
{
    public function generateWarning(object $object, string $className): Warning
    {
        if (!$object instanceof Invoice) {
            throw new InvalidArgumentException('Expected Invoice object');
        }

        /** @var Invoice $object */
        $warning = new Warning(
            $className,
            $object->getId()->toString(),
            'faktura przeterminowana'
        );

        return $warning;
    }
}
