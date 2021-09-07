<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;

class ApiHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ApiHandler
    {
        return new ApiHandler($container->get('doctrine.entity_manager.orm_default'));
    }
}
