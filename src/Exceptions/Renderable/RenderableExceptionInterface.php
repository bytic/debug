<?php

namespace Nip\Debug\Exceptions\Renderable;

/**
 *
 */
interface RenderableExceptionInterface
{
    public function getMessagePublic();

    public function getContentHtml();
}