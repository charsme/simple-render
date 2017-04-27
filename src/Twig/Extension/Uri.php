<?php

namespace Resilient\Twig\Extension;

use \Zend\Diactoros\Uri;

/**
* Twig Router Extension for zendframework/zend-diactoros
*/
class Uri extends \Twig_Extension
{
    private $uri;

    public function __construct(Uri $uri)
    {
        $this->uri = $uri;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('base_url', array($this, 'baseUrl')),
            new \Twig_SimpleFunction('current_path', array($this, 'currentPath')),
            new \Twig_SimpleFunction('current_url', array($this, 'currentUrl')),
        ];
    }

    /**
     * baseUrl function.
     *
     * @access public
     * @return string uri
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
     * currentPath function.
     *
     * @access public
     * @return string
     */
    public function currentPath()
    {
        return $this->uri->getPath();
    }

    /**
     * currentUrl function.
     *
     * @access public
     * @return string
     */
    public function currentUrl()
    {
        return (string) $this->uri;
    }
}
