<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Collection;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class Collection
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
    public function remove($key): self
    {
        if ($this->hasKey($key)) {
            unset($this->elements[$key]);
        }

        return $this;
    }

    /**
     * Flatten elements
     *
     * @param int $depth
     *
     * @return Collection
     */
    public function flatten(int $depth = 1): self
    {
        return new static($this->doFlatten($this->elements, $depth));
    }

    /**
     * Reset elements
     *
     * @return Collection
     */
    public function reset(): self
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Check value is exist
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function has($value): bool
    {
        return in_array($value, $this->elements) ? true : false;
    }

    /**
     * Check key is exist
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function hasKey($key): bool
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
     * Implode elements
     *
     * @param string|null $glue
     *
     * @return string
     */
    public function implode(string  $glue = null): string
    {
        return implode($glue, $this->elements);
    }

    /**
     * Sort elements
     *
     * @param callable $callback
     *
     * @return Collection
     */
    public function sort(callable $callback): self
    {
        uasort($this->elements, $callback);

        return $this;
    }

    /**
     * Remove all values of elements
     *
     * @return Collection
     */
    public function keys(): self
    {
        return new static(array_keys($this->elements));
    }

    /**
     * Merge array to collection
     *
     * @param array $elements
     *
     * @return Collection
     */
    public function merge(array $elements): self
    {
        return new static(array_merge($this->elements, $elements));
    }

    /**
     * Flip array
     *
     * @return Collection
     */
    public function flip(): self
    {
        return new static(array_flip($this->elements));
    }

    /**
     * Count elements
     *
     * @return int
     */
    public function count(): int
    {
        return \count($this->elements);
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

    /**
     * Get elements as array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->elements;
    }

    private function doFlatten(array $elements, int $depth = 1): array
    {
        $result = [];
        foreach ($elements as $element) {
            if (!is_array($element)) {
                $result[] = $element;
            } elseif ($depth === 1) {
                $result = array_merge($result, array_values($element));
            } else {
                $result = array_merge($result, $this->doFlatten($element, $depth - 1));
            }
        }

        return $result;
    }
}
