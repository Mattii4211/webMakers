<?php

namespace App\Finance\Infrastructure\Persistence\Doctrine;

use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Repository\ContractorRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContractorRepository implements ContractorRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Contractor $contractor, bool $flush = true): void
    {
        $this->entityManager->persist($contractor);

        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function findById(string $id): ?Contractor
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Contractor::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /** @return Contractor[] */
    public function findAll(): array
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from(Contractor::class, 'c')
            ->getQuery()
            ->getResult();
    }
}
