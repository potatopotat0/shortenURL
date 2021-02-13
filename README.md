## shortenURL

PHP驱动的短网址API。

## 简介

因为众所周知的我太菜的原因，这个的代码实现十分粗暴，还写的特别丑。

## 安装

在数据库中建立 `links` table，包含 `shortLink`, `longLink` 和 `time` 三个 column。

`./api/index.php` 中填入数据库名、用户名、密码。

`./js/script.js` 中替换 Google reCAPTCHA 用户端密钥。

`./api/web/index.php` 中填入数据库名、用户名、密码，替换 Google reCAPTCHA 服务端密钥。

## 错误码

`-1` ：没有传入网址。

`114`：生成成功。

`514`：不支持生成此域名的短链接。

`404`：进行缩短的网页不存在，或无法连接。

`501`：数据库连接错误。

`502`：Google reCAPTCHA 验证错误，错误码见 [Google reCAPTCHA 文档](https://developers.google.cn/recaptcha/docs/verify?hl=zh-cn#error_code_reference)。

## License

© [potatopotat0](https://github.com/potatopotat0), Released under the [MIT](https://github.com/potatopotat0/shortenURL/blob/main/LICENSE) License.