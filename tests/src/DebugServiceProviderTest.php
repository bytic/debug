<?php

namespace Nip\Debug\Tests;

use Nip\Debug\Debug;
use Nip\Debug\DebugServiceProvider;
use Nip\Debug\ErrorHandler;

/**
 * Class DebugServiceProviderTest
 * @package Nip\Debug\Tests
 */
class DebugServiceProviderTest extends AbstractTest
{
    public function test_registerDebug()
    {
        $provider = $this->initServiceProvider();
        $container = $provider->getContainer();

        $debug = $container->get('debug');
        self::assertInstanceOf(Debug::class, $debug);
    }

    public function test_registerErrorHandler()
    {
        $provider = $this->initServiceProvider();
        $container = $provider->getContainer();

        $debug = $container->get('error-handler');
        self::assertInstanceOf(ErrorHandler::class, $debug);
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
