<?php
namespace mesosdns;

class Service
{
    protected $Instances = [];

    public function __construct(array $Instances)
    {
        $this->Instances = $Instances;
    }

    public function getInstance($n = 0)
    {
        if (!isset($this->Instances[$n])) {
            throw new \Exception("Instance with index $n not found");
        }
        return $this->Instances[$n];
    }

    public function getPort($n = 0)
    {
        return $this->getInstance($n)->getPort();
    }

    public function getHost($n = 0)
    {
        return $this->getInstance($n)->getHost();
    }

    public function getIp($n = 0)
    {
        return $this->getInstance($n)->getIp();
    }
}
