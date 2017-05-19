<?php

namespace Resilient\Design;

/**
 * RendererAwareInterface
 * Simple interface for easy renderer engine injection and depency resolver
 */
interface RendererAwareInterface
{
    /**
     * setRenderer
     *
     * @param RendererInterface $renderer
     * @return $this
     */
    public function setRenderer(RendererInterface $renderer);
    
    /**
     * getRenderer
     *
     * @return RendererInterface
     */
    public function getRenderer():RendererInterface;
}
