<?php

namespace ArchNate\TriggrPHP\Collection;

use ArchNate\TriggrPHP\Tools\EventPhrase;
use ArchNate\TriggrPHP\Event;

class EventCollection implements \Countable
{
    public $events = array();

    /**
     * Returns the number of events registered
     * @return int
     */
    public function count() 
    {
        return count($this->events);
    }

    /**
     * Returns an event, if one does not exist, it creates it
     * @param  EventPhrase $eventPhrase The event name parsed by the EventPhrase tool
     * @return Event    The event that was retrieved or created
     */
    public function getEvent(EventPhrase $eventPhrase)
    {
        if(!array_key_exists($eventPhrase->getEventName(), $this->events)) {
            $this->addEvent(new Event($eventPhrase));
        }

        return $this->events[$eventPhrase->getEventName()];
    }

    /**
     * Removes an event from the list
     * @param  EventPhrase $eventPhrase The event phrase of the event to be removed from the collection
     * @return self                  
     */
    public function removeEvent(EventPhrase $eventPhrase)
    {
        if(array_key_exists($eventPhrase->getEventName(), $this->events)) {
            unset($this->events[$eventPhrase->getEventName()]);
        }

        return $this;
    }

    /**
     * Adds an Event, completely disregards if one is there already (so adding the same event name will wipe out any previous event)
     * @param Event $event The event to be added to the collection
     * @return self 
     */
    public function addEvent(Event $event)
    {
        $this->events[$event->getName()] = $event;

        return $this;
    }

}
