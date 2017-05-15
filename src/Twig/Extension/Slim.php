<?php

namespace Resilient\Twig\Extension;

use \Slim\Http\Uri as SlimUri;
use \Slim\Interfaces\RouterInterface;

/**
* Twig Router Extension for Slim Routing
*/
class Slim extends \Twig_Extension
{
    private $uri;
    private $router;

    public function __construct(RouterInterface $router, SlimUri $uri)
    {
        $this->router = $router;
        $this->uri = $uri;
    }

    public function getName()
    {
        return 'slim kln';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('path_for', array($this, 'pathFor')),
            new \Twig_SimpleFunction('base_url', array($this, 'baseUrl')),
            new \Twig_SimpleFunction('is_current_path', array($this, 'isCurrentPath')),
        ];
    }

    /**
     * pathFor function.
     *
     * @access public
     * @param mixed $name
     * @param mixed $data (default: [])
     * @param mixed $queryParams (default: [])
     * @return string
     */
    public function pathFor($name, $data = [], $queryParams = [])
    {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    /**
     * baseUrl function.
     *
     * @access public
     * @return string
     */
    public function baseUrl()
    {
        if (is_string($this->uri)) {
            return $this->uri;
        }

        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    /**
     * isCurrentPath function.
     *
     * @access public
     * @param mixed $name
     * @return boolean
     */
    public function isCurrentPath($name)
    {
        return $this->router->pathFor($name) === $this->uri->getPath();
    }

    /**
     * Set the base url
     *
     * @param string|Slim\Http\Uri $baseUrl
     * @return void
     */
    public function setBaseUrl($baseUrl)
    {
        $this->uri = $baseUrl;
    }
}
