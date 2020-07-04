<?php

namespace Wored\WangDianTongSdk;


use Hanson\Foundation\Foundation;

/***
 * Class WangDianTongSdk
 * @package \Wored\WangDianTongSdk
 *
 * @property \Wored\WangDianTongSdk\Api $api
 */
class WangDianTongSdk extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    public function __construct($config)
    {
        $config['debug'] = $config['debug'] ?? false;
        parent::__construct($config);
    }

    public function request(string $method,array $params=[])
    {
        return $this->api->request($method, $params);
    }
}