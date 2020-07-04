<?php

namespace Wored\WangDianTongSdk;

use Hanson\Foundation\AbstractAPI;
use Hanson\Foundation\Log;

class Api extends AbstractAPI
{
    public $config;
    public $timestamp;

    /**
     * Api constructor.
     * @param $appkey
     * @param $appsecret
     * @param $sid
     * @param $baseUrl
     */
    public function __construct(WangDianTongSdk $wangDianTongSdk)
    {
        $this->config = $wangDianTongSdk->getConfig();
    }

    /**
     * api请求方法
     * @param $method域名后链接
     * @param $params请求参数
     * @return mixed
     * @throws \Exception
     */
    public function request(string $method, array $params = [])
    {
        $request = [
            'sid'       => $this->config['sid'],
            'appkey'    => $this->config['appkey'],
            'timestamp' => time(),
        ];
        if (!empty($params)) {
            foreach ($params as $key => $vo) {
                if (is_array($vo)) {
                    $params[$key] = json_encode($vo, JSON_UNESCAPED_UNICODE);
                }
            }
        }
        $request = array_merge($request, $params);
        $request['sign'] = $this->sign($request);
        $url = $this->config['rootUrl'] . '/openapi2/' . $method . '.php';
        $http = $this->getHttp();
        $response = call_user_func_array([$http, 'POST'], [$url, $request]);
        return json_decode(strval($response->getBody()), true);
    }


    /**
     * 生成签名
     * @param array $params请求的所有参数
     * @return string
     */
    public function sign(array $params)
    {
        unset($params['sign']);
        ksort($params);
        $arr = [];
        foreach ($params as $key => $val) {
            if ($key == 'sign') {
                continue;
            }
            if (count($arr)) {
                $arr[] = ';';
            }
            $arr[] = sprintf("%02d", iconv_strlen($key, 'UTF-8'));//键key的长度用2位数字表示
            $arr[] = '-';
            $arr[] = $key;
            $arr[] = ':';

            $arr[] = sprintf("%04d", iconv_strlen($val, 'UTF-8'));//值value的长度用4位数字表示
            $arr[] = '-';
            $arr[] = $val;
        }
        $sign = md5(implode('', $arr) . $this->config['appsecret']);
        return $sign;
    }
}