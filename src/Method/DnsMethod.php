<?php
namespace mesosdns\Method;

use mesosdns\Service;
use mesosdns\ServiceInstance;
use mesosdns\Exception\NotFoundServiceException;

class DnsMethod implements MethodInterface
{
    public function findService($service, $port, $group = '')
    {
        $uri = "services/";
        $uri .= "_$port.";
        $uri .= "_$service.";

        if (!empty($group)) {
            $uri .= "$group.";
        }

        $uri .= "_tcp.marathon.mesos";
        $response = dns_get_record($hostname, DNS_SRV);
        $Instances = $this->prepareInstances($response);

        if (empty($Instances)) {
            throw new NotFoundServiceException("Service not found", $service, $group, $port, get_class($this));
        }

        $Service = new Service($Instances);
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

            $Instance = new ServiceInstance;
            $Instance->service = $instance['host'];
            $Instance->host = $instance['host'];
            $Instance->ip = $instance['target'];
            $Instance->port = $instance['port'];

            array_push($Instances, $Instance);
        }

        return $Instances;
    }
}