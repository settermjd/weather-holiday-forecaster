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

        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            $forecast = new Forecast();
            $forecast->setCity($data['city']);
            $forecast->setName($data['name']);
            $forecast->setPhone($data['phone']);
            $forecast->setEmail($data['email']);
            $forecast->setStartDate(new \DateTime($data['startDate']));
            $forecast->setEndDate(new \DateTime($data['endDate']));

            $this->entityManager->persist($forecast);
            $this->entityManager->flush();

            $result['status'] = 'success';
        }

        if ($request->getMethod() === 'PUT') {
            $data = $request->getParsedBody();

            /** @var Forecast $forecast */
            $forecast = $this
                ->entityManager
                ->getRepository(Forecast::class)
                ->findOneBy(
                    [
                        'id' => $request->getAttribute('id')
                    ]
                );

            $forecast->setName($data['name']);
            $forecast->setCity($data['city']);
            $forecast->setPhone($data['phone']);
            $forecast->setEmail($data['email']);
            $forecast->setStartDate(new \DateTime($data['startDate']));
            $forecast->setEndDate(new \DateTime($data['endDate']));

            $this->entityManager->persist($forecast);
            $this->entityManager->flush();

            $result['status'] = 'success';
        }

        if ($request->getMethod() === 'DELETE') {
            /** @var Forecast $forecast */
            $forecast = $this
                ->entityManager
                ->getRepository(Forecast::class)
                ->findOneBy(
                    [
                        'id' => $request->getAttribute('id')
                    ]
                );

            $this->entityManager->remove($forecast);
            $this->entityManager->flush();

            $result['status'] = 'success';
        }

        return new JsonResponse($result);
    }
}
