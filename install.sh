#!/bin/bash

# Stop on the first sign of trouble
set -e

if [ $UID != 0 ]; then
    echo "ERROR: Operation not permitted. Forgot sudo?"
    exit 1
fi

# create random password
MAINDB="dispenser_parking"
USERDB="suroot"
PASSWDDB="suroot123"
WWW_DIR="/var/www"
HTML_DIR="/var/www/html"
HTML_STORAGE_DIR="${HTML_DIR}/storage"
HTML_CACHE_DIR="${HTML_DIR}/bootstrap/cache"
NGINX_DEFAULT_LOCAL_PATH="./sites-enabled/default"
SSID="parking_client_ssid"
SSIDPASS="@bxp2023"


echo "Updating installer files..."

apt update
apt upgrade

# echo "Start Installing Hotspot"
# nmcli device wifi hotspot ssid "${SSID}" password "${SSIDPASS}" ifname wlan0

# apt-get install hostapd dnsmasq -y
# systemctl stop hostapd
# systemctl stop dnsmasq

# mv /etc/dnsmasq.conf /etc/dnsmasq.conf.orig
echo "Update LAtesT PHP"
sudo wget -qO /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt update -y

echo "Installing PHP dependencies..."
apt install php8.2-fpm php8.2-mbstring php8.2-mysql php8.2-curl php8.2-gd php8.2-curl php8.2-zip php8.2-xml -y
echo "Installing NGINX ..."
apt install nginx -y

echo "Start Installing Database ..."
apt install mariadb-server -y
echo "The system will run in 5 seconds..."
sleep 5
echo "Finish Installing Database ..."
echo "Start Installing Composer ..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
sleep 2
echo "Finish Installing Composer ..."

echo "Start Enable App ..."
rm -rf /var/www/html/*
mv -f ./app/* /var/www/html/
echo "Finish Enable App ..."

echo "Give Permission ..."
chmod -R 777 "$WWW_DIR"
chown -R www-data:www-data "$HTML_STORAGE_DIR"
chown -R www-data:www-data "$HTML_CACHE_DIR"
mv "$NGINX_DEFAULT_LOCAL_PATH" /etc/nginx/sites-available/default
nginx -t
echo "Start Reload NGINX services..."
systemctl reload nginx
echo "Finish Reload NGINX services..."
sleep 10

echo "Start Installing NODEJS dependencies..."
wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.2/install.sh | bash
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
echo "The system NODEJS will run in 5 seconds..."
sleep 2
nvm install 18.19.0
sleep 2
node -v
echo "Finish Installing NODEJS dependencies..."
sleep 10

echo "Start Installing NODE Manager dependencies..."
npm install pm2 -g
echo "Finish Installing NODE Manager dependencies..."
sleep 5

echo "Please enter root user MySQL password!"
echo "Note: password will be hidden when typing"
# read -sp rootpasswd
mysql -uroot  -e "DROP DATABASE IF EXISTS ${MAINDB};"
# mysql -uroot  -e "REVOKE ALL PRIVILEGES, GRANT OPTION FROM '${USERDB}'@'%';"
mysql -uroot  -e "DROP USER IF EXISTS '${USERDB}'@'%';"
mysql -uroot  -e "FLUSH PRIVILEGES;"
mysql -uroot  -e "CREATE DATABASE ${MAINDB} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
mysql -uroot  -e "CREATE USER '${USERDB}'@'%' IDENTIFIED BY '${PASSWDDB}';"
mysql -uroot  -e "GRANT ALL PRIVILEGES ON *.* TO '${USERDB}'@'%';"
mysql -uroot  -e "FLUSH PRIVILEGES;"
mysql -uroot "$MAINDB" < ./store/store.sql

echo "Reload NGINX ...."
systemctl reload nginx
sleep 5
echo "Start Move www conf..."
mv ./www.conf /etc/php/8.2/fpm/pool.d/www.conf
echo "Finish Move www conf..."
service php8.2-fpm restart
rm -rf ./*
sleep 5
echo "Open Browser http://localhost ..."
echo "Please reboot the system..."

