<?php
namespace mesosdns\Exception;

/**
 * Exception when method not founded
 */
class NotFoundMethodException extends \Exception
{

    private $method;

    public function __construct($message, $method, $code = 0, \Exception $previous = null)
    {
        $this->method = $method;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Not Found Service Exception';
    }

    /**
     * @return string readable representation of exception
     */
    public function __toString()
    {
        return parent::__toString() . PHP_EOL .
        'Search service method with alias -- ' . $this->method . ' not found!';
    }
}