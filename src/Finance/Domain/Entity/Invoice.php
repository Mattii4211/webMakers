<?php
namespace App\Finance\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use DateTimeImmutable;

#[ORM\Entity]
#[ORM\Table(name: "invoices")]
class Invoice
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private UuidInterface $id;

    #[ORM\Column(type: "string", unique: true)]
    private string $number;

    #[ORM\ManyToOne(targetEntity: Contractor::class)]
    private Contractor $contractor;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2)]
    private float $amount;

    #[ORM\Column(type: "boolean")]
    private bool $paid;

    #[ORM\Column(type: "datetime")]
    private \DateTime $dueDate;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTime $deletedAt = null;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTimeImmutable();
    }
}
