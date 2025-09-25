<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use App\Finance\Domain\Repository\ContractorRepositoryInterface;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Contractor;
use InvalidArgumentException;

final class ContractorWarningGenerator implements WarningGeneratorInterface
{
    public function __construct(
        // private ContractorRepositoryInterface $contractorRepository,
        private WarningRepositoryInterface $warningRepository
    ) {
    }

    public function generateWarning(object $object, string $className): Warning
    {
        if (!$object instanceof Contractor) {
            throw new InvalidArgumentException('Expected Invoice object');
        }

        /** @var Contractor $object */
        $warning = new Warning(
            $className,
            $object->getId()->toString(),
            'przekroczona suma zaległości kontrahenta'
        );

        $this->warningRepository->save($warning);

        return $warning;
    }
}
