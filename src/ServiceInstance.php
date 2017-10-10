<?php
namespace mesosdns;

class ServiceInstance
{
    public $service;
    public $host;
    public $ip;
    public $port;

    public function getPort()
    {
        return $this->port;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getIp()
    {
        return $this->ip;
    }
}
