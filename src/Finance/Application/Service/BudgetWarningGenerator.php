<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Repository\BudgetRepositoryInterface;
use InvalidArgumentException;

final class BudgetWarningGenerator implements WarningGeneratorInterface
{
    public function __construct(
        // private BudgetRepositoryInterface $budgetRepository,
        private WarningRepositoryInterface $warningRepository
    ) {
    }

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

        $this->warningRepository->save($warning);

        return $warning;
    }
}
