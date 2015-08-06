<?php

namespace TPE\TriggrPHP\Tools;

class EventPhraseParser
{
    /**
     * Regex pattern used to validate and parse the event phrase
     * @var string
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
     * @param string $eventPhrase 
     * @param boolean $eventNameOnly
     * @return self
     */
    public function __construct($eventPhrase, $eventNameOnly = false)
    {
        $this->eventPhrase = $eventPhrase;
        $this->eventNameOnly = $eventNameOnly;
    }

    /**
     * Parses the event phrase into it's individual parts
     * @return array|null Returns null by default, returns an array with both the eventName and handlerName if $return is set to true
     */
    public function parse($return = false)
    {
        if($this->hasValidPhrase()) {
            // Set both the event name and the handler name simultaneously
            // [Code Here]

            if($return) {
                return array($this->eventName, $this->handlerName);
            }
        } else {
            throw new \Exception("Invalid Event Phrase");
        }
    }

    /**
     * Determines if the event phrase follows the proper formatting. A properly formatted event phrase consists of only alpha-numeric characters and ":"
     * @return boolean True if it passes and false if it does not.
     */
    public function hasValidPhrase()
    {
        return (bool)preg_match(self::EVENT_PHRASE_PATTERN, $this->eventPhrase) && ($this->eventNameOnly ? !strpos($this->eventPhrase, ":") : true);
    }
}