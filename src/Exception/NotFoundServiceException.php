<?php
namespace mesosdns\Exception;

/**
 * Exception when service not founded
 */
class NotFoundServiceException extends \Exception
{

    private $method;
    private $service;
    private $group;
    private $port;

    public function __construct($message, $service, $group, $port, $method, $code = 0, \Exception $previous = null)
    {
        $this->method = $method;
        $this->service = $service;
        $this->group = $group;
        $this->port = $port;

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
        $this->method . ' -- Service: ' . $this->service . '( port: '. $this->port .') with group: ' . $this->group . '  not found!';
    }
}
