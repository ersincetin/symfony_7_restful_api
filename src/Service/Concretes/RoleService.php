<?php

namespace App\Service\Concretes;

use AllowDynamicProperties;
use App\DataMapper\RoleDataMapper;
use App\Dto\Request\Role\RoleRequestDto;
use App\Dto\Response\Role\RoleResponseDto;
use App\Entity\Role;
use App\Service\Abstracts\IRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AllowDynamicProperties] class RoleService implements IRoleService
{
    private $data = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Role::class);
        $this->dataMapper = new RoleDataMapper();
    }

    public function find(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($role = $this->repository->find($id))) {
                return new JsonResponse([
                    'data' => json_decode($this->dataMapper->mapEntityToDto($role, new RoleResponseDto())),
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id ?? null,
                    'message' => 'Show for not found role'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function findAll()
    {
        try {
            if (count($roles = $this->repository->findAll()) > 0)
                foreach ($roles as $role) {
                    array_push($this->data, json_decode($this->dataMapper->mapEntityToDto($role, new RoleResponseDto())));
                }
            return new JsonResponse([
                'data' => $this->data,
                'message' => 'Successful'
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function create(RoleRequestDto $requestDto = null)
    {
        try {
            if (!is_null($requestDto)) {
                $role = new Role();
                $role->setName($requestDto->getName());
                $role->setCreatedAt(new \DateTime());
                $this->entityManager->persist($role);
                $this->entityManager->flush();

                return new JsonResponse([
                    'data' => $role->getName() . ' created.',
                    'message' => 'Successful'
                ], 201);
            } else {
                return new JsonResponse([
                    'message' => 'Please check your request body'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function update(RoleRequestDto $requestDto = null, int $id = null)
    {
        try {
            if (!is_null($requestDto) > 0 && !is_null($id) && !is_null($role = $this->repository->find($id))) {
                $role->setStatus($requestDto->getStatus());
                $role->setName($requestDto->getName());
                $role->setUpdatedAt(new \DateTime());
                $this->entityManager->flush();

                return new JsonResponse([
                    'data' => $role->getName() . ' updated.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id,
                    'message' => 'Update for not found user'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function delete(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($role = $this->repository->find($id))) {
                $role->setDeletedAt(new \DateTime());
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $role->getName() . ' deleted.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id,
                    'message' => 'Not found role'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage(),
            ], 404);
        }
    }

    public function setStatus(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($role = $this->repository->find($id))) {
                $role->setStatus($role->isStatus() ? false : true);
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $role->getName() . ' updated set status.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id ?? null,
                    'message' => 'Not found user'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => $exception->getMessage()
            ], 404);
        }
    }
}