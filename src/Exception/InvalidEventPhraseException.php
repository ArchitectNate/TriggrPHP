<?php
namespace TPE\TriggrPHP\Exception;

class InvalidEventPhraseException extends \Exception
{
    /**
     * This exception is to be thrown when an event phrase is invalid
     * @param string         $message  Exception message (same as Exception but defaulted to "Invalid Event Phrase")
     * @param integer        $code     Exception code (same as Exception)
     * @param Exception|null $previous Previous exception (same as Exception)
     */
    public function __construct($message = "Invalid Event Phrase", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Converts the Exception to a readable string
     * @return string A formated string of "{class_name}: [{exception_code}]: {exception_message}""
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}