<?php
namespace TPE\TriggrPHP\Test\Collection;

use TPE\TriggrPHP\Collection\HandlerCollection;
use TPE\TriggrPHP\Options\HandlerOptions;
use TPE\TriggrPHP\Tools\EventPhrase;
use TPE\TriggrPHP\Handler;

/**
 * The HandlerCollection test class
 */
class HandlerCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testHandlerCollection()
    {
        // Setup the handlers
        $ep1 = new EventPhrase("Event1:Handler1");
        $ep2 = new EventPhrase("Event1:Handler2");
        $ep3 = new EventPhrase("Event1:Handler3");
        $ep4 = new EventPhrase("Event1:Handler4");

        $func1 = function() { return "test"; };
        $func2 = function() { return true; };
        $func3 = function() { return false; };

        $opt1 = new HandlerOptions(array("Priority"=>145));
        $opt2 = new HandlerOptions(array("Priority"=>34));

        $h1 = new Handler($ep1, $func1, $opt1);
        $h2 = new Handler($ep2, $func2, $opt2);
        $h3 = new Handler($ep3, $func3);
        $h4 = new Handler($ep4, $func3);

        // Test the Collection
        $hc = new HandlerCollection();

        $hc->addHandler($h1);
        $this->assertEquals(1, count($hc));

        $hc->addHandler($h2);
        $this->assertEquals(2, count($hc));

        $hc->sortHandlers();

        $handlerSort = $hc->getHandlerSort();

        $testItem = current($handlerSort);
        $this->assertEquals("34", key($handlerSort));
        $this->assertEquals("Handler2", $handlerSort[34][0]);

        $testItem = next($handlerSort);

        $this->assertEquals("145", key($handlerSort));
        $this->assertEquals("Handler1", $handlerSort[145][0]);

        // Add one more
        $hc->addHandler($h3);
        $hc->addHandler($h4);
        $hc->sortHandlers();
        $handlerSort = $hc->getHandlerSort();

        $testItem = current($handlerSort);
        $this->assertEquals("34", key($handlerSort));
        $this->assertEquals("Handler2", $handlerSort[34][0]);

        $testItem = next($handlerSort);

        $this->assertEquals("100", key($handlerSort));
        $this->assertEquals("Handler3", $handlerSort[100][0]);
        $this->assertEquals("Handler4", $handlerSort[100][1]);

        $testItem = next($handlerSort);

        $this->assertEquals("145", key($handlerSort));
        $this->assertEquals("Handler1", $handlerSort[145][0]);

        // Test actually firing each handler
        $handlerSort = $hc->getHandlerSort();
        $handlers = $hc->getHandlers();
        $preSortedAssertion = array("", true, false, false, "test");

        foreach($handlerSort as $handlerPriority) {
            foreach($handlerPriority as $handlerName) {
                $this->assertEquals(next($preSortedAssertion), $handlers[$handlerName]->fire());
            }
        }






    }
}