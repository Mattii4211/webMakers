<?php

namespace App\Core\Domain\Entity;

use App\Common\Domain\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use DateTimeImmutable;
use DateTime;

#[ORM\Entity]
#[ORM\Table(
    name: "warnings",
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: "unique_object_type_id", columns: ["objectType", "objectId"])
    ]
)]
final class Warning
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private UuidInterface $id;

    #[ORM\Column(type: "string")]
    private string $objectType;

    #[ORM\Column(type: "string")]
    private string $objectId;

    #[ORM\Column(type: "string")]
    private string $category;

    public function __construct(string $objectType, string $objectId, string $category)
    {
        $this->objectType = $objectType;
        $this->objectId = $objectId;
        $this->category = $category;
        $this->id = Uuid::uuid4();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTime();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function getCategory(): string
    {
        return $this->category;
    }
}
