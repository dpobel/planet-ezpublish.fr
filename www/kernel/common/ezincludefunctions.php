<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

/**
 * kernel files include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function kernel_include( $name )
{
    $include = "kernel/$name";
    return include_once( $include );
}

/**
 * kernel/common files include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function kernel_common( $name )
{
    $name = strtolower( $name );
    $include = "kernel/common/$name.php";
    return include_once( $include );
}

/**
 * datatype include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function datatype_class( $datatype, $className )
{
    $className = strtolower( $className );
    $include = "kernel/classes/datatypes/$datatype/$className.php";
    return include_once( $include );
}

/**
 * Loose extension path function for include use originally from ezextension.php
 *
 * @deprecated Since 4.3
 */
function extension_path( $extension, $withWWWDir = false, $withHost = false, $withProtocol = false )
{
    $base = eZExtension::baseDirectory();
    $path = '';
    if ( $withProtocol )
    {
        if ( is_string( $withProtocol ) )
            $path .= $withProtocol;
        else
        {
            $path .= eZSys::serverProtocol();
        }
        $path .= ':';
    }
    if ( $withHost )
    {
        $path .= '//';
        if ( is_string( $withHost ) )
            $path .= $withHost;
        else
            $path .= eZSys::hostname();
    }
    if ( $withWWWDir )
        $path .= eZSys::wwwDir();

    if ( $withWWWDir )
        $path .= '/' . $base . '/' . $extension;
    else
        $path .= $base . '/' . $extension;
    return $path;
}

/**
 * eZExtension::nameFromPath( __FILE__ ) executed in any file of an extension
 * can help you to find the path to additional resources
 *
 * @param $path Path to check.
 * @return Name of the extension a path belongs to.
 * @deprecated Since 4.3, use {@link eZExtension::nameFromPath()} instead
 */
function nameFromPath( $path )
{
    $path = eZDir::cleanPath( $path );
    $base = eZExtension::baseDirectory() . '/';
    $base = preg_quote( $base, '/' );
    $pattern = '/'.$base.'([^\/]+)/';
    if ( preg_match( $pattern, $path, $matches ) )
        return $matches[1];
    else
        false;
}

/**
 * @param string $path Path to check.
 * @return bool True if this path is related to some extension.
 * \note The root of an extension is considered to be in this path too.
 * @deprecated Since 4.3, use {@link eZExtension::isExtension()} instead
 */
function isExtension( $path )
{
    if ( eZExtension::nameFromPath( $path ) )
        return true;
    else
        return false;
}

/**
 * Includes the file named \a $name in extension \a $extension
 * note This works similar to include() meaning that it always includes the file.
 * @deprecated Since 4.3
 */
function ext_include( $extension, $name )
{
    $base = eZExtension::baseDirectory();
    $include = "$base/$extension/$name";
    return include( $include );
}

/**
 * Activates the file named \a $name in extension \a $extension
 * note This works similar to include_once() meaning that it's included one time.
 * @deprecated Since 4.3
 */
function ext_activate( $extension, $name )
{
    $base = eZExtension::baseDirectory();
    $include = "$base/$extension/$name";
    return include_once( $include );
}

/**
 * Activates the file named \a $name in extension \a $extension
 * note This works similar to include_once() meaning that it's included one time.
 *
 * @deprecated Since 4.3
 */
function ext_class( $extension, $name )
{
    $name = strtolower( $name );
    $base = eZExtension::baseDirectory();
    $include = "$base/$extension/classes/$name.php";
    return include_once( $include );
}

/**
 * lib include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function lib_include( $libName, $name )
{
    $include = "lib/$libName/classes/$name";
    return include_once( $include );
}

/**
 * lib class include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function lib_class( $libName, $name )
{
    $name = strtolower( $name );
    $include = "lib/$libName/classes/$name.php";
    return include_once( $include );
}

/**
 * kernel class include function for pre eZ Publish 4.0.
 *
 * @deprecated Since 4.3
 */
function kernel_class( $name )
{
    $name = strtolower( $name );
    $include = "kernel/classes/$name.php";
    return include_once( $include );
}


?>
