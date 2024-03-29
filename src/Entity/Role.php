<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: 'roles')]
class Role extends BaseEntity
{
    #[ORM\Column(name: 'is_admin', type: Types::SMALLINT, length: 1)]
    private ?int $is_admin = 0;
    #[ORM\Column(name: 'name', type: Types::STRING, length: 32)]
    private string $name;
    #[ORM\Column(name: 'permissions', type: Types::TEXT)]
    private ?string $permissions = null;

    public function getIsAdmin(): ?int
    {
        return $this->is_admin;
    }

    public function setIsAdmin(?int $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPermissions(): ?string
    {
        return $this->permissions;
    }

    public function setPermissions(?string $permissions): void
    {
        $this->permissions = $permissions;
    }
}
