<?php

namespace App\Finance\Domain\Entity;

use App\Common\Domain\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use DateTimeImmutable;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "contractors")]
class Contractor
{
    use TimestampableTrait;
    private const WARNING_INVOICE_AMOUNT = 15000;

    #[ORM\Id]
    #[ORM\Column(type: "uuid_binary", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private UuidInterface $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $name;

    /**
     * @var Collection<int, Invoice>
     */
    #[ORM\OneToMany(mappedBy: "contractor", targetEntity: Invoice::class, cascade: ["persist", "remove"])]
    private Collection $invoices;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
        $this->invoices = new ArrayCollection();
    }

    public function isWarrning(): bool
    {
        $invoiceAmount = 0;
        foreach ($this->invoices as $invoice) {
            if ($invoice->isOverdue()) {
                $invoiceAmount += $invoice->getAmount();
            }
        }

        return $invoiceAmount > self::WARNING_INVOICE_AMOUNT;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
