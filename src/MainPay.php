<?php

namespace MainPay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MainPay
{
    /**
     * Production API base url.
     */
    const PRODUCTION_BASE_URL = 'https://api.mainpay.id';

    /**
     * Sandbox API base url.
     */
    const SANDBOX_BASE_URL = 'https://api.sandbox.mainpay.id';

    /**
     * API base url.
     *
     * @var string
     */
    protected $base_url;

    /**
     * Guzzle client.
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Server key.
     *
     * @var string
     */
    protected $server_key;

    /**
     * Production status.
     *
     * @var boolean
     */
    protected $production;

    /**
     * Constructor.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $config = array_merge([
            'server_key' => 'mainpay_server_key',
            'production' => true,
        ], $config);

        $this->server_key = $config['server_key'];
        $this->production = $config['production'];
        $this->base_url = ($this->production) ? self::PRODUCTION_BASE_URL : self::SANDBOX_BASE_URL;
        $this->client = new Client(['base_uri' => $this->base_url]);
    }

    /**
     * Set API base url.
     *
     * @param string $base_url
     * @return void
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
        $this->client = new Client(['base_uri' => $this->base_url]);
    }

    /**
     * Get API base url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Set Guzzle client.
     *
     * @param string $client
     * @return GuzzleHttp\Client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * Get Guzzle client.
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set server key.
     *
     * @param string $server_key
     * @return void
     */
    public function setServerKey($server_key)
    {
        $this->server_key = $server_key;
    }

    /**
     * Get server key.
     *
     * @return string
     */
    public function getServerKey()
    {
        return $this->server_key;
    }

    /**
     * Set production status.
     *
     * @param string $production
     * @return boolean
     */
    public function setProduction($production)
    {
        $this->production = $production;
    }

    /**
     * Get production status.
     *
     * @return boolean
     */
    public function getProduction()
    {
        return $this->production;
    }

    /**
     * Send request to the API.
     *
     * @param string $method
     * @param string $path
     * @return mixed
     */
    public function request($method, $path, $version = 'v1')
    {
        $path = '/'.$version.$path;

        try {
            $response = $this->client->request($method, $path, ['auth' => [$this->server_key, '']]);
            return json_decode($response->getBody(), true);
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody(), true);
            }
        }
    }

    /**
     * Get transactions list.
     *
     * @return array
     */
    public function getTransactions()
    {
        return $this->request('GET', '/transactions');
    }
}
