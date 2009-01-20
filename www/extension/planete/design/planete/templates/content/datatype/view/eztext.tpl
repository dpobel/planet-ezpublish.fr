{if and( is_set( $mode ), $mode|eq( 'html' ) )}
    {$attribute.content|clean_rewrite_xhtml( $base_url )}
{else}
    {$attribute.content|wash( xhtml )|nl2br}
{/if}
