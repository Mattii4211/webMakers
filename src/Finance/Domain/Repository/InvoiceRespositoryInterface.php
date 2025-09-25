<?php

namespace App\Finance\Domain\Repository;

use App\Finance\Domain\Entity\Invoice;

interface InvoiceRespositoryInterface
{
    public function save(Invoice $invoice, bool $flush = true): void;
    public function findById(string $id): ?Invoice;

    /** @return Invoice[] */
    public function findAll(): array;
}
