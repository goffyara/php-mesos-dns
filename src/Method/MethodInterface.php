<?php
namespace Mesosdns\Method;

interface MethodInterface
{
    public function findService($service, $group);
}