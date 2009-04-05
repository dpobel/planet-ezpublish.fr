#! /bin/bash
# Rapatrie la dernière version de la base et des données du dossier var en local
#

# Configuration locale
TMP=/tmp/locale_sync
APACHE_USER=www-data
APACHE_GROUP=www-data
WEBDIR=~/public_html/planete/
VARDIR=~/public_html/planete/var/

# Configuration distante
PROD=tigrou@pwet.fr
PROD_WEBDIR=~/web/planet-ezpublish.fr/www/
PROD_VARDIR=${PROD_WEBDIR}var/
IMAGE_INI="web/planet-ezpublish.fr/www/settings/override/image.ini.append.php web/planet-ezpublish.fr/www/settings/image.ini"

# Dernier dump
DAY_NUMBER=`date '+%j'`
MYSQL_DUMP=${DAY_NUMBER}.ezplanete.sql.bz2
MYSQL_DUMP_PATH=/tmp/backup_site/$MYSQL_DUMP

BASE=0
VAR=0

print_usage()
{
	echo "Usage : $0 [-u|-v]"
	echo "  -v importe le dossier var"
	echo "  -b importe de la base"
}

while getopts "bv" opt ; do
    case $opt in
        b ) BASE=1 ;;
        v ) VAR=1 ;;
        * ) print_usage "$0"
            exit 2 ;;
    esac
done

if [ $BASE -eq 1 ] ; then
    echo "Import ezplanete database"
    [ ! -d "$TMP" ] && mkdir $TMP
    echo "  transfert"
    scp $PROD:$MYSQL_DUMP_PATH $TMP > /dev/null
    echo "  drop existing base"
    echo 'DROP DATABASE ezplanete' | mysql -u root
    echo "  create base"
    echo 'CREATE DATABASE ezplanete CHARACTER SET utf8' | mysql -u root
    bzip2 -cd $TMP/$MYSQL_DUMP | mysql -u root ezplanete
    rm -rf $TMP
fi

if [ $VAR -eq 1 ] ; then
    echo "Backup var directory"
    echo "  building exclude list"
    ALIAS_LIST=`ssh $PROD "cat $IMAGE_INI | grep '^AliasList\[\]=' | sed 's/AliasList\[\]=//g'"`
    EXCLUDE_LIST="--exclude=cache --exclude=log"
    for alias in $ALIAS_LIST ; do
        EXCLUDE_LIST="$EXCLUDE_LIST --exclude=*_${alias}.*"
    done

    echo "  rsync..."
    rsync -a $EXCLUDE_LIST $PROD:$PROD_VARDIR $VARDIR
    chown -R $APACHE_USER:$APACHE_GROUP $VARDIR
fi
