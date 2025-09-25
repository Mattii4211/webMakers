<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Warning;

interface WarningRepositoryInterface
{
    public function save(Warning $warning, bool $flush = true): void;
    public function findById(string $id): ?Warning;

    /** @return Warning[] */
    public function findAll(): array;

    /** @return Warning[] */
    public function findAllNotClosed(): array;
}
