<?php
//
// Definition of CssInlineImageOptimizer class
//
// Created on: 2012-01-19 19:00
// Author: johan.beronius@athega.se
//

class CssInlineImageOptimizer
{
    /**
     * Inline small images as Data URL in the CSS to minimize number of HTTP requests.
     *
     * @param string $css Concated Css string
     * @param int $packLevel Level of packing, values: 2-3
     * @return string
     */
    public static function optimize( $css, $packLevel = 2 )
    {
        $maxBytes = 2048;
        $ezjscINI = eZINI::instance( 'ezjscore.ini' );
        if ( $ezjscINI->hasVariable( 'CssInlineImageOptimizer', 'InlineImageMaxBytes' ) )
        {
            $maxBytes = (int)$ezjscINI->variable( 'CssInlineImageOptimizer', 'InlineImageMaxBytes' );
        }
        $excludePatterns = $ezjscINI->variable( 'CssInlineImageOptimizer', 'ExcludePatterns' );

        if ( $packLevel > 2 && $maxBytes > 0 && preg_match_all( "/url\(\s*[\'|\"]?([A-Za-z0-9_\-\/\.\\%?&#]+)[\'|\"]?\s*\)/ix", $css, $urlMatches ) )
        {
           $urlMatches = array_unique( $urlMatches[1] );
           foreach ( $urlMatches as $match )
           {
               if ( $match[0] === '/' && preg_match( "/\.(gif|png|jpe?g)$/i", $match, $imageType ) )
               {
                   $imagePath = '.' . $match;
                   if ( !file_exists( $imagePath ) )
                   {
                       eZDebug::writeWarning( $match . ' referenced in stylesheets does not exist', __METHOD__ );
                       continue;
                   }
                   $imageSize = filesize( $imagePath );
                   if ( $imageSize > 0 && $imageSize < $maxBytes && !self::excludeImage( $imagePath, $excludePatterns ) )
                   {
                        if ( $imageType[1] == 'jpg' )
                            $imageType[1] = 'jpeg';

                        $imageContents = file_get_contents( $imagePath );
                        $dataURL = 'data:image/' . $imageType[1] . ';base64,' . base64_encode( $imageContents );
                        $css = str_replace( $match, $dataURL, $css );
                   }
               }
           }
        }
        return $css;
    }

    /**
     * Checks if the image should be excluded from the base64 encoding or not.
     *
     * @param string $imagePath the path to the image
     * @param array $patterns array of PCRE patterns
     * @return bool
     */
    private static function excludeImage( $imagePath, array $patterns )
    {
        foreach ( $patterns as $pattern )
        {
            if ( preg_match( $pattern, $imagePath ) )
            {
                return true;
            }
        }
        return false;
    }
}
?>
