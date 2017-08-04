<?php

namespace mesosdns\tests;

use PHPUnit\Framework\TestCase;
use mesosdns\MesosDns;
use mesosdns\Service;
use mesosdns\Method\ApiMethod;
use mesosdns\Method\DnsMethod;
use mesosdns\Exception\NotFoundMethodException;

class MesosDnsTest extends TestCase {

    public $fixtureUrl;

    protected function setUp()
    {
        $this->fixtureUrl = 'http://test.test:8123/v1/';
    }

    public function testConstuctor() {
        $classname = 'mesosdns\MesosDns';

        $fixtures = [
            'url' => $this->fixtureUrl,
            'method' => 'api'
        ];

        $MesosDns = new MesosDns($fixtures);
        $this->assertAttributeEquals($fixtures['url'], 'url', $MesosDns);
        $this->assertAttributeEquals($fixtures['method'], 'method', $MesosDns);
    }

    /**
      * @expectedException     Exception
      */
    public function testConstuctorWithApiMethodAndEmptyUrl() {
        $classname = 'mesosdns\MesosDns';

        $fixtures = [
            'method' => 'api'
        ];

        $MesosDns = new MesosDns($fixtures);
        $this->expectException();
    }

    public function testGetApiMethod() {

        $fixtures = [
            'url' => $this->fixtureUrl,
            'method' => 'api'
        ];

        $MesosDns = new MesosDns($fixtures);
        $this->assertTrue($MesosDns->getMethod() instanceof ApiMethod);
    }

    public function testGetDnsMethod() {

        $fixtures = [
            'url' => $this->fixtureUrl,
            'method' => 'dns'
        ];

        $MesosDns = new MesosDns($fixtures);
        $this->assertTrue($MesosDns->getMethod() instanceof DnsMethod);
    }

    /**
      * @expectedException     mesosdns\Exception\NotFoundMethodException
      */
    public function testGetUnknownMethod() {

        $fixtures = [
            'url' => $this->fixtureUrl,
            'method' => 'unknownMethod'
        ];

        $MesosDns = new MesosDns($fixtures);
        $MesosDns->getMethod();
        $this->expectException(NotFoundMethodException::class);
    }

    public function testSetApiMethod() {

        $fixtures = [
            'url' => $this->fixtureUrl,
        ];

        $MesosDns = new MesosDns($fixtures);
        $MesosDns->setMethod('api');
        $this->assertTrue($MesosDns->getMethod() instanceof ApiMethod);
    }

    public function testSetDnsMethod() {

        $fixtures = [
            'url' => $this->fixtureUrl,
            'method' => 'api'
        ];

        $MesosDns = new MesosDns($fixtures);
        $MesosDns->setMethod('dns');
        $this->assertTrue($MesosDns->getMethod() instanceof DnsMethod);
    }

    public function testGetService() {

        $ServiceMock = $this->getMockBuilder(Service::class)
            ->disableOriginalConstructor()
            ->getMock();

        $MethodStub = $this->getMockBuilder(ApiMethod::class)
            ->disableOriginalConstructor()
            ->setMethods(['findService'])
            ->getMock();

        $MethodStub->method('findService')->willReturn($ServiceMock);
        $MethodStub->expects($this->once())->method('findService');

        $MesosMock = $this->getMockBuilder(MesosDns::class)
            ->disableOriginalConstructor()
            ->setMethods(['getMethod'])
            ->getMock();

        $MesosMock->expects($this->once())->method('getMethod')->willReturn($MethodStub);

        $reflectedClass = new \ReflectionClass(MesosDns::class);
        $constructor = $reflectedClass->getMethod('getService');
        $constructor->invoke($MesosMock, ['test', 'test']);

    }
}
