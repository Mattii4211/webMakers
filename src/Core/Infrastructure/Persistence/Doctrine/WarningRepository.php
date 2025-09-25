<?php

namespace App\Core\Infrastructure\Persistence\Doctrine;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Core\Domain\Enum\WarningSaveResult;

class WarningRepository implements WarningRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Warning $warning, bool $flush = true): WarningSaveResult
    {
        $existing = $this->entityManager->getRepository(Warning::class)
            ->findOneBy([
                'objectType' => $warning->getObjectType(),
                'objectId' => $warning->getObjectId(),
            ]);

        if ($existing instanceof Warning) {
            $existing->setUpdatedAt(new DateTime());
        } else {
            $this->entityManager->persist($warning);
        }

        if ($flush) {
            $this->entityManager->flush();
        }

        return $existing instanceof Warning ? WarningSaveResult::UPDATED : WarningSaveResult::INSERTED;

    }

    public function setDeleted(Warning $warning, bool $flush = true): void
    {
        $warning->setDeletedAt(new DateTime());

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
    public function findAllNotClosed(?DateTime $lastUpdateDate = null): array
    {
        $qb =  $this->entityManager->createQueryBuilder();
        $qb->select('w')
            ->from(Warning::class, 'w')
            ->where('w.deletedAt IS NULL');

        if ($lastUpdateDate instanceof DateTime) {
            $qb->andWhere('w.updatedAt < :fromDate')
               ->setParameter('fromDate', $lastUpdateDate);
        }

        return $qb->getQuery()->getResult();
    }
}
