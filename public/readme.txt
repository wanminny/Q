可以按照以下步骤来部署和运行程序:
1.请确保机器已经安装了Yaf框架, 并且已经加载入PHP;
2.把websites目录Copy到Webserver的DocumentRoot目录下;
3.需要在php.ini里面启用如下配置，生产的代码才能正确运行：
	yaf.environ="localing"
4.重启Webserver;
5.访问http://yourhost/websites/,出现Hellow Word!, 表示运行成功,否则请查看php错误日志;





1.设置目录 框架目录以及公用M(COMMON)
2.设置
[yaf]
extension="/usr/local/opt/php56-yaf/yaf.so"
yaf.use_namespace= 0
yaf.environ= localing
yaf.library="/Data/bak/QF2.0/Framework"
yaf.path="/Data/bak/QF2.0/Framework:/Data/bak/bright.knight"；；；不是必须的；以在入口有设置了SET_INCLUDE_PATH();

;yaf.library= /www/uic-hitao/uic/Framework

3.设置XHRPOF
4.配置主站  http://qin.com/?_qdebug=xhprof （可以生成XHPROF日志）生成日志后可以根据链接访问！
5.MVC 跑通；

6.ab压测；


