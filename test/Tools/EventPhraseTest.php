<?php
namespace TPE\TriggrPHP\Test\Tools;

use TPE\TriggrPHP\Tools\EventPhrase;

class EventPhraseTest extends \PHPUnit_Framework_TestCase
{
    public function testHasValidPhrasePass()
    {
        // Subarray structure as follows: 
        // 0=>EventPhrase, 
        // 1=>eventNameOnly Default validation, 
        // 2=>eventNameOnly true validation
        $eventPhraseTestStrings = array(
            array("EventName", true, true),
            array("EventName23", true, true),
            array("EventName:HandlerName", true, null),
            array("Ev3ntName:Handl3rN8me", true, false)
        );

        foreach($eventPhraseTestStrings as $eventPhraseData) {
            list($eventPhrase, $eventNameOnlyFalse, $eventNameOnlyTrue) = $eventPhraseData;

            // Gotta catch any errors so it doesn't actually stop the test 
            // since technically the has ValidPhrase function is run inside 
            // of the constructor
            try {
                $a = new EventPhrase($eventPhrase); // With default behavior
            } catch(\Exception $e) { }

            try {
                $b = new EventPhrase($eventPhrase, true); // With event name only filtering
            } catch(\Exception $e) { }

            ($eventNameOnlyFalse != null ? $this->assertEquals($eventNameOnlyFalse, $a->hasValidPhrase(), "Testing {$eventPhrase} without flag which should be " . ($eventNameOnlyFalse ? "true" : "false")) : null);
            ($eventNameOnlyTrue != null ? $this->assertEquals($eventNameOnlyTrue, $b->hasValidPhrase(), "Testing {$eventPhrase} with flag which should be " . ($eventNameOnlyTrue ? "true" : "false")) : null);
        }

    }

    public function testHasvalidPhraseFail()
    {
        // Subarray structure as follows: 
        // 0=>EventPhrase, 
        // 1=>eventNameOnly Default validation, 
        // 2=>eventNameOnly true validation
        $eventPhraseTestStrings = array(
            "EventName*",
            "EventName:",
            "Event(Name#",
            "EventName:HandlerName", // This one passes the default, but not hte "event only" test
            "EventN@me:HandlerName", 
            "EventName:H@ndlerName",
            "EventName:HandlerName:OtherName"
        );

        // Minus 1 for the "EventName:HandlerName" that passes when eventPhraseOnly is false
        $totalTests = count($eventPhraseTestStrings) * 2 - 1;
        $testCount = 0;

        foreach($eventPhraseTestStrings as $eventPhrase) {

            try {
                $a = new EventPhrase($eventPhrase); // With default behavior
            } catch(\Exception $e) { 
                $this->assertInstanceOf("TPE\TriggrPHP\Exception\InvalidEventPhraseException", $e);
                $this->assertEquals("Invalid Event Phrase", $e->getMessage());
                $testCount++;
            }

            try {
                $b = new EventPhrase($eventPhrase, true); // With event name only filtering
            } catch(\Exception $e) {
                $this->assertInstanceOf("TPE\TriggrPHP\Exception\InvalidEventPhraseException", $e);
                $this->assertEquals("Invalid Event Phrase", $e->getMessage());
                $testCount++;
            }
        }

        $this->assertEquals($totalTests, $testCount, "If this fails one of the test Strings is passing where it shouldn't");
    }

    public function testParse()
    {
        $a = new EventPhrase("EventName");
        $this->assertEquals("EventName", $a->getEventName());
        $this->assertNull($a->getHandlerName());

        $a = new EventPhrase("EventName:HandlerName");
        $this->assertEquals("EventName", $a->getEventName());
        $this->assertEquals("HandlerName", $a->getHandlerName());

        $a = new EventPhrase("EventName", true);
        $this->assertEquals("EventName", $a->getEventName());
        $this->assertNull($a->getHandlerName());

    }
}