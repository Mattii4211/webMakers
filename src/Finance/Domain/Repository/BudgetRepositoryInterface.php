<?php

namespace App\Finance\Domain\Repository;

use App\Finance\Domain\Entity\Budget;

interface BudgetRepositoryInterface
{
    public function save(Budget $budget, bool $flush = true): void;
    public function findById(string $id): ?Budget;

    /** @return Budget[] */
    public function findAll(): array;

    /** @return Budget[] */
    public function findAllWithWarning(): array;
}
