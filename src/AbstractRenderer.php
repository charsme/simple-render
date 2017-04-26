<?php

namespace Resilient;

use \Psr\Http\Message\ResponseInterface;

/**
 * Abstract AbstractRenderer class.
 *
 * @abstract
 */
abstract class AbstractRenderer implements \ArrayAccess
{

	protected $offset = [];

	/**
	 * template function.
	 *
	 * @access protected
	 * @abstract
	 * @param mixed $template
	 */
	abstract protected function template($template);

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
	abstract public function render(ResponseInterface $response, $template, $data = []);

    /**
     * merge_data function.
     *
     * @access protected
     * @param mixed $data
     * @return array
     */
    protected function merge_data($data)
	{
		return array_merge($this->offset, $data);
	}

	/**
	 * loadConfig function.
	 *
	 * @access public
	 * @param array $offset
	 * @return $this
	 */
	public function loadConfig(array $offset)
	{
    	$this->offset = $this->merge_data($offset);

    	return $this;
	}

	/**
	 * ArrayAccess Implementations
	 */

	/**
     * {@inheritdoc}
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key)
    {
        return $this->offset[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value)
    {
        $this->offset[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key)
    {
        unset($this->offset[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->offset);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->offset);
    }

}
