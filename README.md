# Anleitung zur Installation von Moodle mit Nginx, PostgreSQL und Absicherung mit LetsEncrypt

Die Installaiton erfolgt mit einem sudo user:
`sudo su`

## Installation von fail2ban damit der Server nicht dauernd Script Kiddy Attacken abbekommt

`apt install fail2ban -y`
`systemctl restart fail2ban`

## Installlation ein Moodle System mit Nginx, PHP und PostgreSQL auf der VM

### Installation von Nginx

apt update && apt upgrade
apt install nginx
systemctl start nginx.service
systemctl enable nginx.service

### Installation von PostgreSQL und Erstellen der Datenbank und des DB-Users

apt install postgresql postgresql-contrib
systemctl status postgresql
systemctl stop postgresql
systemctl start postgresql
systemctl status postgresql

sudo -u postgres psql postgres
postgres=# CREATE USER moodleuser WITH PASSWORD 'xxx!';
CREATE DATABASE moodle WITH OWNER moodleuser;


### Installation von PHP mit Erweiterungen und Konfiguration

apt-get install php-fpm php-common php-pgsql php-gmp php-curl php-intl php-mbstring php-soap php-xmlrpc php-gd php-xml php-cli php-zip unzip git curl -y

apt install nano -y

nano /etc/php/7.4/fpm/php.ini
systemctl restart php7.4-fpm

### Installation von Moodle

cd /var/www/html
git clone -b MOODLE_400_STABLE git://git.moodle.org/moodle.git moodle
nano /etc/nginx/conf.d/moodle.conf

server {

    listen 80;
    root /var/www/html/moodle;
    index  index.php index.html index.htm;
    server_name  lena.kunde-ssystems.de;

    include snippets/well-known.conf;

    client_max_body_size 100M;
    autoindex off;
    location / {
        try_files $uri $uri/ =404;
    }

    location /dataroot/ {
      internal;
      alias /var/www/html/moodledata/;
    }

    location ~ [^/].php(/|$) {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}

mkdir -p /var/www/html/moodledata
chown -R www-data:www-data /var/www/html/moodle
chmod -R 755 /var/www/html/#
chown www-data:www-data /var/www/html/moodledata

systemctl restart nginx   

Die Installation kann etweder vom Terminal oder vom Browser aus erfolgen.

Installation vom Terminal: 
php moodle/admin/cli/install.php 

Installation vom Browser:
http://lena.kunde-ssystems.de


## Absichern den Zugriff mittels HTTPs und let's Encrypt SSL Zertifikat ab

apt install certbot
openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048
apt-get install python3-certbot-nginx -y
certbot --nginx -d  lena.kunde-ssystems.de
systemctl restart nginx
nano /var/www/html/moodle/config.php

$CFG->wwwroot   = 'https://lena.kunde-ssystems.de';

## Erstellen des Google Key

https://developers.google.com/custom-search/v1/overview

## Installation des Moodle Blocks mit Google-Suche:

cd /var/www/html/moodle/blocks
unzip suche.zip
chown -R www-data:www-data suche/

## Test der Anwendung
https://lena.kunde-ssystems.de/
