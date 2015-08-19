<?php
namespace TPE\TriggrPHP\Test;

use TPE\TriggrPHP\Tools\EventPhrase;
use TPE\TriggrPHP\Handler;
use TPE\TriggrPHP\Options\HandlerOptions;

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
        $this->assertInstanceOf("TPE\TriggrPHP\Options\HandlerOptions", $b->getOptions());

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
        $this->assertInstanceOf("TPE\TriggrPHP\Options\HandlerOptions", $d->getOptions());
    }

    public function testHandlerFiring()
    {
        $a = new EventPhrase("EventName:HandlerName");
        $b = function(){ return true; };
        $c = new Handler($a, $b);

        $this->assertTrue($c->fire());
    }
}