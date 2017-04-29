<?php

namespace Resilient\Design;

use \Psr\Http\Message\ResponseInterface;

interface RendererInterface extends \ArrayAccess
{
    /**
     * Rendering just some block or somepart.
     *
     * @access public
     * @abstract
     * @param mixed $template
     * @param mixed $blockName
     * @param mixed $data (default: [])
     * @return string
     */
    public function renderBlock($template, $blockName, $data = []);

    /**
     * render function.
     *
     * @access public
     * @abstract
     * @param ResponseInterface $response
     * @param mixed $template
     * @param mixed $data (default: [])
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data = []);

    /**
     * loadConfig function.
     *
     * @access public
     * @param array $offset
     * @return $this
     */
    public function loadConfig(array $offset);
}
