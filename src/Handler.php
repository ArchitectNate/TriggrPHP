<?php
namespace TPE\TriggrPHP;

use TPE\TriggrPHP\Options\HandlerOptions;
use TPE\TriggrPHP\Tools\EventPhrase;

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
     * @var integer The number of times this handler has been fired
     */
    private $totalRuns;

    /**
     * Stores handler data for use later on
     * @param EventPhrase              $phrase  An Event Phrase Object
     * @param callable            $func    The function to be called
     * @param HandlerOptions|null $options The options that detail the handler's behavior
     */
    public function __construct(EventPhrase $phrase, callable $func, HandlerOptions $options = null)
    {
        $this->name = ($phrase->getHandlerName() != null ? $phrase->getHandlerName() : $this->generateRandomName());
        $this->func = $func;
        $this->options = $options ? $options : new HandlerOptions();
    }

    /**
     * Fires the handler function
     * @param  array  $args The array of arguments for the handler function
     * @return mixed|null Null if the function shouldn't fire
     */
    public function fire(array $args = array())
    {
        $this->totalRuns++;

        if($this->hasMetRunLimit())
        {
            return null;
        }

        return call_user_func_array($this->func, $args);
    }

    private function hasMetRunLimit()
    {
        return ($this->options->getRunLimit() == 0 ? false : $this->totalRuns >= $this->options->getRunLimit());
    }

    private function generateRandomName()
    {
        // Ensure uniqueness
        list($usec, $sec) = explode(' ', microtime());
        $seed = (float) $sec + ((float) $usec * 100000);
        mt_srand($seed);
        return "Handler_" . hash("sha256", mt_rand());
    }

    ////////////////////////
    // GETTERS & SETTERS  //
    ////////////////////////
    
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

    /**
     * Sets the value of options.
     * @param   HandlerOptions $HandlerOptions The new options to set
     * @return  self
     */
    public function setOptions(HandlerOptions $handlerOptions)
    {
        $this->options = $handlerOptions;
        return $this;
    }

    /**
     * Gets the value of totalRuns.
     *
     * @return integer The number of times this handler has been fired
     */
    public function getTotalRuns()
    {
        return $this->totalRuns;
    }
}