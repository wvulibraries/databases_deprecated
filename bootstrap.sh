!/bin/bash

# Base PRE Setup

GITDIR="/tmp/git"
ENGINEAPIGIT="https://github.com/wvulibraries/engineAPI.git"
ENGINEBRANCH="master"
ENGINEAPIHOME="/home/engineAPI"

SERVERURL="/home/www.libraries.wvu.edu"
DOCUMENTROOT="public_html"
SITEROOT=$DOCUMENTROOT/databases
SQLFILES="/vagrant/sql/migrations/*.sql"

yum -y install \
	httpd httpd-devel httpd-manual httpd-tools \
	mysql-connector-java mysql-connector-odbc mysql-devel mysql-lib mysql-server \
	mod_auth_kerb mod_auth_mysql mod_authz_ldap mod_evasive mod_perl mod_security mod_ssl mod_wsgi \
	php php-bcmath php-cli php-common php-gd php-ldap php-mbstring php-mcrypt php-mysql php-odbc php-pdo php-pear php-pear-Benchmark php-pecl-apc php-pecl-imagick php-pecl-memcache php-soap php-xml php-xmlrpc \
	emacs emacs-common emacs-nox git

mv /etc/httpd/conf.d/mod_security.conf /etc/httpd/conf.d/mod_security.conf.bak
/etc/init.d/httpd start
chkconfig httpd on

mkdir -p $GITDIR
cd $GITDIR
git clone -b $ENGINEBRANCH $ENGINEAPIGIT
git clone https://github.com/wvulibraries/engineAPITemplates.git
git clone https://github.com/wvulibraries/engineAPI-Modules.git

mkdir -p $SERVERURL/phpincludes/
ln -s $GITDIR/engineAPITemplates/* $GITDIR/engineAPI/engine/template/
ln -s $GITDIR/engineAPI-Modules/src/modules/* $GITDIR/engineAPI/engine/engineAPI/latest/modules/
ln -s $GITDIR/engineAPI/engine/ $SERVERURL/phpincludes/

# Application Specific
mkdir -p $SERVERURL/$DOCUMENTROOT

ln -s /vagrant/serverConfiguration/docroot_index.php $SERVERURL/$DOCUMENTROOT/index.php
ln -s /vagrant/src $SERVERURL/$SITEROOT
ln -s $SERVERURL/phpincludes/engine/engineAPI/3.1 $SERVERURL/phpincludes/engine/engineAPI/3.2

rm -f /etc/hosts
ln -s /vagrant/serverConfiguration/hosts /etc/hosts

rm -f /etc/php.ini
ln -s /vagrant/serverConfiguration/php.ini /etc/php.ini

rm -f /etc/httpd/conf/httpd.conf
ln -s /vagrant/serverConfiguration/httpd.conf /etc/httpd/conf/httpd.conf
/etc/init.d/httpd restart

mkdir -p $SERVERURL/phpincludes/databaseConnectors/
ln -s /vagrant/serverConfiguration/database.lib.wvu.edu.remote.php $SERVERURL/phpincludes/databaseConnectors/database.lib.wvu.edu.remote.php

# Syndication templates
ln -s /vagrant/supportFiles/template/syndication/* $GITDIR/engineAPI/engine/template/syndication/

# Template
mkdir -p $GITDIR/engineAPITemplates/library2012.2col/templateIncludes
ln -s /vagrant/serverConfiguration/templateHeader.php $GITDIR/engineAPITemplates/library2012.2col/templateIncludes/templateHeader.php
ln -s /vagrant/serverConfiguration/templateFooter.php $GITDIR/engineAPITemplates/library2012.2col/templateIncludes/templateFooter.php
ln -s $GITDIR/engineAPITemplates/library2012.1col/templateIncludes/2colHeaderIncludes.php $GITDIR/engineAPITemplates/library2012.2col/templateIncludes/2colHeaderIncludes.php

mkdir -p $SERVERURL/$DOCUMENTROOT/javascript/distribution
ln -s $GITDIR/engineAPITemplates/distribution/public_html/js/* $SERVERURL/$DOCUMENTROOT/javascript/distribution/

# Base Post Setup
ln -s $SERVERURL $ENGINEAPIHOME
ln -s $GITDIR/engineAPI/public_html/engineIncludes/ $SERVERURL/$DOCUMENTROOT/engineIncludes

ln -s $GITDIR/engineAPITemplates/library2014-backpage/includes $SERVERURL/$DOCUMENTROOT/includes
ln -s $GITDIR/engineAPITemplates/library2014-backpage/templateIncludes $SERVERURL/$DOCUMENTROOT/templateIncludes

chmod a+rx /etc/httpd/logs -R
sudo ln -s /etc/httpd/logs/error_log /vagrant/serverConfiguration/serverlogs/error_log
sudo ln -s /etc/httpd/logs/access_log /vagrant/serverConfiguration/serverlogs/access_log

## Setup the EngineAPI Database

/etc/init.d/mysqld start
chkconfig mysqld on
mysql -u root < /tmp/git/engineAPI/sql/vagrantSetup.sql
mysql -u root EngineAPI < /tmp/git/engineAPI/sql/EngineAPI.sql

mysql -u root < /vagrant/sql/baseSnapshot.sql


for f in $SQLFILES
do
  echo "Processing $f ..."
  mysql -u root databases < "$f"
done