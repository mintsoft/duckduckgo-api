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
abstract class ClientListener implements ClientListenerInterface
{
    /**
     * @var ListenerInterface[]
     */
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function addListener(ListenerInterface $listener, $priority = 0)
    {
        // Don't allow same listener with different priorities.
        if ($this->isListener($listener->getName())) {
            $this->delListener($listener->getName());
        }

        $this->listeners[$priority][$listener->getName()] = $listener;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function delListener($name)
    {
        if ($name instanceof ListenerInterface) {
            $name = $name->getName();
        }

        if ($this->isListener($name) === true) {
            foreach ($this->listeners as $prio => $collection) {
                unset($this->listeners[$prio][$name]);
            }
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getListener($name)
    {
        if (!$listener = $this->searchListener($name)) {
            throw new \InvalidArgumentException(sprintf('Unknown listener %s', $name));
        }

        return $listener;
    }

    /**
     * {@inheritDoc}
     */
    public function isListener($name)
    {
        return ($this->searchListener($name) instanceof ListenerInterface);
    }

    /**
     * @access public
     * @return array
     */
    public function getListeners()
    {
        return $this->listeners;
    }

    /**
     * @access public
     * @return bool
     */
    public function hasListeners()
    {
        return (count($this->listeners) > 0);
    }

    /**
     * @access public
     * @param  array $listeners
     * @return $this;
     */
    public function setListeners(array $listeners)
    {
        foreach ($listeners as $prio => $listener) {
            $listener = array_values($listener);
            $this->addListener($listener[0], $prio);
        }

        return $this;
    }

    /**
     * @access protected
     * @param  string                 $name Listener name
     * @return ListenerInterface|bool false on error
     */
    protected function searchListener($name)
    {
        foreach ($this->listeners as $collection) {
            if (isset($collection[$name])) {
                return $collection[$name];
            }
        }

        return false;
    }
}
