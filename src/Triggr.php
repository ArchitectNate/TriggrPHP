<?php
namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Collection\HandlerCollection;
use TPE\TriggrPHP\Collection\EventCollection;
use TPE\TriggrPHP\Options\EventOptions;
use TPE\TriggrPHP\Tools\EventPhrase;

class Triggr
{
    private static $events;

    public static function watch($eventPhrase, callable $func, HandlerOptions $handlerOptions = null)
    {
        // Create a new event, store the name, action and options    
        $eventPhrase = new EventPhrase($eventPhrase);
        $handler = new Handler($eventPhrase, $func, $handlerOptions);
        $event = self::getEvents()->getEvent($eventPhrase)
            ->addHandler($handler);
    }

    public static function fire($eventName, EventArgs $args = null, EventOptions $eventOptionsOverride = null)
    {
        // Retrieves the event object, attempts to fire it based on options settings it may not fire
    }

    public static function fireHandler($eventPhrase, EventArgs $args)
    {
        // Fire a specif handler in an event if it has been named using EVT:HANDLR format
    }

    public static function setEventOptions($eventName, EventOptions $eventOptions)
    {
        // Allows options for a specific event to be set
    }

    public static function setHandlerOptions($eventPhrase, HandlerOptions $handlerOptions)
    {
        // Allows options for a specific handler to be  set, if full EVT:HANDLR format isn't used, an error is thrown
    }

    /**
     * Retuns the event collection. Only one event collection exists in Triggr, if it doesn't exist yet, it is created.
     * @return EventCollection The collection of events defined by the Triggr::watch()
     */
    public static function getEvents()
    {
        if(!isset(self::$events))
        {
            self::$events = new EventCollection();
        }
        return self::$events;
    }
}