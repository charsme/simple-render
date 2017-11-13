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
    public function setUp()
    {
        $path = __DIR__.'/view/';
        $opts = [];

        $this->renderer = new TwigRenderer($path, $opts);
    }

    /**
     * @covers Renderer::getLoader
     * @covers Renderer::getEnvironment
     */
    public function testEnvironment()
    {
        $this->assertInstanceOf('Resilient\TwigRenderer', $this->renderer);
        $this->assertInstanceOf('Twig_Loader_Filesystem', $this->renderer->getLoader());
        $this->assertInstanceOf('Twig_Environment', $this->renderer->getEnvironment());

        return;
    }

    /**
     * @covers Renderer::render
     * @covers Renderer::template
     */
    public function testRender()
    {
        $response = new \Zend\Diactoros\Response();

        $this->assertInstanceOf('\Psr\Http\Message\ResponseInterface', $response);

        $data = ['title' => 'Big HEAD'];

        $response = $this->renderer->render($response, 'index.twig', $data);

        $this->assertEquals("<h1>${data['title']}</h1>", $response->getBody());

        return;
    }

    /**
     * @covers Renderer::renderBlock
     */
    public function testRenderBlock()
    {
        $data = ['title' => 'Big HEAD'];

        $response = $this->renderer->renderBlock('two.twig', 'content', $data);

        $this->assertEquals("<h3>${data['title']}</h3>", trim($response));

        return;
    }

    /**
     * @covers Renderer::render
     * @covers Renderer::template
     */
    public function testOffset()
    {
        $data = [];

        $url = 'http://www.example.com/';
        $label = 'label url';

        $this->renderer['url'] = $url;
        $this->renderer['label'] = $label;

        $response = $this->renderer->render(new \Zend\Diactoros\Response(), 'three.twig', $data);

        $this->assertEquals("<a href='$url'>$label</a>", (string) $response->getBody());

        return;
    }
}
