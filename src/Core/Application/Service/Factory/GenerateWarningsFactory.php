<?php

declare(strict_types=1);

namespace App\Core\Application\Service\Factory;

use App\Core\Domain\Entity\Warning;
use App\Finance\Application\Service\InvoiceWarningGenerator;
use App\Finance\Application\Service\BudgetWarningGenerator;
use App\Finance\Application\Service\ContractorWarningGenerator;
use App\Finance\Domain\Entity\Invoice;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Entity\Contractor;
use ReflectionClass;
use InvalidArgumentException;

final readonly class GenerateWarningsFactory
{
    public function __construct(
        private InvoiceWarningGenerator $invoiceWarningGenerator,
        private BudgetWarningGenerator $budgetWarningGenerator,
        private ContractorWarningGenerator $contractorWarningGenerator,
    ) {
    }

    public function create(Invoice|Budget|Contractor $class): Warning
    {
        $reflection = new ReflectionClass($class);

        return match ($className = strtolower($reflection->getShortName())) {
            'contractor' => $this->contractorWarningGenerator->generateWarning($class, $className),
            'budget' => $this->budgetWarningGenerator->generateWarning($class, $className),
            'invoice' => $this->invoiceWarningGenerator->generateWarning($class, $className),
            default => throw new InvalidArgumentException('Invalid warning type'),
        };
    }
}
