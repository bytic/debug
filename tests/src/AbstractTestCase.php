<?php

namespace Nip\Debug\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 */
abstract class AbstractTestCase extends TestCase
{
    protected $object;

    /**
     * @var \UnitTester
     */
    protected $tester;

    private $previousErrorHandler;

    private $previousExceptionHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->previousErrorHandler = set_error_handler(static fn() => false);
        restore_error_handler();

        $this->previousExceptionHandler = set_exception_handler(static fn() => null);
        restore_exception_handler();
    }

    protected function tearDown(): void
    {
        $this->restoreErrorHandler();
        $this->restoreExceptionHandler();

        parent::tearDown();
    }

    protected function restoreErrorHandler(): void
    {
        while (true) {
            $previousHandler = set_error_handler(static fn() => false);
            restore_error_handler();

            if ($previousHandler === $this->previousErrorHandler) {
                break;
            }

            self::assertNotNull($previousHandler, 'The original error handler was removed.');
            restore_error_handler();
        }
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);

            restore_exception_handler();

            if ($previousHandler === $this->previousExceptionHandler) {
                break;
            }

            self::assertNotNull($previousHandler, 'The original exception handler was removed.');
            restore_exception_handler();
        }
    }
}
