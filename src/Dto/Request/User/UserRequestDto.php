<?php

namespace App\Dto\Request\User;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class UserRequestDto
{
    private bool $status;
    private string $sex;
    private string $secondName;
    private string $photoUrl;

    public function __construct(

        #[Assert\NotBlank]
        private int    $roleId,

        #[Assert\NotBlank]
        private string $username,

        #[Assert\NotBlank]
        private string $firstname,

        #[Assert\NotBlank]
        private string $lastname,

        #[Assert\NotBlank]
        private string $email,

        #[Assert\NotNull]
        #[Assert\Length(min: 3, max: 32)]
        private string $password,
    )
    {

    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function getSecondName(): string
    {
        return $this->secondName;
    }

    public function getPhotoUrl(): string
    {
        return $this->photoUrl;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}