# Handprint-front-end
交叉编译php 
php版本选择最新版，这里是5.5.5 配置php，记得enable json
$ CC=arm-linux-gcc ./configure --host=arm-linux --without-pear \
--disable-simplexml --disable-mbregex --enable-sockets --enable-pdo  \
--disable-fpm --enable-static --disable-shared  --without-sqlite3 \
--without-pdo-sqlite --without-mysql --disable-cli --enable-json \
--disable-all  
make 后将php-cgi拷贝到开发板的/usr/bin/下面。 
*注：为了方便测试，同时编译一个x86版本的php，配置如下：
* $ CC=gcc ./configure --without-pear --disable-simplexml --disable-mbregex \
--enable-sockets --enable-pdo  --disable-fpm --enable-static --disable-shared  \
--without-sqlite3 --without-pdo-sqlite --without-mysql --disable-cli \
--enable-json --disable-all 
