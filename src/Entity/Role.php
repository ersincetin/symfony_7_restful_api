<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: 'roles')]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(name: 'id', type: Types::SMALLINT)]
    private int $id;
    #[ORM\Column(name: 'status', type: Types::BOOLEAN, length: 1, nullable: false)]
    private ?bool $status = false;
    #[ORM\Column(name: 'name', type: Types::STRING, length: 32, nullable: false)]
    private string $name;
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE,nullable: false)]
    private \DateTime $created_at;
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTime $updated_at = null;
    #[ORM\Column(name: 'deleted_at', type: Types::DATETIME_MUTABLE,nullable: true)]
    private ?\DateTime $deleted_at = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): void
    {
        $this->status = $status;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTime $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

}
