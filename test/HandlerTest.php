<?php
namespace ArchNate\TriggrPHP\Test;

use ArchNate\TriggrPHP\Tools\EventPhrase;
use ArchNate\TriggrPHP\Handler;
use ArchNate\TriggrPHP\Options\HandlerOptions;

/**
 * The Handler test class
 */
class HandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiation()
    {
        // Null HandlerOptions
        $a = new EventPhrase("EventName:EventHandler");
        $b = new Handler($a, function() {
            return true;
        });

        $this->assertEquals("EventHandler", $b->getName());
        $this->assertInternalType("callable", $b->getFunc());
        $this->assertInstanceOf("ArchNate\TriggrPHP\Options\HandlerOptions", $b->getOptions());

        // Test function
        $this->assertTrue(call_user_func($b->getFunc()));

        // No handler name given
        $a = new EventPhrase("EventName");
        $b = new Handler($a, function() {
            return true;
        });

        $this->assertContains("Handler_", $b->getName());

        // Non Null HandlerOptions
        $a = new EventPhrase("EventName2:SomeOtherEventHandler");
        $b = new HandlerOptions();
        $c = function() { return true; };

        $d = new Handler($a, $c, $b);

        $this->assertEquals("SomeOtherEventHandler", $d->getName());
        $this->assertInternalType("callable", $d->getFunc());
        $this->assertInstanceOf("ArchNate\TriggrPHP\Options\HandlerOptions", $d->getOptions());
    }

    public function testHandlerFiring()
    {
        $a = new EventPhrase("EventName:HandlerName");
        $b = function(){ return true; };
        $c = new Handler($a, $b);

        $this->assertTrue($c->fire());
    }

    public function testRunLimit()
    {
        $a = new EventPhrase("EventName:HandlerName");
        $b = function(){ return true; };
        $c = new Handler($a, $b, new HandlerOptions(array("RunLimit" => 2)));

        $c->fire(); $c->fire(); // Fire once to use up it's two run

        $this->assertNull($c->fire());

        $this->assertEquals(2, $c->getTotalRuns());
    }
}