<?php
namespace TPE\TriggrPHP\Test\Tools;

use TPE\TriggrPHP\Tools\EventPhraseParser;

class EventPhraseParserTest extends \PHPUnit_Framework_TestCase
{
    public function testHasValidPhrase()
    {
        // Subarray structure as follows: 
        // 0=>EventPhrase, 
        // 1=>eventNameOnly Default validation, 
        // 2=>eventNameOnly true validation
        $eventPhraseTestStrings = array(
            array("EventName", true, true),
            array("EventName23", true, true),
            array("EventName*", false, false),
            array("EventName:", false, false),
            array("Event(Name#", false, false),
            array("EventName:HandlerName", true, false),
            array("EventN@me:HandlerName", false, false),
            array("EventName:H@ndlerName", false, false),
            array("3ventN@me:H@ndlerN&me", false, false),
            array("Ev3ntName:Handl3rN8me", true, false),
            array("EventName:HandlerName:OtherName", false, false)
        );

        foreach($eventPhraseTestStrings as $eventPhraseData) {
            list($eventPhrase, $eventNameOnlyFalse, $eventNameOnlyTrue) = $eventPhraseData;

            $a = new EventPhraseParser($eventPhrase); // With default behavior
            $b = new EventPhraseParser($eventPhrase, true); // With event name only filtering

            $this->assertEquals($eventNameOnlyFalse, (bool)$a->hasValidPhrase(), "Testing {$eventPhrase} without flag which should be " . ($eventNameOnlyFalse ? "true" : "false"));
            $this->assertEquals($eventNameOnlyTrue, (bool)$b->hasValidPhrase(), "Testing {$eventPhrase} with flag which should be " . ($eventNameOnlyTrue ? "true" : "false"));
        }

    }
}
