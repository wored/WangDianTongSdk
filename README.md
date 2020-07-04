<h1 align="center">旺店通接口SDK</h1>

## 安装

```shell
$ composer require wored/wangdiantong-sdk -vvv
```

## 使用
```php
<?php
use \Wored\WangDianTongSdk\WangDianTongSdk;

$config = [
    "log"       => [
        "file"       => "../storage/logs/Wangdiantong.log",
        "name"       => "Wangdiantong",
        "level"      => "debug",
        "permission" => 777
    ],
    "sid"       => "******",
    "debug"     => false,
    "appkey"    => "***************",
    "rootUrl"   => "https://sandbox.wangdian.cn",
    "appsecret" => "************"
];
//旺店通SDK
$wdt = new WangDianTongSdk($config);
//获取店铺
$ret = $wdt->request('shop');
```
## License

MIT