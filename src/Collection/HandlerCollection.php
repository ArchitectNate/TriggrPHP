<?php

namespace TPE\TriggrPHP\Collection;


class HandlerCollection implements Countable
{
    protected $_handlers;

    public function count() {
        return count($this->_handlers);
    }

}
