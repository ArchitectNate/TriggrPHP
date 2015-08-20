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

    /**
     * Adds a handler to an event
     * @param Handler $handler The handler to be added to the event
     */
    public function addHandler(Handler $handler)
    {
        $this->handlers->addHandler($handler);
        $this->handlers->sortHandlers();

        return $this;
    }

    /**
     * Removes a handler by it's name. It passes the handler name through the
     * EventPhrase to validate it
     * @param  string $handlerName [description]
     * @return [type]              [description]
     */
    public function removeHandler($handlerName)
    {
        $eventPhrase = new EventPhrase($this->getName() . ":" . $handlerName);
        $this->handlers->removeHandler($eventPhrase->getHandlerName());

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

    /**
     * Fires all handlers in the event's HandlerCollection
     * @return void
     */
    public function fire()
    {
        $handlers = $hc->getHandlers();

        foreach($hc->getHandlerSort() as $handlerPriority) {
            foreach($handlerPriority as $handlerName) {
                $handlers[$handlerName]->fire();
            }
        }
    }

    /**
     * Returns the event's handler collection
     * @return HandlerCollection
     */
    public function getHandlerCollection()
    {
        return $this->handlers;
    }
}
