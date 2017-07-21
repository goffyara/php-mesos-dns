<?php
namespace mesosdns;

class Service
{
    public $Instances = [];
    public $service;
    public $group;

    public function __construct(array $Instances, $service, $group = '')
    {
        $this->service = $service;
        $this->group = $group;
        $this->Instances = $Instances;
    }

    public function getInstance($n = null)
    {
        if(!is_null($n)) {
            $Instances = sort($this->Instances);
            if (!isset($this->Instances[$n])) {
                throw new \Exception("Instance with index $n not found");
            }
            return $this->Instances[$n];
        }

        return current($this->Instances);
    }

    public function getPort($n = 0)
    {
        $Instance = $this->getInstance();
        $port = $Instance->getPort($n);
        return $port;
    }

    public function getHost()
    {
        $Instance = $this->getInstance();
        $host = $Instance->host;
        return $host;
    }

    public function getIp()
    {
        $Instance = $this->getInstance();
        $ip = $Instance->ip;
        return $ip;
    }
}
