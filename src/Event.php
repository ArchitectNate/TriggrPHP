<?php

namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Handler;
use TPE\TriggrPHP\Tools\EventPhrase;
use TPE\TriggrPHP\Collection\HandlerCollection;

class Event
{
    private $name;
    private $handlers;

    /**
     * An event that can be fired or acted upon
     * @param string $name The event name that it will be called by
     */
    public function __construct(EventPhrase $eventPhrase)
    {
        $this->handlers = new HandlerCollection();
        $this->name = $eventPhrase->getEventName();

        return $this;
    }

    public function addHandler(Handler $handler)
    {
        $this->handlers->addHandler($handler);
        $this->handlers->sortHandlers();

        return $this;
    }

    /**
     * Returns the event name which was derived from an EventPhrase
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
