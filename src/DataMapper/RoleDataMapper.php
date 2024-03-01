<?php

namespace App\DataMapper;

use AllowDynamicProperties;
use App\Dto\Response\Role\RoleResponseDto;
use App\Entity\Role;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AllowDynamicProperties] class RoleDataMapper
{
    public function __construct()
    {
        $encoder = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizer, $encoder);
    }

    public function mapEntityToDto(Role $entity = null, RoleResponseDto $dto = null)
    {
        $dto->setId($entity->getId());
        $dto->setStatus($entity->getStatus());
        $dto->setIsAdmin($entity->getIsAdmin());
        $dto->setName($entity->getName());
        $dto->setPermissions($entity->getPermissions());

        return $this->serializer->serialize($dto, 'json');
    }
}