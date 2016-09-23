<?php
namespace ArchNate\TriggrPHP\Exception;

/**
 * A basic Exception extensions for handling invalid event phrases
 * 
 * @todo Create detection for why the phrase is invalid (symbols, eventOnly, etc)
 */
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
}