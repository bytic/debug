<?php

declare(strict_types=1);

namespace Nip\Debug;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;
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
        return ['error-handler', ErrorHandler::class, SymfonyErrorHandler::class];
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
            return ErrorHandler::register(null, false);
        });

        $this->getContainer()->alias('error-handler', ErrorHandler::class);
        $this->getContainer()->alias('error-handler', SymfonyErrorHandler::class);
    }

    public function boot()
    {
        ErrorHandler::register($this->getContainer()->get(ErrorHandler::class), true);
    }
}
