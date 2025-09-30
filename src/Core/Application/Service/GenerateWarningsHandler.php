<?php

declare(strict_types=1);

namespace App\Core\Application\Service;

use App\Core\Application\Service\Factory\GenerateWarningsFactory;
use App\Core\Domain\Entity\Warning;
use App\Finance\Domain\Repository\BudgetRepositoryInterface;
use App\Finance\Domain\Repository\ContractorRepositoryInterface;
use App\Finance\Domain\Repository\InvoiceRespositoryInterface;
use App\Finance\Domain\Entity\Invoice;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Entity\Contractor;

final class GenerateWarningsHandler
{
    public function __construct(
        private GenerateWarningsFactory $generateWarningsFactory,
        private InvoiceRespositoryInterface $invoiceRespository,
        private BudgetRepositoryInterface $budgetRepository,
        private ContractorRepositoryInterface $contractorRepository,
    ) {
    }

    /**
     * @param iterable<Invoice|Budget|Contractor> $entities
     * @return list<Warning>
     */
    private function collectWarnings(iterable $entities): array
    {
        $warnings = [];
        foreach ($entities as $entity) {
            if ($entity->isWarning()) {
                $warnings[] = $this->generateWarningsFactory->create($entity);
            }
        }

        return $warnings;
    }

    /** @return Warning[] */
    public function generate(): array
    {
        return array_merge(
            $this->collectWarnings($this->invoiceRespository->findAllWithWarning()),
            $this->collectWarnings($this->budgetRepository->findAllWithWarning()),
            $this->collectWarnings($this->contractorRepository->findAllWithWarning()),
        );
    }
}
