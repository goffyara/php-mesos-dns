<?php
namespace mesosdns\Method;

use mesosdns\Service;
use mesosdns\ServiceInstance;
use mesosdns\Exception\NotFoundServiceException;

class DnsMethod implements MethodInterface
{

    public function findService($service, $group = '')
    {
        $hostname = "_$service.";
        if (!empty($group)) {
            $hostname .= "$group.";
        }

        $hostname .= "_tcp.marathon.mesos";

        $response = dns_get_record($hostname, DNS_SRV);

        $Instances = $this->prepareInstances($response);
        if (empty($Instances)) {
             throw new NotFoundServiceException("Service not found", $service, $group, get_class($this));
        }

        $Service = new Service($Instances, $service, $group);
        return $Service;
    }

    protected function prepareInstances(array $arrayInstances)
    {
        $Instances = [];
        foreach ($arrayInstances as $instance) {

            $target = $instance['target'];
            if (empty($target)) {
                continue;
            }
            if (!array_key_exists($target, $Instances)) {
                $Instance = new ServiceInstance;
                $Instance->service = $instance['host'];
                $Instance->host = $instance['host'];
                $Instance->ip = $instance['target'];
                $Instance->ports = [ (int) $instance['port']];
                $Instances[$target] = $Instance;
            } else {
                $Instance = $Instances[$target];
                $Instance->addPort($instance['port']);
            }
        }

        return $Instances;
    }
}