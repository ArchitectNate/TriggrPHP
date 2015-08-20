<?php
namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Collection\HandlerCollection;
use TPE\TriggrPHP\Collection\EventCollection;
use TPE\TriggrPHP\Options\EventOptions;
use TPE\TriggrPHP\Tools\EventPhrase;

class Triggr
{
    private static $events;

    /**
     * Registers a new event or updates an existing one with a new handler
     * @param  string              $eventPhrase    The event identifier in the form of "EventName:HandlerName"
     * @param  callable            $func           The function to be run when the handler/event is called
     * @param  HandlerOptions|null $handlerOptions Any options that should be set for this particular handler
     * @return void                              
     */
    public static function watch($eventPhrase, callable $func, HandlerOptions $handlerOptions = null)
    {
        $eventPhrase = new EventPhrase($eventPhrase);
        $handler = new Handler($eventPhrase, $func, $handlerOptions);
        $event = self::getEventCollection()
            ->getEvent($eventPhrase)
            ->addHandler($handler);
    }

    /**
     * Fires an event (and therefore fires all handlers within that event)
     * @param  string     $eventName The event name only, a full event phrase will be rejected
     * @param  array|null $args      The arguments to be passed to each handler
     * @return array                 An array of all returned values from the handlers
     */
    public static function fire($eventName, array $args = null)
    {
        return self::getEventCollection()
            ->getEvent(new EventPhrase($eventName, true))
            ->fire($args);
    }

    /**
     * Fires an individual handler
     * @param  string     $eventPhrase The event phrase targeting a single handler
     * @param  array|null $args        The array of arguments to be passed to the handler
     * @return mixed|null              The return value of the handler function
     */
    public static function fireHandler($eventPhrase, array $args = null)
    {
        $eventPhrase = new EventPhrase($eventPhrase);
        if($eventPhrase->getHandlerName()) {
            return self::getEventCollection()
                ->getEvent($eventPhrase)
                ->getHandler($eventPhrase->getHandlerName())
                ->fire($args);
        }
    }

    public static function setEventOptions($eventName, EventOptions $eventOptions)
    {
        // Allows options for a specific event to be set
        $eventPhrase = new EventPhrase($eventName, true);
        self::getEventCollection()->getEvent($eventPhrase)->setEventOptions($eventOptions);
    }

    /**
     * Changes the handler options of a specific handler
     * @param string         $eventPhrase    The event phrase that targets the handler
     * @param HandlerOptions $handlerOptions The new options to be set, this completely overrides
     */
    public static function setHandlerOptions($eventPhrase, HandlerOptions $handlerOptions)
    {
        $eventPhrase = new EventPhrase($eventPhrase);
        $handler = self::getEventCollection()->getHandler($eventPhrase); // short cut to getEvent($eventPhrase)->getHandler($eventPhrase)
        if($handler) {
            $handler->setHandlerOptions($handlerOptions);
        }
    }

    /**
     * Removes a handler from a particular event
     * @param  string $eventPhrase The event phrase with the handler name to be removed
     * @return [type]              [description]
     */
    public static function removeEventHandler($eventPhrase)
    {
        $eventPhrase = new EventPhrase($eventPhrase);

        if(!is_null($eventPhrase->getHandlerName()))
        {
            self::getEventCollection()
                ->getEvent($eventPhrase)
                ->removeHandler($eventPhrase->getHandlerName());
        }
    }

    /**
     * Retuns the event collection. Only one event collection exists in Triggr, if it doesn't exist yet, it is created.
     * @return EventCollection The collection of events defined by the Triggr::watch()
     */
    private static function getEventCollection()
    {
        if(!isset(self::$events))
        {
            self::$events = new EventCollection();
        }
        return self::$events;
    }
}