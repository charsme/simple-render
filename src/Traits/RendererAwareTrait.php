<?php

namespace Resilient\Traits;

use \Resilient\Design\RendererInterface;

trait RendererAwareTrait
{
    protected $renderer;

    public function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function getRenderer():RendererInterface
    {
        return $this->renderer;
    }
}
