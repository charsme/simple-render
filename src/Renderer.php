<?php

namespace Resilient;


/**
* Renderer Class
*/
class Renderer {

	protected $loader;
	protected $twig;

	public function __construct(string $path, array $options = [])
	{
        $this->loader = new Twig_Loader_Filesystem($path);
        $this->twig = new Twig_Environment($loader, $options);
	}



	public function getTwig()
	{
    	return $this->twig;
	}

    public function addFilter(Twig_Filter $filter)
	{
    	$this->twig->addFilter($filter);

    	return $this;
	}

	public function addExtension(Twig_ExtensionInterface $extension)
	{
    	$this->twig->addExtension(new Project_Twig_Extension());
	}

    public function render()
    {

    }

}
