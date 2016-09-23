<?php
namespace ArchNate\TriggrPHP\Options;

/**
 * The base options class
 */
abstract class BaseOptions
{
    /**
     * Parses the options array and sets any valid options
     * @param  array  $options Options provided upon initialisation
     * @return self
     */
    public function __construct(array $options = array())
    {
        if(count($options) > 0) {
            foreach($options as $optionName=>$val) {
                $methodName = "set" . $optionName;
                if(method_exists($this, $methodName)) {
                    $this->$methodName($val);
                }
            }
        }

        return $this;
    }
}