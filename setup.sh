#! /bin/bash
#
#

BASE_DIR=`pwd`
CONFIG="requirements"
CONFIG_SEPARATOR='$'

COMPOSER="composer.phar"
COMPOSER_JSON="composer.json"
COMPOSER_INSTALL="https://getcomposer.org/installer"

EZPUBLISH5=ezpublish5
EZPUBLISH_LEGACY=legacy/ezpublish
EZPUBLISH_LEGACY_EXTENSION_DIR=$EZPUBLISH_LEGACY/extension
EZPUBLISH_LEGACY_EXTENSIONS=../../extensions
EZPUBLISH_LEGACY_SETTING_DIR=$EZPUBLISH_LEGACY/settings
EZPUBLISH_LEGACY_SETTINGS=../../settings

PLANET_BASE=planet

OLD_IFS=$IFS
IFS=$'\n'

while getopts "t" opt ; do
    case $opt in
        t ) CONFIG="$CONFIG.tests" ;;
        * ) exit 1 ;;
    esac
done

for DEPENDENCY in `cat "$CONFIG" | egrep -v '^#'` ; do
    NAME=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 1`
    GIT=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 2`
    BRANCH=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 3`
    LOCAL_PATH=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 4`
    echo "# $NAME"
    if [ -d "$LOCAL_PATH" ] ; then
        echo "  o $LOCAL_PATH exists, trying to update with git"
        cd "$LOCAL_PATH"
        echo "  o using branch $BRANCH"
        git checkout "$BRANCH" 2> /dev/null
        echo "  o updating..."
        git pull > /dev/null
        cd "$BASE_DIR"
    else
        echo "  o $LOCAL_PATH does not exists, getting from git"
        git clone "$GIT" "$LOCAL_PATH" > /dev/null
        cd "$LOCAL_PATH"
        echo "  o using branch $BRANCH"
        git checkout "$BRANCH" 2> /dev/null
        cd "$BASE_DIR"
    fi

done

cd "$EZPUBLISH5"
echo "eZ Publish5 post install (composer...)"
if [ -f "$COMPOSER" ] ; then
    php $COMPOSER self-update
else
    curl -s $COMPOSER_INSTALL | php
fi

php $COMPOSER install
cd "$BASE_DIR"

if [ -d "$EZPUBLISH_LEGACY" ] ; then
    echo "eZ Publish legacy settings, extensions and autoload"
    cd "$EZPUBLISH_LEGACY_EXTENSION_DIR"
    find "$EZPUBLISH_LEGACY_EXTENSIONS" -maxdepth 1 -mindepth 1 -exec ln -s {} \; 2> /dev/null
    cd "$BASE_DIR"

    cd "$EZPUBLISH_LEGACY_SETTING_DIR"
    rm -rf "siteaccess" "override"
    ln -s "$EZPUBLISH_LEGACY_SETTINGS/siteaccess"
    ln -s "$EZPUBLISH_LEGACY_SETTINGS/override"
    cd "$BASE_DIR"

    cd "$EZPUBLISH_LEGACY"
    php bin/php/ezpgenerateautoloads.php -e
    cd "$BASE_DIR"
fi

cd "$PLANET_BASE"
[ ! -L "$COMPOSER" ] && ln -s ../$EZPUBLISH5/$COMPOSER
[ ! -L "$COMPOSER_JSON" ] && ln -s ../$EZPUBLISH5/$COMPOSER_JSON
php "$COMPOSER" dump-autoload
cd "$BASE_DIR"

echo "Vidage de cache"
rm -rf $PLANET_BASE/ezpublish/cache/*

if [ -d "$EZPUBLISH_LEGACY" ] ; then
    rm -rf $PLANET_BASE/ezpublish_legacy/var/cache/* $PLANET_BASE/ezpublish_legacy/var/planete/cache/*
fi

IFS=$OLD_IFS
