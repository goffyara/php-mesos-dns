<?php
namespace mesosdns;

class ServiceInstance
{
    public $service;
    public $host;
    public $ip;
    public $ports = [];

    public function addPort(int $port)
    {
        if(empty($port)) {
            throw new \Exception("port can not be empty");
        }
        array_push($this->ports, $port);
        sort($this->ports);
    }

    public function getPort($n = 0)
    {
        return $this->ports[$n];
    }

    public function getIp()
    {
        return $this->ip;
    }
}
