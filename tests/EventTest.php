<?php
namespace TPE\TriggrPHP\Test;

use TPE\TriggrPHP\Event;
use TPE\TriggrPHP\Tools\EventPhrase;
use TPE\TriggrPHP\Options\HandlerOptions;
use TPE\TriggrPHP\Handler;

/**
 * The Event test class
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    // Adding and removing handlers
    // This ends up testing the Handler Collection as well
    public function testEvent()
    {
        $a = new EventPhrase("Event1:Handler1");
        $b = new Event($a);

        $this->assertEquals($a->getEventName(), $b->getName());
        $this->assertInstanceOf("TPE\TriggrPHP\Collection\HandlerCollection", $b->getHandlerCollection());

        // Similar to Handler Collection Test
        
        $ep1 = new EventPhrase("Event1:Handler1");
        $ep2 = new EventPhrase("Event1:Handler2");
        $ep3 = new EventPhrase("Event1:Handler3");
        $ep4 = new EventPhrase("Event1:Handler4");

        $func1 = function() { return "test"; };
        $func2 = function($arg) { return $arg; };
        $func3 = function() { return false; };

        $opt1 = new HandlerOptions(array("Priority"=>145));
        $opt2 = new HandlerOptions(array("Priority"=>34));

        $h1 = new Handler($ep1, $func1, $opt1);
        $h2 = new Handler($ep2, $func2, $opt2);
        $h3 = new Handler($ep3, $func3);
        $h4 = new Handler($ep4, $func3);

        // Add handlers to the event
        $b->addHandler($h1);
        $b->addHandler($h2);
        $b->addHandler($h3);
        $b->addHandler($h4);

        $b->removeHandler("Handler4");

        $return = $b->fire(array(true));

        $this->assertEquals(
            array(
                "Handler2"=>true, 
                "Handler3"=>false, 
                "Handler1"=>"test"
            ), 
            $return
        );
    }
}