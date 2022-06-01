# PHP\_Robot文档📋

* * *

它是一个基于`CQhttp`的QQ机器人框架，全部由PHP编写。

采用`SG11`加密核心文件，对CQ码提供了全部支持！

您可以使用它快速部署一个QQ机器人~

> 在阅读本文档前，你可以使用`Ctrl+F`直接搜索需要的内容
> 
> 此外您还可以加入此项目🐧群：[783742193](https://jq.qq.com/?_wv=1027&k=FzMG6qF5 "https://jq.qq.com/?_wv=1027&k=FzMG6qF5")

## 环境配置💻

* * *

*   PHP7.0 安装 SG11扩展
*   放行分发器和主控的端口
*   配置伪静态
*   配置主控器的`Config.yml`与分发器的`Config.json`

### **伪静态**

* * *

```
location ~ \.(json)$ {
    deny all;
}
location / {
  try_files $uri $uri/ $uri.php?$args;
}
```

> 其他的不在这里过多展示，详见视频教程（[PHP\_Robot部署教程——视频篇-Project-老嘤的秘密基地 (loyin.top)](http://blog.loyin.top/thread-255.htm)）

## 故障排除❓

* * *

如果您服务器无法部署此项目？

1.  在go-cqhttp根目录下找到runoob.log，检查程序运行日志。
2.  检查端口放行情况（阿里腾讯等需要编辑安全组，不能在宝塔直接更改）

如果还是无法部署，请加入🐧群进行询问！
