<?php

namespace App\Controller;

use App\Controller\Auth\AuthFilterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController implements AuthFilterInterface
{
    private $data = array();

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    #[Route('users/{id}', name: 'get_user', methods: 'GET')]
    public function get(int $id = null): JsonResponse
    {
        try {
            if (!is_null($id)) {
                if (!is_null($user = $this->repository->find($id))) {
                    $this->data = [
                        'id' => $user->getId(),
                        'status' => $user->getStatus(),
                        'role' => $user->getRole()->getName(),
                        'username' => $user->getUsername(),
                        'firstname' => $user->getFirstname(),
                        'lastname' => $user->getLastname(),
                        'email' => $user->getEmail(),
                    ];
                    return $this->json([
                        'data' => $this->data,
                        'message' => 'Successful'
                    ], 200);
                } else {
                    return $this->json([
                        'id' => $id ?? null,
                        'message' => 'Show for not found user'
                    ], 404);
                }

            } else {
                if (count($users = $this->repository->findAll()) > 0)
                    foreach ($users as $user) {
                        array_push($this->data, [
                            'id' => $user->getId(),
                            'status' => $user->getStatus(),
                            'role' => $user->getRole()->getName(),
                            'username' => $user->getUsername(),
                            'firstname' => $user->getFirstname(),
                            'lastname' => $user->getLastname(),
                            'email' => $user->getEmail(),
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

    #[Route('users', name: 'create_user', methods: 'POST')]
    public function create(Request $request): JsonResponse
    {
        if (strlen($request->getContent()) > 0) {
            $parameters = json_decode($request->getContent(), true);
            $user = new User();
            $user->setStatus($parameters['status']);
            $user->setRoleId($parameters['roleId']);
            $user->setUsername($parameters['username']);
            $user->setFirstname($parameters['firstname']);
            $user->setLastname($parameters['lastname']);
            $user->setEmail($parameters['email']);
            $user->setPassword($parameters['password']);
            $user->setCreatedAt(new \DateTime());
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json([
                'data' => $user->getUsername() . ' created.',
                'message' => 'Successful'
            ], 201);
        } else {
            return $this->json([
                'message' => 'Please check your request body'
            ], 404);
        }
    }

    #[Route('users/{id}', name: 'update_user', methods: 'PUT')]
    public function update(Request $request, int $id = null)
    {
        if (strlen($request->getContent()) > 0 && !is_null($id) && !is_null($user = $this->repository->find($id))) {
            $parameters = json_decode($request->getContent(), true);
            $user->setStatus($parameters['status']);
            $user->setRoleId($parameters['roleId']);
            $user->setUsername($parameters['username']);
            $user->setFirstname($parameters['firstname']);
            $user->setLastname($parameters['lastname']);
            $user->setEmail($parameters['email']);
            $user->setPassword($parameters['password']);
            $user->setUpdatedAt(new \DateTime());
            $this->entityManager->flush();

            return $this->json([
                'data' => $user->getUsername() . ' updated.',
                'message' => 'Successful'
            ], 200);
        } else {
            return $this->json([
                'id' => $id,
                'message' => 'Update for not found user'
            ], 404);
        }
    }

    #[Route('users/{id}', name: 'delete_user', methods: 'DELETE')]
    public function delete(int $id = null)
    {
        try {
            if (!is_null($id) && !is_null($user = $this->repository->find($id))) {
                $user->setDeletedAt(new \DateTime());
                $this->entityManager->flush();
                return $this->json([
                    'data' => $user->getUsername() . ' deleted.',
                    'message' => 'Successful'
                ], 200);
            } else {
                return $this->json([
                    'id' => $id,
                    'message' => 'Delete for not found user'
                ], 404);
            }
        } catch (\Exception $exception) {
            return new Response([
                'message' => $exception->getMessage(),
            ], 404);
        }
    }
}
