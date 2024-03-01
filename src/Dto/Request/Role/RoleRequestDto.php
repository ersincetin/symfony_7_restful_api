<?php

namespace App\Dto\Request\Role;

use Symfony\Component\Validator\Constraints as Assert;

class RoleRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private string $name
    )
    {
    }

    private int $id;
    private ?bool $status = false;
    private ?int $is_admin;
    private ?string $permissions;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): void
    {
        $this->status = $status;
    }

    public function getIsAdmin(): ?int
    {
        return $this->is_admin;
    }

    public function setIsAdmin(?int $is_admin): void
    {
        $this->is_admin = $is_admin;
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