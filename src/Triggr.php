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
        // Create a new event, store the name, action and options    
        $eventPhrase = new EventPhrase($eventPhrase);
        $handler = new Handler($eventPhrase, $func, $handlerOptions);
        $event = self::getEventCollection()->getEvent($eventPhrase)
            ->addHandler($handler);
    }

    public static function fire($eventName, array $args = null, EventOptions $eventOptionsOverride = null)
    {
        // Retrieves the event object, attempts to fire it based on options settings it may not fire
    }

    public static function fireHandler($eventPhrase, array $args = null)
    {
        // Fire a specif handler in an event if it has been named using EVT:HANDLR format
    }

    public static function setEventOptions($eventName, EventOptions $eventOptions)
    {
        // Allows options for a specific event to be set
        $eventPhrase = new EventPhrase($eventName, true);
        self::getEventCollection()->getEvent($eventPhrase)->setEventOptions($eventOptions);
    }

    public static function setHandlerOptions($eventPhrase, HandlerOptions $handlerOptions)
    {
        $eventPhrase = new EventPhrase($eventPhrase);
        $handler = self::getEventCollection()->getHandler($eventPhrase); // short cut to getEvent($eventPhrase)->getHandler($eventPhrase)
        if($handler) {
            $handler->setHandlerOptions($handlerOptions);
        }
    }

    /**
     * Retuns the event collection. Only one event collection exists in Triggr, if it doesn't exist yet, it is created.
     * @return EventCollection The collection of events defined by the Triggr::watch()
     */
    public static function getEventCollection()
    {
        if(!isset(self::$events))
        {
            self::$events = new EventCollection();
        }
        return self::$events;
    }
}