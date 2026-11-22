<?php

namespace Nip\Debug\Tests;

use Nip\Debug\Debug;
use Nip\Debug\DebugServiceProvider;
use Nip\Debug\ErrorHandler;
use Symfony\Component\ErrorHandler\Debug as SymfonyDebug;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

/**
 * Class DebugServiceProviderTest
 * @package Nip\Debug\Tests
 */
class DebugServiceProviderTest extends AbstractTestCase
{
    public function test_registerDebug()
    {
        $provider = $this->initServiceProvider();
        $container = $provider->getContainer();

        $debug = $container->get('debug');
        self::assertInstanceOf(Debug::class, $debug);
        self::assertSame($debug, $container->get(Debug::class));
        self::assertSame($debug, $container->get(SymfonyDebug::class));
    }

    public function test_registerErrorHandler()
    {
        $provider = $this->initServiceProvider();
        $container = $provider->getContainer();

        $debug = $container->get('error-handler');
        self::assertInstanceOf(ErrorHandler::class, $debug);
        self::assertSame($debug, $container->get(ErrorHandler::class));
        self::assertSame($debug, $container->get(SymfonyErrorHandler::class));
    }

    public function testProvidesAllRegisteredServices(): void
    {
        $provider = $this->initServiceProvider();
        $container = $provider->getContainer();

        foreach ($provider->provides() as $service) {
            self::assertTrue($container->has($service));
            self::assertIsObject($container->get($service));
        }
    }

    public function testBootRegistersTheSharedErrorHandler(): void
    {
        $provider = $this->initServiceProvider();
        $handler = $provider->getContainer()->get('error-handler');

        $provider->boot();

        $registered = set_error_handler(static fn() => false);
        restore_error_handler();
        self::assertSame([$handler, 'handleError'], $registered);

        $registered = set_exception_handler(static fn() => null);
        restore_exception_handler();
        self::assertSame([$handler, 'handleException'], $registered);
    }

    public function testRegistrationPreservesAnExistingSymfonyHandler(): void
    {
        $handler = SymfonyErrorHandler::register(new SymfonyErrorHandler());
        $provider = $this->initServiceProvider();

        self::assertSame($handler, $provider->getContainer()->get('error-handler'));
        self::assertSame($handler, $provider->getContainer()->get(SymfonyErrorHandler::class));
    }

    public function testBootConvertsWarningsToExceptions(): void
    {
        $provider = $this->initServiceProvider();
        $provider->boot();

        $this->expectException(\ErrorException::class);
        $this->expectExceptionMessage('Debug handler test warning');

        $previousReporting = error_reporting(E_ALL);
        try {
            trigger_error('Debug handler test warning', E_USER_WARNING);
        } finally {
            error_reporting($previousReporting);
        }
    }

    /**
     * @return DebugServiceProvider
     */
    protected function initServiceProvider()
    {
        $provider = new DebugServiceProvider();
        $provider->initContainer();
        $provider->register();

        return $provider;
    }
}
