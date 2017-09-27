# o2o
实现团购网站后台逻辑

>开发环境搭建

1、下载wamp集成开发环境，完成以下方面的配置

- Apache中http.conf中的配置，包括ServerRoot Listen DocumentRoot 等基本参数设置

- 在httpd-vhosts.conf和C:\Windows\System32\drivers\etc中完成虚拟主机配置

- 在php.ini中配置extension=php_mysql.dll和extension=php_mysqli.dll，并且下载'PHP 5.2.3 zip package'压缩包文件，解压在extension_dir = 
"D:/WAMP/wamp/bin/php/php5.4.12/ext/"中

2、下载eclipse中php插件PHPeclipse，并且配置Apache、MySQL等路径

>使用插件

1、使用hui后端框架，搭建项目整体框架

2、使用百度开发者平台gencoder，获得商户总店和分店的经纬度

3、使用phpmailer邮件机制，为商户传递消息邮件

4、使用uploadify图片上传机制
