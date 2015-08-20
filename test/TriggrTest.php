<?php
namespace TPE\TriggrPHP\Test;

use TPE\TriggrPHP\Triggr;
use TPE\TriggrPHP\Options\HandlerOptions;

/**
 * The Triggr test class
 */
class TriggrTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Triggr::watch("Event1:Handler1", function($arg1){ return $arg1; });
        Triggr::watch("Counter", function($count){ return ++$count; }, array("Priority"=>10));
        Triggr::watch("Counter2:Test", function($count){ return ++$count; });
        Triggr::watch("Counter:Test", function($count){ return $count*5; });
    }

    public function testTriggr()
    {
        $output = Triggr::fire("Event1", array("test"));
        $this->assertEquals("test", $output['Handler1']);

        Triggr::setHandlerOptions("Counter:Test", array("Priority"=>1));

        $output = Triggr::fire("Counter", array(1));
        $this->assertEquals(5, array_shift($output));
        $this->assertEquals(2, array_shift($output));

        $output = Triggr::fireHandler("Counter2:Test", array(1));
        $this->assertEquals(2, $output);

        Triggr::removeEventHandler("Counter:Test");
        $output = Triggr::fire("Counter", array(3));
        $this->assertEquals(1, count($output));
        $this->assertEquals(4, array_shift($output));

        Triggr::removeEvent("Counter2");

        $output = Triggr::fireHandler("Counter2:Test", array(1));
        $this->assertNull($output);
    }
}