<?php

class eZPlaneteUtils
{
    private $Operators = array();

    function __construct()
    {
        $this->Operators = array( 'clean_rewrite_xhtml',
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
                      'entity_decode' => array() );
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
    }


    static function cleanRewriteXHTML( $html, $urlSite )
    {
        $html = trim( $html );
        if ( $html === '' )
        {
            return '';
        }
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
        $xml = '<div>' . trim( $res ) . '</div>';
        $dom = new DomDocument();
        $parsing = $dom->loadXML( $xml );
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
            return trim( $res );
        }
        else
        {
            eZDebug::writeError( $xml, 'Failed to parse XML in ' . __METHOD__ );
        }
        return $xml;
    }

    static function rewriteURI( $xpath, $urlSite )
    {
        $attributeNodes = $xpath->query(
            '//@*[( local-name() = "href" or local-name() = "src" ) and not( starts-with( ., "http" ) ) and not( starts-with( ., "//" ) )]'
        );
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
        $toRemove = array();
        foreach( $root->childNodes as $child )
        {
            if (
                $child->localName == 'br'
                || (
                    $child->nodeType === XML_TEXT_NODE
                    && trim( $child->nodeValue ) === ''
                )
            )
            {
                $toRemove[] = $child;
            }
            else
            {
                break ;
            }
        }
        foreach ( $toRemove as $r )
        {
            $r->parentNode->removeChild( $r );
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
        // get rid of deprecated table attributes: cellpadding, cellspacing, 
        // width, summary, border
        $tableAttributes = $xpath->query(
            '//@*[local-name( .. ) = "table" and ( local-name() = "summary" or local-name() = "cellpadding" or ' .
            'local-name() = "cellspacing" or local-name() = "width" or local-name() = "border" )]'
        );
        foreach( $tableAttributes as $attr )
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
        // remove tweetmeme widget
        $divNodes = $xpath->query( '//div[@class="tweetmeme_button"]' );
        if ( $divNodes && $divNodes->length > 0 )
        {
            foreach( $divNodes as $div )
            {
                $parent = $div->parentNode;
                $parent->removeChild( $div );
            }
        }
        // <pre> : remove empty and trim the not empty ones
        $preNodes = $xpath->query( '//pre' );
        if ( $preNodes && $preNodes->length > 0 )
        {
            foreach ( $preNodes as $pre )
            {
                if ( trim( $pre->textContent ) == '' )
                {
                    $pre->parentNode->removeChild( $pre );
                }
                else
                {
                    $lastChild = $pre->childNodes->item( $pre->childNodes->length - 1 );
                    $lastChild->nodeValue = trim( $lastChild->nodeValue );
                }
            }
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
