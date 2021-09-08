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
        $forecast = new Forecast();
        $forecast->setName('Matthew Setter');
        $forecast->setCity('Lisbon');
        $forecast->setEmail('dave.grohl@example.org');
        $forecast->setPhone('+1123456789');
        $forecast->setStartDate(new \DateTime('September 7th, 2021'));
        $forecast->setEndDate(new \DateTime('September 10th, 2021'));
        $forecast->setId(1);

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
        self::assertEquals($response->getBody()->getContents(), '[]');
    }

    public function testCanCreateForecastWithValidData()
    {
        $forecast = new Forecast();
        $forecast->setName('Matthew Setter');
        $forecast->setCity('Lisbon');
        $forecast->setEmail('dave.grohl@example.org');
        $forecast->setPhone('+1123456789');
        $forecast->setStartDate(new \DateTime('September 7th, 2021'));
        $forecast->setEndDate(new \DateTime('September 10th, 2021'));

        $this->entityManager->persist($forecast);
        $this->entityManager->flush();

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('POST');

        $request
            ->getParsedBody()
            ->willReturn(
                [
                    'name' => 'Matthew Setter',
                    'city' => 'Lisbon',
                    'phone' => '+1123456789',
                    'email' => 'dave.grohl@example.org',
                    'startDate' => 'September 7th, 2021',
                    'endDate' => 'September 10th, 2021',
                ]
            );

        $response = $apiHandler->handle($request->reveal());

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($response->getBody()->getContents(), '{"status":"success"}');
    }

    public function testReturns404WhenAttemptingToUpdateNonExistentForecast()
    {
        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findOneBy(['id' => 1])
            ->willReturn(null);

        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('PUT');

        $request
            ->getAttribute('id')
            ->willReturn(1);

        $request
            ->getParsedBody()
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Matthew Setter',
                    'city' => 'Lisbon',
                    'phone' => '+1123456789',
                    'email' => 'dave.grohl@example.org',
                    'startDate' => 'September 7th, 2021',
                    'endDate' => 'September 10th, 2021',
                ]
            );

        $response = $apiHandler->handle($request->reveal());

        self::assertEquals(404, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($response->getBody()->getContents(), '{"status":"error","message":"Forecast not found"}');
    }

    public function testCanUpdateForecastWithValidData()
    {
        $forecast = new Forecast();
        $forecast->setName('Matthew Setter');
        $forecast->setCity('Lisbon');
        $forecast->setEmail('dave.grohl@example.org');
        $forecast->setPhone('+1123456789');
        $forecast->setStartDate(new \DateTime('September 7th, 2021'));
        $forecast->setEndDate(new \DateTime('September 10th, 2021'));
        $forecast->setId(1);

        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findOneBy(['id' => 1])
            ->willReturn($forecast);

        $this->entityManager
            ->persist($forecast)
            ->shouldBeCalled();
        $this->entityManager
            ->flush()
            ->shouldBeCalled();
        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('PUT');

        $request
            ->getAttribute('id')
            ->willReturn(1);

        $request
            ->getParsedBody()
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Matthew Setter',
                    'city' => 'Lisbon',
                    'phone' => '+1123456789',
                    'email' => 'dave.grohl@example.org',
                    'startDate' => 'September 7th, 2021',
                    'endDate' => 'September 10th, 2021',
                ]
            );

        $response = $apiHandler->handle($request->reveal());

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($response->getBody()->getContents(), '{"status":"success"}');
    }

    public function testCanDeleteExistingForecast()
    {
        $forecast = new Forecast();
        $forecast->setName('Matthew Setter');
        $forecast->setCity('Lisbon');
        $forecast->setEmail('dave.grohl@example.org');
        $forecast->setPhone('+1123456789');
        $forecast->setStartDate(new \DateTime('September 7th, 2021'));
        $forecast->setEndDate(new \DateTime('September 10th, 2021'));
        $forecast->setId(1);

        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findOneBy(['id' => 1])
            ->willReturn($forecast);

        $this->entityManager
            ->remove($forecast)
            ->shouldBeCalled();
        $this->entityManager
            ->flush()
            ->shouldBeCalled();
        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('DELETE');

        $request
            ->getAttribute('id')
            ->willReturn(1);

        $response = $apiHandler->handle($request->reveal());

        self::assertEquals(200, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($response->getBody()->getContents(), '{"status":"success"}');
    }

    public function testReturns404WhenAttemptingToDeleteNonExistentForecast()
    {
        /** @var EntityRepository|ObjectProphecy $repository */
        $repository = $this->prophesize(ObjectRepository::class);
        $repository
            ->findOneBy(['id' => 1])
            ->willReturn(null);

        $this->entityManager
            ->getRepository(Forecast::class)
            ->willReturn($repository->reveal());

        $apiHandler = new ApiHandler($this->entityManager->reveal());

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);
        $request
            ->getMethod()
            ->willReturn('DELETE');

        $request
            ->getAttribute('id')
            ->willReturn(1);

        $response = $apiHandler->handle($request->reveal());

        self::assertEquals(404, $response->getStatusCode());
        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertEquals($response->getBody()->getContents(), '{"status":"error","message":"Forecast not found"}');
    }

}
