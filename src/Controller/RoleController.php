<?php

namespace App\Controller;

use App\Controller\Auth\AuthFilterInterface;
use App\Dto\Request\Role\RoleRequestDto;
use App\Service\Concretes\RoleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RoleController extends AbstractController implements AuthFilterInterface
{
    private $data = array();

    public function __construct(private RoleService $roleService)
    {
    }

    #[Route('roles/{id}', name: 'get_role', methods: 'GET')]
    public function get(int $id = null): JsonResponse
    {
        if (!is_null($id))
            return $this->roleService->find($id);
        return $this->roleService->findAll();
    }

    #[Route('roles', name: 'create_role', methods: 'POST')]
    public function create(
        #[MapRequestPayload] RoleRequestDto $requestDto
    ): JsonResponse
    {
        return $this->roleService->create($requestDto);
    }

    #[Route('roles/{id}', name: 'update_role', methods: 'PUT')]
    public function update(
        #[MapRequestPayload] RoleRequestDto $requestDto,
        int                                 $id = null)
    {
        return $this->roleService->update($requestDto, $id);
    }

    #[Route('roles/{id}', name: 'delete_role', methods: 'DELETE')]
    public function delete(int $id = null)
    {
        return $this->roleService->delete($id);
    }

    #[Route('roles/{id}/setStatus', name: 'change_role_status', methods: 'PATCH')]
    public function setStatus(int $id = null)
    {
        return $this->roleService->setStatus($id);
    }
}
