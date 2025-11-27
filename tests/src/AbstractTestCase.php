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

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreExceptionHandler();
    }

    protected function restoreExceptionHandler(): void
    {
        while (true) {
            $previousHandler = set_exception_handler(static fn() => null);

            restore_exception_handler();

            if ($previousHandler === null) {
                break;
            }

            restore_exception_handler();
        }
    }
}
