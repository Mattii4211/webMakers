<?php

namespace App\Finance\Domain\Entity;

use App\Common\Domain\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use DateTimeImmutable;
use DateTime;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: "budgets")]
final class Budget
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid_binary", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private UuidInterface $id;

    #[ORM\Column(type: "string")]
    private string $name;

    #[ORM\Column(type: "decimal", precision: 15, scale: 2)]
    private float $balance;

    public function __construct(string $name, float $balance)
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function isWarning(): bool
    {
        return $this->balance < 0;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
        $this->updatedAt = new DateTime();
    }
}
