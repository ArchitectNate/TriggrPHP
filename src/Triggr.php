<?php
namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Collection\HandlerCollection;
use TPE\TriggrPHP\Options\EventOptions;
use TPE\TriggrPHP\Tools\EventPhraseParser;

class Triggr
{
    public static function watch($eventPhrase, Handler $handler, HandlerOptions $handlerOptions)
    {
        // Create a new event, store the name, action and options   
    }

    public static function fire($eventName, EventArgs $args, EventOptions $eventOptionsOverride)
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
}