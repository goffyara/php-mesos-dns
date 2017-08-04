<?php
namespace mesosdns\Method;

use GuzzleHttp\Client;
use mesosdns\Service;
use mesosdns\ServiceInstance;
use mesosdns\Exception\NotFoundServiceException;

class ApiMethod implements MethodInterface
{
    private $client;

    public function __construct($url)
    {
        $this->client = new Client([
            'base_uri' => $url
        ]);
    }

    public function findService($service, $group = '')
    {
        $uri = "services/_";
        $uri .= "$service.";

        if (!empty($group)) {
            $uri .= "$group.";
        }

        $uri .= "_tcp.marathon.mesos";

        $body = $this->getResponseAsArray($uri);
        $Instances = $this->prepareInstances($body);

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

            $host = $instance['host'];
            if (empty($host)) {
                continue;
            }
            if (!array_key_exists($host, $Instances)) {
                $Instance = new ServiceInstance;
                $Instance->service = $instance['service'];
                $Instance->host = $instance['host'];
                $Instance->ip = $instance['ip'];
                $Instance->ports = [ (int) $instance['port']];
                $Instances[$host] = $Instance;
            } else {
                $Instance = $Instances[$host];
                $Instance->addPort($instance['port']);
            }
        }

        return $Instances;
    }

    protected function getResponseAsArray($uri)
    {
        $response = $this->client->get($uri);

        $body = $response->getBody();
        $body = json_decode((string) $body, true);
        return $body;
    }
}