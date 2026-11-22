<?php

declare(strict_types=1);

use Nip\Debug\Debug;
use Nip\Debug\ErrorHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\ErrorHandler\Debug as SymfonyDebug;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set(Debug::class);
    $services->alias(SymfonyDebug::class, Debug::class);
    $services->alias('debug', Debug::class)->public();

    $services->set(ErrorHandler::class);
    $services->alias(SymfonyErrorHandler::class, ErrorHandler::class);
    $services->alias('error-handler', ErrorHandler::class)->public();
};
