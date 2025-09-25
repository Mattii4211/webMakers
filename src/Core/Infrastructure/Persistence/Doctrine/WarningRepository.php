<?php

namespace App\Core\Infrastructure\Persistence\Doctrine;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class WarningRepository implements WarningRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Warning $warning, bool $flush = true): void
    {
        $this->entityManager->persist($warning);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function findById(string $id): ?Warning
    {
        return $this->entityManager->createQueryBuilder()
            ->select('w')
            ->from(Warning::class, 'w')
            ->where('w.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @return Warning[] */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('w')
            ->from(Warning::class, 'w')
            ->getQuery()
            ->getResult();
    }

    /** @return Warning[] */
    public function findAllNotClosed(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('w')
            ->from(Warning::class, 'w')
            ->where('w.deletedAt IS NULL')
            ->getQuery()
            ->getResult();
    }
}
