<?php

namespace App\Core\Domain\Repository;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Enum\WarningSaveResult;
use DateTime;

interface WarningRepositoryInterface
{
    public function save(Warning $warning, bool $flush = true): WarningSaveResult;
    public function setDeleted(Warning $warning, bool $flush = true): void;
    public function findById(string $id): ?Warning;

    /** @return Warning[] */
    public function findAll(): array;

    /** @return Warning[] */
    public function findAllNotClosed(?DateTime $lastUpdateDate = null): array;
}
