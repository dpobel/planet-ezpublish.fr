<?php

class eZPlaneteUtils
{
    private $Operators = array();

    function __construct()
    {
        $this->Operators = array( 'clean_rewrite_xhtml' );
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
                                                                           'default' => '' ) ) );
    }


    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace, $currentNamespace, &$operatorValue, $namedParameters )
    {
        if ( $operatorName == 'clean_rewrite_xhtml' )
        {
            $html = $operatorValue;
            $operatorValue = self::cleanRewriteXHTML( $html, $namedParameters['url_site'] );
        }

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
        $dom->loadXML( $xml );
        $xpath = new DomXPath( $dom );
        // avoid XSS attacks
        self::cleanScript( $xpath );
        // remove unnecessary tags
        self::cleanTags( $xpath );
        // rewriting malformed URIs
        self::rewriteURI( $xpath, $urlSite );
        $res = str_replace( '<?xml version="1.0"?>', '', $dom->saveXML() );
        //eZDebug::writeDebug( $html, 'Before' );
        //eZDebug::writeDebug( $res, 'After' );
        return $res;
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
        $anchorNodes = $xpath->query( '//a[not( @href )]' );
        foreach( $anchorNodes as $anchor )
        {
            $parent = $anchor->parentNode;
            $parent->removeChild( $anchor );
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
