<?php

declare(strict_types=1);

namespace Nip\Debug;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;
use Symfony\Component\ErrorHandler\Debug as SymfonyDebug;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

/**
 * Registers the legacy ByTIC services and their Symfony aliases.
 */
class DebugServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [
            'debug',
            Debug::class,
            SymfonyDebug::class,
            'error-handler',
            ErrorHandler::class,
            SymfonyErrorHandler::class,
        ];
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

        // Shared forwarding bindings also work with older container bridges.
        foreach ([Debug::class, SymfonyDebug::class] as $alias) {
            $this->getContainer()->share($alias, function () {
                return $this->getContainer()->get('debug');
            });
        }
    }

    public function registerErrorHandler()
    {
        $this->getContainer()->share('error-handler', function () {
            return ErrorHandler::register(null, false);
        });

        foreach ([ErrorHandler::class, SymfonyErrorHandler::class] as $alias) {
            $this->getContainer()->share($alias, function () {
                return $this->getContainer()->get('error-handler');
            });
        }
    }

    public function boot()
    {
        ErrorHandler::register($this->getContainer()->get(ErrorHandler::class), true);
    }
}
