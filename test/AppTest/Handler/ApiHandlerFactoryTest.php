<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\ApiHandler;
use App\Handler\ApiHandlerFactory;
use App\Handler\HomePageHandler;
use App\Handler\HomePageHandlerFactory;
use Doctrine\ORM\EntityManager;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;

class ApiHandlerFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @var ContainerInterface|ObjectProphecy */
    protected $container;
    private $entityManager;

    protected function setUp(): void
    {
        /** @var ContainerInterface|ObjectProphecy container */
        $this->container = $this->prophesize(ContainerInterface::class);

        /** @var EntityManager|ObjectProphecy entityManager */
        $this->entityManager = $this->prophesize(EntityManager::class);
    }

    public function testFactoryWithoutTemplate()
    {
        $this->container
            ->get('doctrine.entity_manager.orm_default')
            ->willReturn($this->entityManager);

        $factory = new ApiHandlerFactory();
        self::assertInstanceOf(ApiHandlerFactory::class, $factory);

        $apiHandler = $factory($this->container->reveal());
        self::assertInstanceOf(ApiHandler::class, $apiHandler);
    }
}
