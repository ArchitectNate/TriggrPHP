<?php
namespace TPE\TriggrPHP\Collection;

use TPE\TriggrPHP\Handler;

class HandlerCollection implements \Countable
{
    protected $handlers = array();
    protected $handlerSort = array();

    public function count()
    {
        return count($this->handlers);
    }

    public function addHandler(Handler $handler)
    {
        $this->handlers[$handler->getName()] = $handler;

        return $this;
    }

    public function removeHandler($handlerName)
    {
        if(array_key_exists($handlerName, $this->handlers)) {
            unset($this->handlers[$handlerName]);
        }

        return $this;
    }

    public function sortHandlers()
    {
        foreach($this->handlers as $handler) {
            $handlerPriority = $handler->getOptions()->getPriority();
            $handlerName = $handler->getName();

            if(!is_array($this->handlerSort[$handlerPriority])) {
                $this->handlerSort[$handlerPriority] = array();
            }

            $this->handlerSort[$handlerPriority][] = $handlerName;
        }

        ksort($this->handlerSort);

        return $this;
    }

    public function getHandlerSort()
    {
        return $this->handlerSort;
    }
}