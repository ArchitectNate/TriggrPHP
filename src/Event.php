<?php

namespace TPE\TriggrPHP;

class Event
{
    private $name;
    private $handlers;

    /**
     * An event that can be fired or acted upon
     * @param string $name The event name that it will be called by
     */
    public function __construct($name)
    {
        $this->handlers = new HandlerCollection();
        $this->name = $name;

        return $this;
    }
}
