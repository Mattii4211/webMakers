<?php

namespace App\Finance\Infrastructure\Persistence\Doctrine;

use App\Core\Domain\Repository\WarningSourceRepositoryInterface;
use App\Finance\Domain\Entity\Contractor;
use App\Finance\Domain\Repository\ContractorRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @implements WarningSourceRepositoryInterface<Contractor>
 */
class ContractorRepository implements ContractorRepositoryInterface, WarningSourceRepositoryInterface
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

    /** @return Contractor[] */
    public function findAllWithWarning(): array
    {
        return array_filter($this->findAll(), fn ($c) => $c->isWarning());
    }
}
