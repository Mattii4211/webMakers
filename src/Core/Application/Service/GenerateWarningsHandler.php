<?php

declare(strict_types=1);

namespace App\Core\Application\Service;

use App\Core\Application\Service\Factory\GenerateWarningsFactory;
use App\Core\Domain\Entity\Warning;
use App\Finance\Domain\Repository\BudgetRepositoryInterface;
use App\Finance\Domain\Repository\ContractorRepositoryInterface;
use App\Finance\Domain\Repository\InvoiceRespositoryInterface;

final class GenerateWarningsHandler
{
    public function __construct(
        private GenerateWarningsFactory $generateWarningsFactory,
        private InvoiceRespositoryInterface $invoiceRespository,
        private BudgetRepositoryInterface $budgetRepository,
        private ContractorRepositoryInterface $contractorRepository,
    ) {
        $this->generateWarningsFactory = $generateWarningsFactory;
        $this->invoiceRespository = $invoiceRespository;
        $this->budgetRepository = $budgetRepository;
        $this->contractorRepository = $contractorRepository;
    }

    /** @return Warning[] */
    public function generate(): array
    {
        $warnings = [];

        $invoices = $this->invoiceRespository->findAll();
        foreach ($invoices as $invoice) {
            if ($invoice->isWarrning()) {
                $warnings[] = $this->generateWarningsFactory->create($invoice);
            }
        }

        $budgets = $this->budgetRepository->findAll();
        foreach ($budgets as $budget) {
            if ($budget->isWarrning()) {
                $warnings[] = $this->generateWarningsFactory->create($budget);
            }
        }

        $contractors = $this->contractorRepository->findAll();
        foreach ($contractors as $contractor) {
            if ($contractor->isWarrning()) {
                $warnings[] = $this->generateWarningsFactory->create($contractor);
            }
        }

        return $warnings;
    }
}
