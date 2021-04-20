## shortenURL

PHP驱动的短网址API。

## 简介

因为众所周知的我太菜的原因，这个的代码实现十分粗暴，还写的特别丑。

Google reCAPTCHA 目前是形式主义验证，~~大家就当没看见API~~。

## Before Installation

Please create your own `config.php` with following:

```php
<?php
$SERVER = "localhost";
$DATABASE = "<DATABASE>";
$USERNAME = "<USERNAME>";
$PASSWORD = "<PASSWORD>";
$GOOGLEKEY = "<GOOGLE RECAPTCHA KEY | LEAVE BLANK IF NOT USING WEB GENERATOR>";
```

## 错误码

`-1` ：短链接随机路径生成失败。

`114`：生成成功。

`514`：不支持生成此域名的短链接。

`401`：没有传入网址。

`404`：进行缩短的网页不存在，或无法连接。

`501`：数据库连接错误。

`502`：Google reCAPTCHA 验证错误，错误码见 [Google reCAPTCHA 文档](https://developers.google.cn/recaptcha/docs/verify?hl=zh-cn#error_code_reference)。

## License

© [potatopotat0](https://github.com/potatopotat0), Released under the [MIT](https://github.com/potatopotat0/shortenURL/blob/main/LICENSE) License.