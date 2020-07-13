<?php

namespace Nip\Debug;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;
use Symfony\Component\ErrorHandler\ErrorHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\ErrorHandler\BufferingLogger;

/**
 * Class LoggerServiceProvider
 * @package Nip\Logger
 */
class DebugServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['error-handler', ErrorHandler::class, \Nip\Debug\ErrorHandler::class];
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerDebug();
        $this->registerErrorHandler();
    }

    public function registerDebug()
    {
        $this->getContainer()->share('debug', function () {
            return new Debug();
        });
    }

    public function registerErrorHandler()
    {
        $this->getContainer()->share('error-handler', function () {
            $logger =
//                $this->getContainer()->has(LoggerInterface::class)
//                ? $this->getContainer()->get(LoggerInterface::class)
//                :
                    new BufferingLogger();

            return new ErrorHandler($logger);
        });

        $this->getContainer()->alias('error-handler', ErrorHandler::class);
        $this->getContainer()->alias('error-handler', \Nip\Debug\ErrorHandler::class);
    }

    public function boot()
    {
        ErrorHandler::register($this->getContainer()->get(ErrorHandler::class), true);
    }
}
