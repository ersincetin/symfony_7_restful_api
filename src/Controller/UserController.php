<?php

namespace App\Controller;

use App\Controller\Auth\AuthFilterInterface;
use App\Dto\Request\User\UserRequestDto;
use App\Entity\User;
use App\Service\Concretes\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController implements AuthFilterInterface
{
    private $data = array();

    public function __construct(private UserService $userService)
    {
    }

    #[Route('users/{id}', name: 'get_user', methods: 'GET')]
    public function get(int $id = null): JsonResponse
    {
        if (!is_null($id))
            return $this->userService->find($id);
        return $this->userService->findAll();
    }

    #[Route('users', name: 'create_user', methods: 'POST', format: 'JSON')]
    public function create(
        #[MapRequestPayload] UserRequestDto $requestDto
    ): JsonResponse
    {
        return $this->userService->create($requestDto);
    }

    #[Route('users/{id}', name: 'update_user', methods: 'PUT')]
    public function update(
        #[MapRequestPayload] UserRequestDto $requestDto,
        int                                 $id = null
    ): JsonResponse
    {
        return $this->userService->update($requestDto, $id);
    }

    #[Route('users/{id}', name: 'delete_user', methods: 'DELETE')]
    public function delete(int $id = null)
    {
        return $this->userService->delete($id);
    }

    #[Route('users/{id}/setStatus', name: 'change_user_status', methods: 'PATCH')]
    public function setStatus(int $id = null): JsonResponse
    {
        return $this->userService->setStatus($id);
    }

    private function random_add_user($piece = null)
    {
        if (!is_null($piece))
            for ($i = 8800; $i < 10000; $i++) {
                $user = new User();
                $user->setStatus(false);
                $user->setSex('M');
                $user->setUsername('username_' . ($i + 1));
                $user->setFirstname('firstname_' . ($i + 1));
                $user->setSecondName(isset($parameters['second_name']) ?? null);
                $user->setLastname('lastname_' . ($i + 1));
                $user->setEmail('email_' . ($i + 1) . '@gmail.com');
                $user->setPassword('123456');
                $user->setPhotoUrl(isset($parameters['photo_url']) ?? null);
                $user->setCreatedAt(new  \DateTime());
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
    }
}
