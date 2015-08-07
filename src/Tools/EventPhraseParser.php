<?php

namespace TPE\TriggrPHP\Tools;

class EventPhraseParser
{
    /**
     * @var string Regex pattern used to validate and parse the event phrase
     */
    const EVENT_PHRASE_PATTERN = "/^([a-zA-Z0-9]+)([:]([a-zA-Z0-9]+))?$/";

    /**
     * @var string The original event phrase provided. Can only consist of alpha-numeric characters and ":"
     */
    private $eventPhrase;

    /**
     *  @var bool A qualifier that enables names to be validated to only have EVENTNAME
     */
    private $eventNameOnly;

    /**
     * @var string Contains the event name parsed from the formats EVENTNAME or EVENTNAME:HANDLERNAME
     */
    private $eventName;

    /**
     * @var string Contains the handler name parsed from the format EVENTNAME:HANDLERNAME
     */
    private $handlerName;
    
    /**
     * Parses an string containing the format EVENTNAME or EVENTNAME:HANDLERNAME into two separate properties
     * 
     * @param string $eventPhrase 
     * @param boolean $eventNameOnly
     * @return self
     */
    public function __construct($eventPhrase, $eventNameOnly = false)
    {
        $this->eventPhrase = $eventPhrase;
        $this->eventNameOnly = $eventNameOnly;

        return $this;
    }

    /**
     * Parses the event phrase into it's individual parts
     * 
     * @return self
     */
    public function parse()
    {
        $eventPhraseData = array();

        if($this->hasValidPhrase()) {
            // Parse the data, EventName will be index 1, HandlerName will be index 3 (if it exists)
            preg_match(self::EVENT_PHRASE_PATTERN, $this->eventPhrase, $eventPhraseData);

            if(array_key_exists(1, $eventPhraseData)) {
                $this->eventName = $eventPhraseData[1];
            }

            if(array_key_exists(3, $eventPhraseData)) {
                $this->handlerName = $eventPhraseData[3];
            }

        } else {
            throw new \Exception("Invalid Event Phrase");
        }

        return $this;
    }

    /**
     * Determines if the event phrase follows the proper formatting. A properly formatted event phrase consists of only alpha-numeric characters and ":"
     * 
     * @return boolean True if it passes and false if it does not.
     */
    public function hasValidPhrase()
    {
        return (bool)preg_match(self::EVENT_PHRASE_PATTERN, $this->eventPhrase) &&
            // If eventNameOnly is set, then check for a ":", if one exists,
            // Then we should return false because evente names alone do not
            // have a ":", if eventNameOnly is set to true, then always return
            // true, because essentially, we don't care what happens here
            ($this->eventNameOnly ? !strpos($this->eventPhrase, ":") : true);
    }

    /**
     * Gets the value of handlerName.
     *
     * @return string Contains the handler name parsed from the format EVENTNAME:HANDLERNAME
     */
    public function getHandlerName()
    {
        return $this->handlerName;
    }

    /**
     * Gets the value of eventPhrase.
     *
     * @return string The original event phrase provided. Can only consist of alpha-numeric characters and ":"
     */
    public function getEventPhrase()
    {
        return $this->eventPhrase;
    }

    /**
     * Gets the value of eventNameOnly.
     *
     * @return bool A qualifier that enables names to be validated to only have EVENTNAME
     */
    public function getEventNameOnly()
    {
        return $this->eventNameOnly;
    }

    /**
     * Gets the value of eventName.
     *
     * @return string Contains the event name parsed from the formats EVENTNAME or EVENTNAME:HANDLERNAME
     */
    public function getEventName()
    {
        return $this->eventName;
    }
}