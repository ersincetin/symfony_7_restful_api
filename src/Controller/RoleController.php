<?php

namespace App\Controller;

use App\Controller\Auth\AuthFilterInterface;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoleController extends AbstractController implements AuthFilterInterface
{
    private $data = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Role::class);
    }

    #[Route('roles/{id}', name: 'get_role', methods: 'GET')]
    public function get(int $id = null): JsonResponse
    {
        try {
            if (!is_null($id)) {
                if (!is_null($role = $this->repository->find($id))) {
                    $this->data = [
                        'id' => $role->getId(),
                        'status' => $role->getStatus(),
                        'name' => $role->getName(),
                    ];
                    return $this->json([
                        'data' => $this->data,
                        'message' => 'Successful'
                    ], 200);
                } else {
                    return $this->json([
                        'id' => $id ?? null,
                        'message' => 'Show for not found role'
                    ], 404);
                }

            } else {
                if (count($roles = $this->repository->findAll()) > 0)
                    foreach ($roles as $role) {
                        array_push($this->data, [
                            'id' => $role->getId(),
                            'status' => $role->getStatus(),
                            'name' => $role->getName(),
                        ]);
                    }
                return $this->json([
                    'data' => $this->data,
                    'message' => 'Successful'
                ], 200);
            }
        } catch (\Exception $exception) {
            return new Response([
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    #[Route('roles', name: 'create_role', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        if (strlen($request->getContent()) > 0) {
            $parameters = json_decode($request->getContent(), true);
            $role = new Role();
            $role->setStatus($parameters['status']);
            $role->setName($parameters['name']);
            $role->setCreatedAt(new \DateTime());
            $this->entityManager->persist($role);
            $this->entityManager->flush();

            return $this->json([
                'data' => $role->getName() . ' created.',
                'message' => 'Successful'
            ], 201);
        } else {
            return $this->json([
                'message' => 'Please check your request body'
            ], 404);
        }
    }

    #[Route('roles/{id}', name: 'update_role', methods: 'PUT')]
    public function update(Request $request, int $id = null)
    {
        if (strlen($request->getContent()) > 0 && !is_null($id) && !is_null($role = $this->repository->find($id))) {
            $parameters = json_decode($request->getContent(), true);
            $role->setStatus($parameters['status']);
            $role->setName($parameters['name']);
            $role->setUpdatedAt(new \DateTime());
            $this->entityManager->flush();

            return $this->json([
                'data' => $role->getName() . ' updated.',
                'message' => 'Successful'
            ], 200);
        } else {

        }
    }

    #[Route('roles/{id}', name: 'delete_role', methods: 'DELETE')]
    public function delete(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($role = $this->repository->find($id))) {
                $role->setDeletedAt(new \DateTime());
                $this->entityManager->flush();
                return $this->json([
                    'data' => $role->getName() . ' deleted.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return $this->json([
                    'id' => $id,
                    'message' => 'Not found role'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new Response([
                'message' => $exception->getMessage(),
            ], 404);
        }
    }

    #[Route('roles/{id}/setStatus', name: 'change_role_status', methods: 'PATCH')]
    public function setStatus(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($role = $this->repository->find($id))) {
                $role->setStatus($role->getStatus() ? false : true);
                $this->entityManager->flush();
                return $this->json([
                    'data' => $role->getName() . ' updated set status.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return $this->json([
                    'id' => $id ?? null,
                    'message' => 'Not found user'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new Response([
                'message' => $exception->getMessage()
            ], 404);
        }
    }
}
