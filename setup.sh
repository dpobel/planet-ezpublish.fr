#! /bin/bash
#
#

CONFIG="requirements"
CONFIG_SEPARATOR='$'

OLD_IFS=$IFS
IFS=$'\n'


for DEPENDENCY in `cat "$CONFIG" | egrep -v '^#'` ; do
    NAME=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 1`
    GIT=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 2`
    BRANCH=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 3`
    LOCAL_PATH=`echo $DEPENDENCY|cut -d "$CONFIG_SEPARATOR" -f 4`
    echo "# $NAME"
    if [ -d "$LOCAL_PATH" ] ; then
        echo "  o $LOCAL_PATH exists, trying to update with git"
        cd "$LOCAL_PATH"
        git checkout "$BRANCH"
        git pull
        cd -
    else
        echo "  o $LOCAL_PATH does not exists, getting from git"
        git clone "$GIT" "$LOCAL_PATH"
        cd "$LOCAL_PATH"
        git checkout "$BRANCH"
        cd -
    fi

done



IFS=$OLD_IFS
