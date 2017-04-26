<?php
declare(strict_types=1);

namespace Resilient;

use \Resilient\TwigRenderer;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;
use BadMethodCallException;

final class RenderTest extends \PHPUnit\Framework\TestCase
{
    protected $renderer;

    /**
     * @covers Renderer::__construct
     * @covers Renderer::createLoader
     */
    public function __construct()
    {
        $path = __DIR__.'/view/';
        $opts = [];

        $this->renderer = new TwigRenderer($path, $opts);
    }

    /**
     * @covers Renderer::getLoader
     * @covers Renderer::getEnvironment
     */
    public function testEnvironment():void
    {
        $this->assertInstanceOf('Resilient\TwigRenderer', $this->renderer);
        $this->assertInstanceOf('Twig_Loader_Filesystem', $this->renderer->getLoader());
        $this->assertInstanceOf('Twig_Environment', $this->renderer->getEnvironment());

    }

    /**
     * @covers Renderer::render
     * @covers Renderer::template
     */
    public function testRender():void
    {
        $response = new \Zend\Diactoros\Response();

        $this->assertInstanceOf('\Psr\Http\Message\ResponseInterface', $response);

        $data = ['title' => 'Big HEAD'];

        $response = $this->renderer->render($response, 'index.twig', $data);

        $this->assertEquals("<h1>${data['title']}</h1>", $response->getBody());

    }

    /**
     * @covers Renderer::renderBlock
     */
    public function testRenderBlock():void
    {
        $data = ['title' => 'Big HEAD'];

        $response = $this->renderer->renderBlock('two.twig', 'content',$data);

        $this->assertEquals("<h3>${data['title']}</h3>", trim($response));
    }

    /**
     * @covers Renderer::render
     * @covers Renderer::template
     */
    public function testOffset():void
    {
        $data = [];

        $url = 'http://www.example.com/';
        $label = 'label url';

        $this->renderer['url'] = $url;
        $this->renderer['label'] = $label;

        $response = $this->renderer->render(new \Zend\Diactoros\Response(), 'three.twig', $data);

        $this->assertEquals("<a href='$url'>$label</a>", (string) $response->getBody() );

    }

}