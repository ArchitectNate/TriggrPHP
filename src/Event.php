<?php

namespace ArchNate\TriggrPHP;

use ArchNate\TriggrPHP\Handler;
use ArchNate\TriggrPHP\Tools\EventPhrase;
use ArchNate\TriggrPHP\Collection\HandlerCollection;

class Event
{
    private $name;
    private $handlerCollection;

    /**
     * An event that can be fired or acted upon
     * @param string $name The event name that it will be called by
     */
    public function __construct(EventPhrase $eventPhrase)
    {
        $this->handlerCollection = new HandlerCollection();
        $this->name = $eventPhrase->getEventName();

        return $this;
    }

    /**
     * Adds a handler to an event
     * @param Handler $handler The handler to be added to the event
     */
    public function addHandler(Handler $handler)
    {
        $this->getHandlerCollection()->addHandler($handler);
        $this->getHandlerCollection()->sortHandlers();

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
        $this->getHandlerCollection()->removeHandler($eventPhrase->getHandlerName());
        $this->getHandlerCollection()->sortHandlers();

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
     * @param  array  $args The arguments to be passed to each handler
     * @return mixed  An array of results for each handler run
     */
    public function fire(array $args = array())
    {
        $hc = $this->getHandlerCollection();
        $handlers = $hc->getHandlers();
        $return = array();

        foreach($hc->getHandlerSort() as $handlerPriority) {
            foreach($handlerPriority as $handlerName) {
                $return[$handlerName] = $handlers[$handlerName]->fire($args);
            }
        }

        return $return;
    }

    /**
     * Returns the event's handler collection
     * @return HandlerCollection
     */
    public function getHandlerCollection()
    {
        return $this->handlerCollection;
    }

    /**
     * Retrieves an individual handler on the event
     * @param  string $handlerName The handlername to retrieve
     * @return Handler|null If no handler exists, null is returned
     */
    public function getHandler($handlerName)
    {
        $eventPhrase = new EventPhrase($this->getName() . ":" . $handlerName);
        return $this->getHandlerCollection()->getHandlerByName($handlerName);
    }
}
