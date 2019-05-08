<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Collection;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Collection implements IteratorAggregate, ArrayAccess
{
    /**
     * @var array
     */
    private $elements;

    private function __construct($elements)
    {
        $this->elements = (array) $elements;
    }

    /**
     * Create new collection instance
     *
     * @param $elements
     *
     * @return Collection
     */
    public static function collect($elements): self
    {
        return new static($elements);
    }

    /**
     * Add new elements
     *
     * @param mixed $value
     * @param null $key
     *
     * @return Collection
     */
    public function add($value, $key = null)
    {
        if ($key) {
            $this->elements[$key] = $value;
        } else {
            $this->elements[] = $value;
        }

        return $this;
    }

    /**
     * Get element
     *
     * @param mixed $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return $this->elements[$key] ?? null;
    }

    /**
     * Remove element from collection
     *
     * @param mixed $key
     *
     * @return Collection
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->elements[$key]);
        }

        return $this;
    }

    /**
     * Check key of elements
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return isset($this->elements[$key]) || array_key_exists($key, $this->elements);
    }

    /**
     * Loop each element
     *
     * @param callable $callback
     *
     * @return Collection
     */
    public function each(callable $callback): self
    {
        foreach ($this->elements as $key => $item) {
            if ($callback($item, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * Get last element
     *
     * @return mixed
     */
    public function last()
    {
        return array_pop($this->elements);
    }

    /**
     * Reverse elements
     *
     * @return Collection
     */
    public function reverse(): self
    {
        return new static(array_reverse($this->elements));
    }

    /**
     * Make unique collection
     *
     * @return Collection
     */
    public function unique(): self
    {
        return new static(array_unique($this->elements));
    }

    /**
     * Map elements by callback function
     *
     * @param callable $callback
     *
     * @return Collection
     */
    public function map(callable $callback): self
    {
        return new static(array_map($callback, $this->elements));
    }

    /**
     * Filter elements by callback function
     *
     * @param callable $callback
     *
     * @return Collection
     */
    public function filter(callable $callback): self
    {
        return new static(array_filter($this->elements, $callback));
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->elements);
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->add($value, $offset);
    }

    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}
