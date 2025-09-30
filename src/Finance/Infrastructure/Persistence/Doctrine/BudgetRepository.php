<?php

namespace App\Finance\Infrastructure\Persistence\Doctrine;

use App\Core\Domain\Repository\WarningSourceRepositoryInterface;
use App\Finance\Domain\Entity\Budget;
use App\Finance\Domain\Repository\BudgetRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements WarningSourceRepositoryInterface<Budget>
 */
class BudgetRepository implements BudgetRepositoryInterface, WarningSourceRepositoryInterface
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

    /** @return Budget[] */
    public function findAllWithWarning(): array
    {
        return array_filter($this->findAll(), fn ($c) => $c->isWarning());
    }
}
