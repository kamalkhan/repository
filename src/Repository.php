<?php

/*
 * This file is part of bhittani/repository.
 *
 * (c) Kamal Khan <shout@bhittani.com>
 *
 * This source file is subject to the MIT license that
 * is bundled with this source code in the file LICENSE.
 */

namespace Bhittani\Repository;

class Repository implements RepositoryInterface
{
    /**
     * Repository items.
     *
     * @var array[mixed]
     */
    protected $items = [];

    /**
     * Instantiate the repository with optional items.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        $this->resolve($key, $has);

        return $has;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        $value = $this->resolve($key, $found);

        if (! $found) {
            return $default;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $items = $this->setter($key, $value);
        $this->items = array_replace_recursive($this->items, $items);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function preset($key, $value)
    {
        if ($this->has($key)) {
            return;
        }

        return $this->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function append($key, $value)
    {
        return $this->insert($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend($key, $value)
    {
        return $this->insert($key, $value, true);
    }

    /**
     * {@inheritdoc}
     */
    public function increment($key, $step = 1)
    {
        return $this[$key] += $step;
    }

    /**
     * {@inheritdoc}
     */
    public function decrement($key, $step = 1)
    {
        return $this[$key] -= $step;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            $this->setter($offset, null);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Insert a value into an array item.
     *
     * @param string $key
     * @param mixed  $value
     * @param bool   $prepend
     */
    protected function insert($key, $value, $prepend = false)
    {
        $oldValue = $this->get($key, []);

        if (is_array($oldValue)) {
            if ($prepend) {
                array_unshift($oldValue, $value);
            } else {
                $oldValue[] = $value;
            }

            return $this->set($key, $oldValue);
        }

        $newValue = $prepend ? [$value, $oldValue] : [$oldValue, $value];

        return $this->set($key, $newValue);
    }

    /**
     * Recursive set a key value.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return array
     */
    protected function setter($key, $value)
    {
        $keys = explode('.', $key);
        $key = array_shift($keys);

        if (0 == count($keys)) {
            return [$key => $value];
        }

        return [$key => $this->setter(implode('.', $keys), $value)];
    }

    /**
     * Resolve a dot notated key.
     *
     * @param  string $key
     * @param  bool   $found
     * @return mixed
     */
    protected function resolve($key, &$found = null)
    {
        $found = $found ?: false;

        $keys = explode('.', $key);

        $value = $this->items;

        foreach ($keys as $k) {
            if ((! is_array($value))
                || (! array_key_exists($k, $value))
            ) {
                $found = false;

                return;
            }

            $value = $value[$k];
        }

        $found = true;

        return $value;
    }
}
