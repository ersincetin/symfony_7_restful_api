<?php

namespace App\Service\Concretes;

use AllowDynamicProperties;
use App\DataMapper\UserDataMapper;
use App\Dto\Request\User\UserRequestDto;
use App\Dto\Response\User\UserResponseDto;
use App\Entity\User;
use App\Service\Abstracts\IUserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[AllowDynamicProperties] class UserService implements IUserService
{
    private $data = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
        $this->dataMapper = new UserDataMapper();
    }

    public function find(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($user = $this->repository->find($id))) {
                return new JsonResponse([
                    'data' => json_decode($this->dataMapper->mapEntityToDto($user, new UserResponseDto())),
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id ?? null,
                    'message' => 'Show for not found user'
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
            if (count($users = $this->repository->findAll()) > 0)
                foreach ($users as $user) {
                    array_push($this->data, json_decode($this->dataMapper->mapEntityToDto($user,new UserResponseDto())));
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

    public function create(UserRequestDto $requestDto = null)
    {
        try {
            if (!is_null($requestDto)) {
                $user = new User();
                $user->setRoleId($requestDto->getRoleId());
                $user->setUsername($requestDto->getUsername());
                $user->setFirstname($requestDto->getFirstname());
                $user->setLastname($requestDto->getLastname());
                $user->setEmail($requestDto->getEmail());
                $user->setPassword($requestDto->getPassword());
                $user->setCreatedAt(new \DateTime());
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $user->getUsername() . ' created.',
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

    public function update(UserRequestDto $requestDto = null, int $id = null)
    {
        try {
            if (strlen($requestDto) > 0 && !is_null($id) && !is_null($user = $this->repository->find($id))) {
                $user->setStatus($requestDto->isStatus());
                $user->setRoleId($requestDto->getRoleId());
                $user->setSex($requestDto->getSex());
                $user->setUsername($requestDto->getUsername());
                $user->setFirstname($requestDto->getFirstname());
                $user->setSecondName($requestDto->getSecondName());
                $user->setLastname($requestDto->getLastname());
                $user->setEmail($requestDto->getEmail());
                $user->setPhotoUrl($requestDto->getPhotoUrl());
                $user->setUpdatedAt(new \DateTime());
                $this->entityManager->flush();

                return new JsonResponse([
                    'data' => $user->getUsername() . ' updated.',
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
            if (!is_null($id) && !is_null($user = $this->repository->find($id))) {
                $user->setDeletedAt(new \DateTime());
                $this->entityManager->flush();
                return new JsonResponse([
                    'data' => $user->getUsername() . ' deleted.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return new JsonResponse([
                    'id' => $id,
                    'message' => 'Delete for not found user'
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
            if (!is_null($id) && !is_null($user = $this->repository->find($id))) {
                $user->setStatus($user->getStatus() ? false : true);
                $this->entityManager->flush();
                return $this->json([
                    'data' => $user->getUsername() . ' updated set status.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return $this->json([
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