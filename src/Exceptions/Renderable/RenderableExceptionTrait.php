<?php

namespace Nip\Debug\Exceptions\Renderable;

/**
 *
 */
trait RenderableExceptionTrait
{
    public function getMessagePublic()
    {
        return $this->getMessage();
    }

    public function getContentHtml()
    {
        return $this->renderContent('/views/error.html.php', [
            'exception' => $this,
        ]);
    }

    /**
     * @return string
     */
    public function renderContent(string $name, array $context = [])
    {
        extract($context, \EXTR_SKIP);
        ob_start();

        $baseDir = \dirname(__DIR__, 2) . '/Resources/';

        include is_file($baseDir . $name)
            ? $baseDir . $name
            : $name;

        return trim(ob_get_clean());
    }
}