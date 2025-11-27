<?php

namespace Nip\Debug\Exceptions\Renderable;

/**
 *
 */
class RenderableException extends \Exception implements RenderableExceptionInterface
{
    use RenderableExceptionTrait;

}