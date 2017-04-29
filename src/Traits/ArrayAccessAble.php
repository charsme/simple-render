<?php

namespace Resilient\Traits;

trait ArrayAccessAble
{
    protected $offset = [];

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
