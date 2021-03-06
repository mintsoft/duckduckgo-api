<?php

/**
 * This file is part of the duckduckgo-api package.
 *
 * (c) Alexandru Guzinschi <alex@gentle.ro>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DDG\API\Http;

use DDG\API\Http\Listener\ListenerInterface;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
interface ClientListenerInterface
{
    /**
     * @access public
     * @param  ListenerInterface $listener
     * @return $this
     */
    public function addListener(ListenerInterface $listener);

    /**
     * @access public
     * @param  ListenerInterface|string $name
     * @return $this
     */
    public function delListener($name);

    /**
     * Get listener interface
     *
     * @param  string            $name
     * @return ListenerInterface
     *
     * @throws \InvalidArgumentException
     */
    public function getListener($name);

    /**
     * @access public
     * @return array
     */
    public function getListeners();

    /**
     * @access public
     * @return bool
     */
    public function hasListeners();

    /**
     * @access public
     * @param  array $listeners
     * @return $this
     */
    public function setListeners(array $listeners);

    /**
     * Check if a listener exists
     *
     * @access public
     * @param  string $name
     * @return bool
     */
    public function isListener($name);
}
