<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\Forecast;
use Doctrine\ORM\EntityManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiHandler implements RequestHandlerInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $result = [];

        if ($request->getMethod() === 'GET') {
            $result = $this->entityManager->getRepository(Forecast::class)->findAll();
        }

        return new JsonResponse($result);
    }
}
