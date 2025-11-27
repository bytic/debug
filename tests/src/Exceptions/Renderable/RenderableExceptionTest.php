<?php

namespace Nip\Debug\Tests\Exceptions\Renderable;

use Nip\Debug\Exceptions\Renderable\RenderableException;
use Nip\Debug\Exceptions\Renderable\RenderableExceptionInterface;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class RenderableExceptionTest extends TestCase
{
    public function testImplementsInterface(): void
    {
        $exception = new RenderableException('Test message');

        static::assertInstanceOf(RenderableExceptionInterface::class, $exception);
    }

    public function testGetMessagePublicReturnsOriginalMessage(): void
    {
        $message = 'Public safe message';
        $exception = new RenderableException($message);

        static::assertSame($message, $exception->getMessagePublic());
    }

    public function testRenderContentIncludesTemplateWithContext()
    {

        $message = 'Public safe message';
        $exception = new RenderableException($message);

        static::assertStringEqualsFile(
            TEST_FIXTURE_PATH . '/Exceptions/Renderable/base.html',
            $exception->getContentHtml()
        );
    }
}
