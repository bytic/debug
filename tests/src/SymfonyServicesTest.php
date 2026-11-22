<?php

declare(strict_types=1);

namespace Nip\Debug\Tests;

use Nip\Debug\Debug;
use Nip\Debug\ErrorHandler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\ErrorHandler\Debug as SymfonyDebug;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

class SymfonyServicesTest extends AbstractTestCase
{
    public function testServicesCanBeAutowiredUsingBothNamespaces(): void
    {
        $originalErrorHandler = set_error_handler(static fn() => false);
        restore_error_handler();
        $originalExceptionHandler = set_exception_handler(static fn() => null);
        restore_exception_handler();

        $container = new ContainerBuilder();
        $loader = new PhpFileLoader($container, new FileLocator(PROJECT_BASE_PATH . '/src/Resources/config'));
        $loader->load('services.php');

        $container->register('legacy-consumer', LegacyDebugConsumer::class)->setAutowired(true)->setPublic(true);
        $container->register('symfony-consumer', SymfonyDebugConsumer::class)->setAutowired(true)->setPublic(true);
        $container->compile();

        $legacy = $container->get('legacy-consumer');
        $symfony = $container->get('symfony-consumer');

        self::assertSame($legacy->debug, $symfony->debug);
        self::assertSame($legacy->handler, $symfony->handler);
        self::assertSame($legacy->debug, $container->get('debug'));
        self::assertSame($legacy->handler, $container->get('error-handler'));

        $registered = set_error_handler(static fn() => false);
        restore_error_handler();
        self::assertSame($originalErrorHandler, $registered);
        $registered = set_exception_handler(static fn() => null);
        restore_exception_handler();
        self::assertSame($originalExceptionHandler, $registered);

        SymfonyErrorHandler::register($symfony->handler);
        $registered = set_error_handler(static fn() => false);
        restore_error_handler();
        self::assertSame([$legacy->handler, 'handleError'], $registered);
    }
}

class LegacyDebugConsumer
{
    public function __construct(public Debug $debug, public ErrorHandler $handler)
    {
    }
}

class SymfonyDebugConsumer
{
    public function __construct(public SymfonyDebug $debug, public SymfonyErrorHandler $handler)
    {
    }
}
