<?php

namespace TPE\TriggrPHP\Collection;


class HandlerCollection implements \Countable
{
    protected $handlers;

    public function count()
    {
        return count($this->handlers);
    }

}
