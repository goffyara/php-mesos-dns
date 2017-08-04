<?php
namespace mesosdns;

use mesosdns\Exception\NotFoundMethodException;
use mesosdns\Method\ApiMethod;
use mesosdns\Method\DnsMethod;

class MesosDns
{
    const METHOD_API = 'api';
    const METHOD_DNS = 'dns';

    /**
     * utr for ApiMethod
     * @var string
     */
    private $url;

    /**
     * @var string|MethodInterface
     */
    private $method;

    public function __construct($config = [])
    {
        if (empty($config['method'])) {
            //default value
            $config['method'] = 'api';
        }

        if ($config['method'] == 'api' && empty($config['url'])) {
            throw new \Exception("For 'api' method url required");
        }

        $this->url = $config['url'];
        $this->method = $config['method'];
    }

    /**
     *
     * @param  string $service service name
     * @param  string $group   group name
     * @return object Service
     */
    public function getService($service, $group = '')
    {
       $Service = $this->getMethod()->findService($service, $group);
       return $Service;
    }

    /**
     * get object's search method
     * @return MethodInterface
     */
    public function getMethod()
    {
        if (!is_object($this->method)) {
            $this->method = $this->createMethod($this->method);
        }

        return $this->method;
    }

    /**
     * @param string $method alias's method
     */
    public function setMethod($method)
    {
        $this->method = $this->createMethod($method);

        return $this;
    }

    /**
     * Create object by search method alias
     * @param  string $method
     * @throws NotFoundMethod
     * @return MethodInterface
     */
    private function createMethod($method)
    {
        if ($method === self::METHOD_API) {
            return new ApiMethod($this->url);
        }

        if ($method === self::METHOD_DNS) {
            return new DnsMethod;
        }

        throw new NotFoundMethodException('Method not found', $method);
    }


}