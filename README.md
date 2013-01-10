使用wget命令保存网页的小工具, 代码写得很烂, 建议不要在线上环境使用

# 安装 

1. 把common.php, save.php, index.php文件复制到网站根目录
2. 利用urls.sql初始化数据库
3. 修改common.php里的数据库配置
4. 访问index.php, 输入以http开头的网址并提交, 请耐心等待wget抓取网页, 必要时延长webserver的请求时长限制
5. 访问index.php 时会自动生成静态首页index.html, 利用qrsync就可以上传剪辑好的网页到云储存(参考配置文件webclip.task), 访问 http://yourdomain.qiniudn.com/index.html 即可. qrsync具体用法参考[此链接 ](http://docs.qiniutek.com/v3/tools/qrsync/) 

# 配置
- 需要在php.ini 中设置safe_mode = Off, 并在disable_functions配置项去除system函数
- 可以在common.php里修改wget命令配置，例如timeout， exclude_domain等参数。 exclude_domain可以用于忽略某些朝鲜访问不了的域名例如facebook.com, twitter.com
- 要使用代理可以在common.php中的config设置

# 支持windows

在windows下使用需要下载[wget for Windows](http://gnuwin32.sourceforge.net/packages/wget.htm) 建议放到一个不包含空格的目录下，例如D:\bin\wget.exe，并修改save.php 中$cmd变量中的wget的调用路径, 例如

```php
$cmd = sprintf('d:\\bin\\wget.exe %s --exclude-domains %s -t 2 --timeout=%d --user-agent="%s" -E -H -k -K -p -P %s %s',$proxy, implode(',', 		$config['exclude_domain']), $config['timeout'], $agent, dirname(__FILE__), $origin_url );
```
