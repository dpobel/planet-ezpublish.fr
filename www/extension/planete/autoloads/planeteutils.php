<?php
/**
 * $Id$
 * $HeadURL$
 */

class eZPlaneteUtils
{
    private $Operators = array();

    function __construct()
    {
        $this->Operators = array( 'clean_rewrite_xhtml',
                                  'bookmarkize',
                                  'entity_decode' );
    }

    function operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }
 
    function namedParameterList()
    {
        return array( 'clean_rewrite_xhtml' => array( 'url_site' => array( 'type' => 'string',
                                                                           'required' => true,
                                                                           'default' => '' ) ),
                      'entity_decode' => array(),
                      'bookmarkize' => array( 'post_url' => array( 'type' => 'string',
                                                                   'required' => true,
                                                                   'default' => '' ),
                                              'post_name' => array( 'type' => 'string',
                                                                    'required' => false,
                                                                    'default' => false ) ) );
    }


    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        if ( $operatorName == 'clean_rewrite_xhtml' )
        {
            $html = $operatorValue;
            eZDebug::accumulatorStart( 'planete', 'Planete', 'Clean rewrite operator' );
            $operatorValue = self::cleanRewriteXHTML( $html, $namedParameters['url_site'] );
            eZDebug::accumulatorStop( 'planete' );
        }
        elseif ( $operatorName == 'entity_decode' )
        {
            $html = $operatorValue;
            $ini = eZINI::instance( 'template.ini' );
            $operatorValue = html_entity_decode( $html, ENT_QUOTES,
                                                 $ini->variable( 'CharsetSettings', 'DefaultTemplateCharset' ) );
        }
        elseif ( $operatorName == 'bookmarkize' )
        {
            $url = $operatorValue;
            $postName = $namedParameters['post_url'];
            $postURL = $namedParameters['post_url'];
            if ( isset( $namedParameters['post_name'] ) && $namedParameters['post_name'] )
            {
                $postName = $namedParameters['post_name'];
            }
            $operatorValue = self::bookmarkize( $url, $postURL, $postName );
        }
    }


    static function bookmarkize( $url, $postURL, $postName )
    {
        $url = str_replace( '%url', $postURL, $url );
        return str_replace( '%title', $postName, $url );
    }

    static function cleanRewriteXHTML( $html, $urlSite )
    {
        // cleanup using tidy
        $tidy = new Tidy();
        $config = array( 'indent' => false,
                         'show-body-only' => true,
                         'alt-text' => '',
                         'wrap' => 0,
                         'numeric-entities' => true,
                         'output-xhtml' => true );
        $tidy->parseString( $html, $config, 'utf8' );
        $tidy->cleanRepair();
        $res = (string) $tidy;
        // manual cleanup
        $xml = '<div>' . $res . '</div>';
        $dom = new DomDocument();
        $parsing = $dom->loadXML( $xml );
        eZDebug::writeDebug( $xml );
        if ( $parsing )
        {
            $xpath = new DomXPath( $dom );
            // avoid XSS attacks
            self::cleanScript( $xpath );
            // remove unnecessary tags
            self::cleanTags( $xpath );
            // rewriting malformed URIs
            self::rewriteURI( $xpath, $urlSite );
            $res = str_replace( '<?xml version="1.0"?>', '', $dom->saveXML() );
            return $res;
        }
        else
        {
            eZDebug::writeError( $xml, 'Failed to parse XML in ' . __METHOD__ );
        }
        return $xml;
    }

    static function rewriteURI( $xpath, $urlSite )
    {
        $attributeNodes = $xpath->query( '//@*[( local-name() = "href" or local-name() = "src" )
                                                and not( starts-with( ., "http" ) )]' );
        $urlInfo = parse_url( $urlSite );
        foreach( $attributeNodes as $attribute )
        {
            if ( $attribute->value[0] == '/' )
            {
                $attribute->value = $urlInfo['scheme'] . '://' . $urlInfo['host'] . $attribute->value;
            }
            elseif ( strpos( $attribute->value, ':' ) === false )
            {
                $attribute->value = $urlSite . $attribute->value;
            }
        }

    }

    static function cleanTags( $xpath )
    {
        // remove <br /> at the beginning
        $root = $xpath->document->documentElement;
        foreach( $root->childNodes as $child )
        {
            if ( $child->localName == 'br' )
            {
                $root->removeChild( $child );
            }
            else
            {
                break ;
            }
        }

        // get rid of <a /> used as anchor
        $anchorNodes = $xpath->query( '//a[not( @href )]' );
        foreach( $anchorNodes as $anchor )
        {
            $parent = $anchor->parentNode;
            $parent->removeChild( $anchor );
        }
        // get rid of target attribute on link
        $targetAttributes = $xpath->query( '//@*[local-name() = "target" and local-name( .. ) = "a"]' );
        foreach( $targetAttributes as $attr )
        {
            $aNode = $attr->parentNode;
            $aNode->removeAttributeNode( $attr );
        }
        // get rid of valign and align attributes
        $targetAttributes = $xpath->query( '//@*[local-name() = "align" or local-name() = "valign"]' );
        foreach( $targetAttributes as $attr )
        {
            $aNode = $attr->parentNode;
            $aNode->removeAttributeNode( $attr );
        }
        // remove developper.com stuffs
        $divNodes = $xpath->query( '//div[contains( @style, "font-size" )
                                          and contains( a/@href, "http://blog.developpez.com/" )]' );
        if ( $divNodes && $divNodes->length === 1 )
        {
            $divNode = $divNodes->item( 0 );
            $contentNode = $divNode->parentNode;
            $contentNode->removeChild( $divNode );
        }
    }

    static function cleanScript( $xpath )
    {
        $scriptNodes = $xpath->query( '//script' );
        foreach( $scriptNodes as $script )
        {
            $parent = $script->parentNode;
            $parent->removeChild( $script );
        }
        $attributeNodes = $xpath->query( '//@*[starts-with( local-name(), "on" )]' );
        foreach( $attributeNodes as $attr )
        {
            $parent = $attr->parentNode;
            $parent->removeAttributeNode( $attr );
        }
    }

    static function rssCacheInfo()
    {
        $ini = eZINI::instance();
        $varDir = $ini->variable( 'FileSettings', 'VarDir' );
        $cacheDir = $varDir . '/' . $ini->variable( 'FileSettings', 'CacheDir' ) . '/rss/';
        return array( 'cache-dir' => $cacheDir,
                      'cache-file' => 'planet.php' );
    }

}






?>
