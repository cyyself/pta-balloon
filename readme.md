# pta-balloon

## 1. 简介

用于PTA的气球小工具，可用于CCPC线上比赛发气球使用。

还提供了查看自己队伍在正式队伍中排名的程序。

## 2. 环境准备

对于Debian/Ubuntu系统（Windows Subsystem for Linux也可以）：

```
apt install php-cli curl
```

## 3. 气球使用方法

1. 打开Chrome浏览器，使用教练号登录PTA，进入对应比赛查看排名。

2. 进入审查元素，然后切换到排名的第二页，再回到第一页，在对应的网络请求上`Copy as cURL`，然后放入`curl_cmd.txt`。

   ![1.png](readme/1.png)

   注：在Windows下此处有两个选项，若直接在Windows下使用php与curl，应使用(cmd)，如果整个运行环境在WSL或Linux中，应使用(bash)。

   作者在Windows上直接运行没有成功，建议使用Linux/macOS或在Windows下使用WSL/Linux虚拟机。

3. 修改`check.php`，`$team_key`修改为对应学校昵称。

4. 在当前文件夹执行`php check.php`，看输出即可。

   ![效果图](readme/2.png)

## 4. 查看正式排名

更新了查看正式排名功能，将正式队伍队名存储到`正式队伍.txt`中，一行一个，然后运行`php rank.php`即可。