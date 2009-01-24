#!/usr/bin/env php
<?php

require 'autoload.php';

$cli = eZCLI::instance();
$script = eZScript::instance( array( 'description' => ( "Minify the main CSS of the planet" ),
                                     'use-session' => false,
                                     'use-modules' => true,
                                     'use-extensions' => true ) );

$script->startup();
$script->initialize();

$designINI = eZINI::instance( 'design.ini' );
$miniCSS = $designINI->variable( 'StylesheetSettings', 'SiteCSS' );
$fullCSS = $designINI->variable( 'StylesheetSettings', 'FullSiteCSS' );

$bases = eZTemplateDesignResource::allDesignBases();
$triedFiles = array();
$fileInfo = eZTemplateDesignResource::fileMatch( $bases, false, $fullCSS, $triedFiles );

if ( !$fileInfo )
{
    $siteDesign = eZTemplateDesignResource::designSetting( 'site' );
    $cli->error( $fullCSS . ' not found !' );
}
else
{
    $filePathFull = $fileInfo['path'];
    $filePathMini = str_replace( $fullCSS, $miniCSS, $filePathFull );
    $cssContent = @file_get_contents( $filePathFull );
    if ( $cssContent === false )
    {
        $cli->error( 'Cannot read ' . $filePathFull );
    }
    else
    {
        $miniCSSContent = cssmin::minify( $cssContent );
        $res = @file_put_contents( $filePathMini, $miniCSSContent );
        if ( $res === false )
        {
            $cli->error( 'Error when writing to ' . $filePathMini );
        }
        else
        {
            $cli->output( $filePathMini . ' written !' );
        }
    }
}

$script->shutdown();

?>
