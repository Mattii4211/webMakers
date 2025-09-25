<?php

namespace App\Finance\Domain\Entity;

use App\Common\Domain\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use DateTimeImmutable;
use DateTime;

#[ORM\Entity]
#[ORM\Table(name: "invoices")]
final class Invoice
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid_binary", unique: true)]
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
    private DateTime $dueDate;

    public function __construct(Contractor $contractor, string $number, float $amount, DateTime $dueDate)
    {
        $this->contractor = $contractor;
        $this->number = $number;
        $this->amount = $amount;
        $this->paid = false;
        $this->dueDate = $dueDate;
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function isWarrning(): bool
    {
        return $this->isOverdue();
    }

    public function isOverdue(): bool
    {
        return $this->paid === false
            && $this->dueDate < new DateTimeImmutable('today');
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getContractor(): Contractor
    {
        return $this->contractor;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
