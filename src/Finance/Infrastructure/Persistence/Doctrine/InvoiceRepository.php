<?php

namespace App\Finance\Infrastructure\Persistence\Doctrine;

use App\Finance\Domain\Repository\InvoiceRespositoryInterface;
use App\Finance\Domain\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceRepository implements InvoiceRespositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Invoice $invoice, bool $flush = true): void
    {
        $this->entityManager->persist($invoice);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function findById(string $id): ?Invoice
    {
        return $this->entityManager->createQueryBuilder()
            ->select('i')
            ->from(Invoice::class, 'i')
            ->where('i.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @return Invoice[] */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('i')
            ->from(Invoice::class, 'i')
            ->getQuery()
            ->getResult();
    }

    /** @return Invoice[] */
    public function findAllWithWarning(): array
    {
        return array_filter($this->findAll(), fn ($c) => $c->isWarning());
    }
}
