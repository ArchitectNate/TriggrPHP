<?php

namespace TPE\TriggrPHP\Options;

class HandlerOptions extends BaseOptions
{
    /**
     * @var integer The order in which it should be run
     */
    private $priority = 100;

    /**
     * @var integer How many times this handler is allowed to run (0 is infinite)
     */
    private $runLimit = 0;

    /**
     * @var boolean If true, once the handler completes, the rest of the handlers are halted
     */
    private $cancelEvent = false;

    ///////////////////////
    // GETTERS & SETTERS //
    ///////////////////////

    /**
     * Gets the value of priority.
     *
     * @return integer The order in which it should be run
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Sets the value of priority.
     *
     * @param integer The order in which it should be run $priority the priority
     *
     * @return self
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Gets the value of runLimit.
     *
     * @return integer How many times this handler is allowed to run (0 is infinite)
     */
    public function getRunLimit()
    {
        return $this->runLimit;
    }

    /**
     * Sets the value of runLimit.
     *
     * @param integer How many times this handler is allowed to run (0 is infinite) $runLimit the run limit
     *
     * @return self
     */
    public function setRunLimit($runLimit)
    {
        $this->runLimit = $runLimit;

        return $this;
    }

    /**
     * Gets the value of cancelEvent.
     *
     * @return boolean If true, once the handler completes, the rest of the handlers are halted
     */
    public function getCancelEvent()
    {
        return $this->cancelEvent;
    }

    /**
     * Sets the value of cancelEvent.
     *
     * @param boolean If true, once the handler completes, the rest of the handlers are halted $cancelEvent the cancel event
     *
     * @return self
     */
    public function setCancelEvent($cancelEvent)
    {
        $this->cancelEvent = $cancelEvent;

        return $this;
    }
}
