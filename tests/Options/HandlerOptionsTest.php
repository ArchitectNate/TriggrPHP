<?php
namespace TPE\TriggrPHP\Test\Options;

use TPE\TriggrPHP\Options\HandlerOptions;

/**
 * The TriggrOptions test class
 */
class HandlerOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testOptionDefaults()
    {
        $a = new HandlerOptions();
        $this->assertEquals(100, $a->getPriority());
        $this->assertEquals(0, $a->getRunLimit());
        $this->assertFalse($a->getCancelEvent());
    }

    public function testOptionSetting()
    {
        $a = new HandlerOptions(array("Priority"=>2));
        $this->assertEquals(2, $a->getPriority());

        $a = new HandlerOptions(array("Priority"=>99, "CancelEvent"=>true, "RunLimit"=>1, "BadOption"=>1));
        $this->assertEquals(99, $a->getPriority());
        $this->assertEquals(1, $a->getRunLimit());
        $this->assertTrue($a->getCancelEvent());
    }
}