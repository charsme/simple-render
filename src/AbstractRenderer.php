<?php

namespace Resilient;

use \Resilient\Design\RendererInterface;
use \Psr\Http\Message\ResponseInterface;
use \Resilient\Traits\ArrayAccessAble;

/**
 * Abstract AbstractRenderer class.
 *
 * @abstract
 */
abstract class AbstractRenderer implements RendererInterface
{
    use ArrayAccessAble;

    /**
     * template function.
     *
     * @access protected
     * @abstract
     * @param mixed $template
     */
    abstract protected function template($template);

    /**
     * {@inheritdoc}
     */
    abstract public function renderBlock($template, $blockName, $data = []);

    /**
     * {@inheritdoc}
     */
    abstract public function render(ResponseInterface $response, $template, $data = []);

    /**
     * mergeData function.
     *
     * @access protected
     * @param mixed $data
     * @return array
     */
    protected function mergeData($data)
    {
        return array_merge($this->offset, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function loadConfig(array $offset)
    {
        $this->offset = $this->mergeData($offset);

        return $this;
    }
}
