<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class JWTController extends AbstractController
{
    #[Route('/api/jwt/payload', name: 'app_jwt', methods: ['GET'])]
    public function index(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $jwtToken = $tokenStorageInterface->getToken();
        
        if (!$jwtToken) {
            return $this->json([
                'error' => 'No JWT token found',
            ], 400);
        }
        
        $decodedJwtToken = $jwtManager->decode($jwtToken);
        
        return $this->json($decodedJwtToken);
    }
}
