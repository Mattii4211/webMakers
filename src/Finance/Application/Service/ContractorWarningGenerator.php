<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Contractor;
use InvalidArgumentException;

final class ContractorWarningGenerator implements WarningGeneratorInterface
{
    public function generateWarning(object $object, string $className): Warning
    {
        if (!$object instanceof Contractor) {
            throw new InvalidArgumentException('Expected Contractor object');
        }

        /** @var Contractor $object */
        $warning = new Warning(
            $className,
            $object->getId()->toString(),
            'przekroczona suma zaległości kontrahenta'
        );

        return $warning;
    }
}
