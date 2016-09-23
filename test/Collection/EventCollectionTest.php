<?php
namespace ArchNate\TriggrPHP\Test\Collection;

use ArchNate\TriggrPHP\Collection\EventCollection;
use ArchNate\TriggrPHP\Tools\EventPhrase;
use ArchNate\TriggrPHP\Event;

/**
 * The EventCollection test class
 */
class EventCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testEventCollection()
    {
        $a = new EventCollection();

        $b = new EventPhrase("Event1");
        $c = new EventPhrase("Event2:test");
        $d = new EventPhrase("Event3");

        $e = $a->getEvent($b);

        $this->assertEquals(1, count($a));
        $this->assertEquals($b->getEventName(), $e->getName());

        $a->addEvent(new Event($c));
        $this->assertEquals(2, count($a));

        $a->addEvent(new Event($d));
        $this->assertEquals(3, count($a));

        // Doing this a second time to ensure it just gets overwritten and not added as a new one
        $a->addEvent(new Event($d));
        $this->assertEquals(3, count($a));

        $a->removeEvent($d);
        $this->assertEquals(2, count($a));

    }
}