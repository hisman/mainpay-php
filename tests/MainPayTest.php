<?php

namespace MainPay\Tests;

use PHPUnit\Framework\TestCase;
use MainPay\MainPay;

class MainPayTest extends TestCase
{
    const PRODUCTION_BASE_URL = 'http://api.mainpay.test';
    const SANDBOX_BASE_URL = 'http://api.sandbox.mainpay.test';

    protected $mainpay;
    protected $mainpay_sandbox;
    protected $server_key = 'test-server-key';

    protected function setUp()
    {
        parent::setUp();

        $this->mainpay = new MainPay([
            'server_key' => $this->server_key,
            'production' => true,
        ]);
        $this->mainpay->setBaseUrl(self::PRODUCTION_BASE_URL);

        $this->mainpay_sandbox = new MainPay([
            'server_key' => $this->server_key,
            'production' => false,
        ]);
        $this->mainpay_sandbox->setBaseUrl(self::SANDBOX_BASE_URL);
    }

    public function testCreateMainPayInstance()
    {
        $mainpay = new MainPay([
            'server_key' => $this->server_key,
            'production' => true,
        ]);

        $this->assertTrue($mainpay->getProduction());
        $this->assertSame($this->server_key, $mainpay->getServerKey());
        $this->assertSame('https://api.mainpay.id', $mainpay->getBaseUrl());
    }

    public function testCreateMainPayInstanceInSandbox()
    {
        $mainpay = new MainPay([
            'server_key' => $this->server_key,
            'production' => false,
        ]);

        $this->assertFalse($mainpay->getProduction());
        $this->assertSame($this->server_key, $mainpay->getServerKey());
        $this->assertSame('https://api.sandbox.mainpay.id', $mainpay->getBaseUrl());
    }
}
