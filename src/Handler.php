<?php
namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Options\HandlerOptions;

/**
 * An individual event handler
 */
class Handler
{
    /**
     * @var string The handler name parsed from an event phrase
     */
    private $name;

    /**
     * @var callable The function to be called
     */
    private $func;

    /**
     * @var HandlerOptions The options that detail the handler's behavior
     */
    private $options;

    /**
     * Stores handler data for use later on
     * @param string              $name    The handler name parsed from an event phrase
     * @param callable            $func    The function to be called
     * @param HandlerOptions|null $options The options that detail the handler's behavior
     */
    public function __construct($name, callable $func, HandlerOptions $options = null)
    {
        $this->name = $name;
        $this->func = $func;
        $this->options = $options;
    }

    /**
     * Gets the value of name.
     *
     * @return string The handler name parsed from an event phrase
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the value of func.
     *
     * @return callable The function to be called
     */
    public function getFunc()
    {
        return $this->func;
    }

    /**
     * Gets the value of options.
     *
     * @return HandlerOptions The options that detail the handler's behavior
     */
    public function getOptions()
    {
        return $this->options;
    }
}