<?php
namespace TPE\TriggrPHP\Test;

use TPE\TriggrPHP\Tools\EventPhraseParser;
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
        $a = (new EventPhraseParser("EventName:EventHandler"))->parse();
        $b = new Handler($a->getHandlerName(), function()
        {
            return true;
        });

        $this->assertEquals("EventHandler", $b->getName());
        $this->assertInternalType("callable", $b->getFunc());
        $this->assertNull($b->getOptions());


        // Non Null HandlerOptions
        $a = (new EventPhraseParser("EventName2:SomeOtherEventHandler"))->parse();
        $b = new HandlerOptions();
        $c = new Handler($a->getHandlerName(), function()
        {
            return true;
        }, $c);

        $this->assertEquals("SomeOtherEventHandler", $c->getName());
        $this->assertInternalType("callable", $c->getFunc());
        $this->assertNotInternalType("HandlerOptions", $c->getOptions());

    }

}