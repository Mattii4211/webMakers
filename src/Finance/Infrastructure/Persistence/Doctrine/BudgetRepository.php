<?php

namespace App\Finance\Infrastructure\Persistence\Doctrine;

use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Repository\BudgetRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class BudgetRepository implements BudgetRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Budget $budget, bool $flush = true): void
    {
        $this->entityManager->persist($budget);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function findById(string $id): ?Budget
    {
        return $this->entityManager->createQueryBuilder()
            ->select('b')
            ->from(Budget::class, 'b')
            ->where('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @return Budget[] */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('b')
            ->from(Budget::class, 'b')
            ->getQuery()
            ->getResult();
    }
}
