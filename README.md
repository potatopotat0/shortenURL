## shortenURL

PHP驱动的短网址API。

## Description

因为众所周知的我太菜的原因，这个的代码实现十分粗暴，还写的特别丑。

如要自行部署web生成器请在 `./js/script.js` 中替换自己的客户端密钥，并在 `./api/web/index.php` 替换服务端密钥。

## 错误码

`-1`：没有传入网址

`114`：生成成功

`514`：不支持生成此域名的短链接

`404`：进行缩短的网页不存在

`502`：Google reCaptcha 验证错误，错误码见[Google reCaptcha文档](https://developers.google.cn/recaptcha/docs/verify?hl=zh-cn#error_code_reference)

## License

© [potatopotat0](https://github.com/potatopotat0), Released under the [MIT](https://github.com/potatopotat0/shortenURL/blob/main/LICENSE) License.