<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(User::class);
    }

    #[Route('/login', name: 'app_login')]
    public function index(Request $request): JsonResponse
    {
        if (strlen($request->getContent()) > 0) {
            $parameters = json_decode($request->getContent(), true);
            if (isset($parameters['username']) && isset($parameters['password'])) {
                $user = $this->repository->findOneBy([
                    'username' => trim($parameters['username']),
                    'password' => trim($parameters['password'])
                ]);
                if (!is_null($user)) {
                    $issuer_claim = 'THE_ISSUER'; /* this can be the servername */
                    $audience_claim = 'THE_AUDIENCE';
                    $issuedat_claim = time();
                    $notbefore_claim = $issuedat_claim + 0; /* not before in seconds */
                    $expire_claim = $issuedat_claim + 3600000; /* expire time in seconds */

                    $payload = [
                        'iss' => $issuer_claim,
                        'aud' => $audience_claim,
                        'iat' => $issuedat_claim,
                        'nbf' => $notbefore_claim,
                        'exp' => $expire_claim,
                        "data" => array(
                            'id' => $user->getId(),
                            'username' => $user->getUsername(),
                            'roleId' => $user->getRoleId()
                        )
                    ];
                    return $this->json([
                        'username' => $user->getUsername(),
                        'token' => JWT::encode($payload, '%env(APP_SECRET)%', 'HS256'),
                        'message' => 'Token created'
                    ], 200);
                } else {
                    return $this->json([
                        'message' => trim($parameters['username']) . ' not found user',
                    ], 404);
                }
            } else {
                return $this->json([
                    'message' => 'Check your request body',
                ], 404);
            }
        } else {
            return $this->json([
                'message' => 'Not found user',
            ], 404);
        }
    }
}
