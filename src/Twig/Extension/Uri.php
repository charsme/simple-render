<?php

namespace Resilient\Twig\Extension;

use \Psr\Http\Message\UriInterface;

/**
* Twig Router Extension for psr 6  UriInterface
*/
class Uri extends \Twig_Extension
{
    private $uri;

    public function __construct(UriInterface $uri)
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

        $scheme = $this->uri->getScheme();
        $authority = $this->uri->getAuthority();

        return ($scheme ? $scheme . ':' : '')
            . ($authority ? '//' . $authority : '');
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
