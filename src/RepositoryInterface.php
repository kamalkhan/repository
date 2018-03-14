<?php

namespace Bhittani\Repository;

interface RepositoryInterface extends \ArrayAccess
{
    /**
     * Get all items.
     *
     * @return array
     */
    public function all();

    /**
     * Determine if the given key exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key);

    /**
     * Get the value for the given key.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Set a key value.
     *
     * @param  array|string  $key
     * @param  mixed   $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Preset a default value for a given key.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function preset($key, $value);

    /**
     * Append a value onto an array item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function append($key, $value);

    /**
     * Prepend a value onto an array item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function prepend($key, $value);
}
