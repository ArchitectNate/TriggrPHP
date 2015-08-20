<?php
namespace TPE\TriggrPHP\Test;

use TPE\TriggrPHP\Event;
use TPE\TriggrPHP\Tools\EventPhrase;

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
    }
}