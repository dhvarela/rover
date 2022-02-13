FROM debian:stretch

ENV TERM xterm

RUN apt-get update &&\
	apt-get install -y wget apt-transport-https ca-certificates &&\
	wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg &&\
	sh -c 'echo "deb https://packages.sury.org/php/ stretch main" > /etc/apt/sources.list.d/php.list' &&\
	cd /root/ &&\
	apt-get update &&\
	apt-get -y install mysql-client nginx php-geoip libgeoip-dev nano git zip p7zip-full pkg-config libtool autoconf make g++ supervisor procps composer &&\
	apt-get -y install php-xml php7.2-fpm php7.2-cli php7.2-curl php7.2-mysql php7.2-json php7.2-mbstring php7.2-xml php7.2-soap php7.2-zip php7.2-dev php7.2-intl php7.2-gmp php-xdebug php-pear libmcrypt-dev libreadline-dev php7.2-gd

RUN	pecl install geoip-1.1.1

#Composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php -r "if (hash_file('SHA384', 'composer-setup.php') === 'SIGNATURE') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

#Adding composer user
RUN useradd -ms /bin/bash composer

#Redis
RUN update-alternatives --set php /usr/bin/php7.2 &&\
	pecl config-set php_ini /etc/php/7.2/cli/php.ini &&\
	pecl config-set ext_dir /usr/lib/php/20170718/ &&\
	pecl config-set bin_dir /usr/bin/ &&\
	pecl config-set php_bin /usr/bin/php7.2 &&\
	pecl config-set php_suffix 7.2 &&\
	pecl -d php_suffix=7.2 install redis-4.3.0

RUN echo "extension=redis.so" > /etc/php/7.2/mods-available/redis.ini &&\
	ln -sf /etc/php/7.2/mods-available/redis.ini /etc/php/7.2/fpm/conf.d/20-redis.ini &&\
	ln -sf /etc/php/7.2/mods-available/redis.ini /etc/php/7.2/cli/conf.d/20-redis.ini

RUN printf "\n" | pecl install mcrypt-1.0.1

#Yarn install
RUN apt-get install -y curl software-properties-common &&\
	curl -sL https://deb.nodesource.com/setup_10.x | bash - &&\
	apt-get install -y nodejs &&\
	npm install -g yarn

# Nginx setup
COPY config/etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY config/etc/nginx/fastcgi_params /etc/nginx/fastcgi_params

# PHP setup
COPY config/etc/php/7.2/cli/php.ini /etc/php/7.2/cli/php.ini
COPY config/etc/php/7.2/fpm/php.ini /etc/php/7.2/fpm/php.ini

# Supervisor config file
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Link xdebug config
RUN touch /etc/php/7.2/mods-available/xdebug.ini
RUN ln -sf /etc/php/7.2/mods-available/xdebug.ini /etc/php/7.2/cli/conf.d/20-xdebug.ini

RUN /etc/init.d/php7.2-fpm stop && /etc/init.d/php7.2-fpm start && service nginx restart

EXPOSE 80
EXPOSE 443

CMD supervisord -c /etc/supervisor/conf.d/supervisord.conf