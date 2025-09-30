<?php

namespace App\Finance\Domain\Repository;

use App\Finance\Domain\Entity\Contractor;

interface ContractorRepositoryInterface
{
    public function save(Contractor $contractor, bool $flush = true): void;
    public function findById(string $id): ?Contractor;

    /** @return Contractor[] */
    public function findAll(): array;

    /** @return Contractor[] */
    public function findAllWithWarning(): array;
}
