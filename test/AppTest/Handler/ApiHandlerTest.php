<?php

declare(strict_types=1);


namespace AppTest\Handler;

use App\Entity\Forecast;
use App\Handler\ApiHandler;
use App\Handler\HomePageHandler;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Laminas\Diactoros\Response\JsonResponse;
use Mezzio\Router\RouterInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiHandlerTest extends TestCase
{
    use ProphecyTrait;

    /** @var ContainerInterface|ObjectProphecy */
    protected $container;

    /** @var RouterInterface|ObjectProphecy */
    protected $router;

    /** @var EntityManager|ObjectProphecy */
    private $entityManager;

    protected function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $this->router    = $this->prophesize(RouterInterface::class);
        $this->entityManager = $this->prophesize(EntityManager::class);
    }

    public function testListAllEntriesReturnsJsonResponseOfAvailableEntriesIfEntriesAreAvailable()
    {
        $forecast = new Forecast(
            'Matthew Setter',
            'Lisbon',
            '+1123456789',
            'dave.grohl@example.org',
            'Tuesday, 07 Sep 2021',
            'Friday, 10 Sep 2021',
            1,
        );

        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findAll()
            ->willReturn([$forecast]);

        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('GET');

        $response = $apiHandler->handle($request->reveal());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testListAllEntriesReturnsEmptyJsonResponseIfNoEntriesAreAvailable()
    {
        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findAll()
            ->willReturn([]);

        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('GET');

        $response = $apiHandler->handle($request->reveal());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals(200, $response->getStatusCode());
    }

}
