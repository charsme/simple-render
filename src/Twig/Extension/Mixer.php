<?php

namespace Resilient\Twig\Extension;

use Exception;

/**
* Twig Mixer Extension for Slim with manifest.json option
*/
class Mixer extends \Twig_Extension
{
    protected $cdn;
    protected $manifest;

    public function __construct(array $manifest = [], string $cdn = '')
    {
        $this->mapManifest($manifest);
        $this->setCdn($cdn);
    }

    public function mapManifest(array $manifest)
    {
        $this->manifest = $manifest;
        return $this;
    }

    public function setCdn($cdn)
    {
        $this->cdn = $cdn;
        return $this;
    }

    public function callableManifest(callable $callable)
    {
        $result = $callable();

        if (\is_array($result)) {
            $this->mapManifest($result);
        }

        return $this;
    }

    public function getName():string
    {
        return 'twig mixer extension';
    }

    public function getFunctions():array
    {
        return [
            new \Twig_SimpleFunction('css', array($this, 'cssAlias')),
            new \Twig_SimpleFunction('js', array($this, 'jsAlias')),
            new \Twig_SimpleFunction('img', array($this, 'imgAlias')),
        ];
    }

    public function cssAlias(string $file):string
    {
        $file = $file ? "css/{$file}.css" : 'css/app.css';

        return $this->getAssetPath($file);
    }

    public function jsAlias(string $file):string
    {
        $file = $file ? "js/{$file}.js" : 'js/app.js';

        return $this->getAssetPath($file);
    }

    public function getAssetPath(string $file):string
    {
        if (!array_key_exists($file, $this->manifest)) {
            throw new Exception("file {$file} not registered on manifest, please check manifest file and try again \n maybe need to run `gulp production`");
        }

        return $this->cdn . $this->manifest[$file];
    }

    public function imgAlias(string $path):string
    {
        return $this->cdn . $path;
    }
}
