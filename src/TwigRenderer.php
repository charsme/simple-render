<?php

namespace Resilient;

use \Psr\Http\Message\ResponseInterface;

/**
 * TwigRenderer class.
 *
 * Provide implementation for abstract renderer, specifically made with twig engine
 *
 * @extends AbstractRenderer
 */
class TwigRenderer extends AbstractRenderer
{
    protected $loader;
    protected $environment;

    /**
     * __construct function.
     *
     * @access public
     * @param mixed $path
     * @param array $options (default: [])
     */
    public function __construct($path, array $options = [])
    {
        $this->loader = $this->createLoader(is_array($path) ? $path : [$path]);
        $this->environment = new \Twig_Environment($this->loader, $options);
    }

    /**
     * addExtension function.
     *
     * @access public
     * @param \Twig_ExtensionInterface $extension
     * @return $this
     */
    public function addExtension(\Twig_ExtensionInterface $extension)
    {
        $this->environment->addExtension($extension);

        return $this;
    }

    /**
     * addFilter function.
     *
     * @access public
     * @param \Twig_Filter $filter
     * @return $this
     */
    public function addFilter(\Twig_Filter $filter)
    {
        $this->environment->addFilter($filter);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function template($template)
    {
        return $this->environment->load($template);
    }

    /**
     * Twig renderBlock function.
     *
     * @access public
     * @param mixed $template
     * @param mixed $block_name
     * @param mixed $data (default: [])
     * @return string rendered block
     */
    public function renderBlock($template, $block_name, $data = [])
    {
        return $this->template($template)->renderBlock($block_name, $this->merge_data($data));
    }

    /**
     * {@inheritdoc}
     */
    public function render(ResponseInterface $response, $template, $data = [])
    {
        $response->getBody()->write($this->template($template)->render($this->merge_data($data)));

        return $response;
    }

    /**
     * getLoader function.
     *
     * @access public
     * @return Twig_Loader_Filesystem
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * getEnvironment function.
     *
     * @access public
     * @return Twig_Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * createLoader function.
     *
     * @access protected
     * @param array $paths
     * @return Twig_Loader_Filesystem
     */
    protected function createLoader(array $paths)
    {
        $loader = new \Twig_Loader_Filesystem();

        foreach ($paths as $namespace => $path) {
            if (is_string($namespace)) {
                $loader->setPaths($path, $namespace);
                continue;
            }

            $loader->addPath($path);
        }

        return $loader;
    }
}
