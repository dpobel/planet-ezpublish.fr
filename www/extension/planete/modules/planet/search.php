<?php

$Module = $Params['Module'];
$Offset = $Params['Offset'];

if ( !is_numeric( $Offset ) )
{
    $Offset = 0;
}

$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();
$ini = eZINI::instance();
$planetINI = eZINI::instance( 'planete.ini' );
$logSearchStats = $ini->variable( 'SearchSettings', 'LogSearchStats' ) == 'enabled';
$pageLimit = $planetINI->variable( 'PageSettings', 'PostByPage' );

$searchText = $http->getVariable( 'SearchText', '' );

$searchSectionID = -1;
$searchTimestamp = false;
$searchType = "fulltext";
$subTreeArray = array( $planetINI->variable( 'TreeSettings', 'BlogsNodeID' ) );

$facet =array(
    array(
        "field" => "extra_parent_node_name_k",
        "limit" => 10
    ),
);

$filterList = array();
if ( $http->hasGetVariable( 'Author' ) )
{
    $filterList[planetIndexParentName::PARENT_NAME_SOLR_ATTRIBUE] = $http->getVariable( 'Author' );
}

$searchResult = eZSearch::search(
    $searchText,
    array(
        "SearchType" => $searchType,
        "SearchSectionID" => $searchSectionID,
        "SearchSubTreeArray" => $subTreeArray,
        'SearchTimestamp' => $searchTimestamp,
        "SearchLimit" => $pageLimit,
        "SearchOffset" => $Offset,
        "SearchContentClassID" => array(
            $planetINI->variable( 'ImportSettings', 'PostClassID' )
        ),
        "SearchDate" => (int) $http->getVariable( 'DateFilter', 0 ),
        "SortBy" => array( 'score' => 'asc', 'published' => 'desc' ),
        "SpellCheck" => array( true, 'default' ),
        "Facet" => $facet,
        "Filter" => $filterList,
    )
);

$viewParameters = array( 'offset' => $Offset );

$searchData = false;
$tpl->setVariable( 'search_author', $http->getVariable( 'Author', '' ) );
$tpl->setVariable( 'search_date_filter', (int) $http->getVariable( 'DateFilter', 0 ) );
$tpl->setVariable( "search_data", $searchData );
$tpl->setVariable( "search_section_id", $searchSectionID );
$tpl->setVariable( "search_subtree_array", $subTreeArray );
$tpl->setVariable( 'search_timestamp', $searchTimestamp );
$tpl->setVariable( "search_text", $searchText );
$tpl->setVariable( 'page_limit', $pageLimit );

$tpl->setVariable( "view_parameters", $viewParameters );
$tpl->setVariable( "offset", $Offset );
$tpl->setVariable( "search_text_enc", urlencode( $searchText ) );
$tpl->setVariable( "search_result", $searchResult["SearchResult"] );
$tpl->setVariable( "search_count", $searchResult["SearchCount"] );
$tpl->setVariable( "stop_word_array", $searchResult["StopWordArray"] );
if ( isset( $searchResult["SearchExtras"] ) )
{
    $tpl->setVariable( "search_extras", $searchResult["SearchExtras"] );
}

$Result = array();
$tpl->setVariable( 'persistent_variable', false );
$Result['content'] = $tpl->fetch( "design:planet/search.tpl" );
$Result['path'] = array( array( 'text' => ezpI18n::tr( 'kernel/content', 'Search' ),
                                'url' => false ) );

$Result['content_info'] = array();
$Result['content_info']['node_id'] = false;
$Result['content_info']['object_id'] = false;
$Result['content_info']['persistent_variable'] = $tpl->variable( 'persistent_variable' );
eZDebug::writeDebug( $Result['content_info'], 'Content info' );

$searchData = $searchResult;
if ( $logSearchStats and
     trim( $searchText ) != "" and
     is_array( $searchData ) and
     array_key_exists( 'SearchCount', $searchData ) and
     is_numeric( $searchData['SearchCount'] ) )
{
    eZSearchLog::addPhrase( $searchText, $searchData["SearchCount"] );
}

?>
