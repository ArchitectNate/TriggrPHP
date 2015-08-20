<?php
namespace TPE\TriggrPHP\Collection;

use TPE\TriggrPHP\Handler;

class HandlerCollection implements \Countable
{
    /**
     * @var array The handles managed by the collection
     */
    protected $handlers = array();

    /**
     * @var array The sort order of handlers
     */
    protected $handlerSort = array();

    /**
     * @return int Returns the number of handlers currently collected
     */
    public function count()
    {
        return count($this->handlers);
    }

    /**
     * Adds a handler to the collection, any handler names that are identical are overwritten
     * @param Handler $handler The handler to be added to the collection
     * @return  self
     */
    public function addHandler(Handler $handler)
    {
        $this->handlers[$handler->getName()] = $handler;

        return $this;
    }

    /**
     * Removes a handler from the collection
     * @param  string $handlerName The text of the handler name
     * @return self
     */
    public function removeHandler($handlerName)
    {
        if(array_key_exists($handlerName, $this->handlers)) {
            unset($this->handlers[$handlerName]);
        }

        return $this;
    }

    /**
     * Sorts the handlers according to their priority option value
     * @return self
     */
    public function sortHandlers()
    {
        $this->handlerSort = array();
        foreach($this->handlers as $handler) {
            $handlerPriority = $handler->getOptions()->getPriority();
            $handlerName = $handler->getName();

            if(!isset($this->handlerSort[$handlerPriority])) {
                $this->handlerSort[$handlerPriority] = array();
            }

            $this->handlerSort[$handlerPriority][] = $handlerName;
        }

        ksort($this->handlerSort);

        return $this;
    }

    /**
     * Retrieves the sorted handler data
     * @return array The array of the handler sort data
     */
    public function getHandlerSort()
    {
        return $this->handlerSort;
    }

    /**
     * Retrieves the handler data
     * @return array The array of the handler data
     */
    public function getHandlers()
    {
        return $this->handlers;
    }
}