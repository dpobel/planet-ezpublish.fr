#! /bin/sh
#


print_usage()
{
    echo "$1 -t tarball_name"
    echo "$1 creates a tarball for Planet eZ Publish."
    echo "It must be launched from the root of the repository"
    echo "Options:"
    echo "  -t tarball_name : create the tarball <tarball_name>.tar.gz"
    echo "  -h : display this help text"
}

TARBALL_NAME=""

while getopts "t:h" opt ; do
    case $opt in
        t ) TARBALL_NAME=$OPTARG ;;
        h ) print_usage "$0"
            exit 0 ;;
        * ) print_usage "$0"
            exit 1 ;;
    esac
done

[ -z "$TARBALL_NAME" ] && echo "Missing tarball_name parameter" && exit 4

TARBALL_NAME="${TARBALL_NAME}.tar.bz2"

if [ ! -d "planet" ] || [ ! -d "ezpublish5" ] ; then
    echo "$0 should be launched from the root of the git repository"
    exit 2
fi

[ -f $TARBALL_NAME ] && echo "$TARBALL_NAME already exists" && exit 3

echo -n "Generating $TARBALL_NAME"
cd planet
tar --exclude=.git --exclude=cache --exclude=web/design --exclude=web/var --exclude=web/share --exclude=web/extension -hcjf "../$TARBALL_NAME" .
cd ..
echo " done"
du -sh "$TARBALL_NAME"
