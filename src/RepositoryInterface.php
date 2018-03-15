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
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Get the value for the given key.
     *
     * @param string $key
     * @param mixed  $default
     */
    public function get($key, $default = null);

    /**
     * Set a key value.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function set($key, $value);

    /**
     * Preset a default value for a given key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function preset($key, $value);

    /**
     * Append a value onto an array item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function append($key, $value);

    /**
     * Prepend a value onto an array item.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function prepend($key, $value);

    /**
     * Increment a value.
     *
     * @param string $key
     * @param mixed  $step
     */
    public function increment($key, $step = 1);

    /**
     * Decrement a value.
     *
     * @param string $key
     * @param mixed  $step
     */
    public function decrement($key, $step = 1);
}
