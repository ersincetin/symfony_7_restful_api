<?php

namespace App\DataMapper;

use AllowDynamicProperties;
use App\Dto\Response\User\UserResponseDto;
use App\Entity\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AllowDynamicProperties] class UserDataMapper
{
    public function __construct()
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizer, $encoder);
    }

    public function mapEntityToDto(User $entity = null, UserResponseDto $dto = null)
    {
        $dto->setId($entity->getId());
        $dto->setStatus($entity->getStatus());
        $dto->setSex($entity->getSex());
        $dto->setRoleId($entity->getRoleId());
        $dto->setUsername($entity->getUsername());
        $dto->setFirstname($entity->getFirstname());
        $dto->setSecondName($entity->getSecondName());
        $dto->setLastname($entity->getLastname());
        $dto->setEmail($entity->getEmail());

        return $this->serializer->serialize($dto, 'json');
    }
}