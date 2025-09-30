<?php

namespace App\Core\Application\Service;

use App\Core\Domain\Repository\WarningSourceRepositoryInterface;
use App\Core\Domain\Entity\Warning;
use App\Core\Application\Service\Factory\GenerateWarningsFactory;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Entity\Invoice;

final class GenerateWarningsHandler
{
    /**
     * @param iterable<WarningSourceRepositoryInterface<object>> $repositories
     */
    public function __construct(private iterable $repositories, private GenerateWarningsFactory $generateWarningsFactory)
    {
    }

    /**
     * @return list<Warning>
     */
    public function generate(): array
    {
        $warnings = [];
        foreach ($this->repositories as $repository) {
            $warnings = array_merge($warnings, $this->collectWarnings($repository->findAllWithWarning()));
        }

        return $warnings;
    }

    /**
      * @template T of object
      * @param iterable<T> $entities
      * @return list<Warning>
      */
    private function collectWarnings(iterable $entities): array
    {
        $warnings = [];
        foreach ($entities as $entity) {
            /** @var Budget|Contractor|Invoice $entity */
            $warnings[] = $this->generateWarningsFactory->create($entity);
        }

        return $warnings;
    }
}
