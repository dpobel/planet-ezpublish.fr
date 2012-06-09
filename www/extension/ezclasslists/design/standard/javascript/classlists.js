// $Id: classlists.js 18 2011-06-22 19:53:59Z dpobel $
// $HeadURL: http://svn.projects.ez.no/ezclasslists/tags/ezclasslists_1_2/ezclasslists/design/standard/javascript/classlists.js $
// TODO: rewrite this !
var CLASSLISTS_MAIN_CONTENT_ID = 'fix';

function classListsFilter( e, options )
{
    var baseURL = options.baseURL;
    var imgLoader = options.loader;
    if ( !YAHOO.util.Connect.asyncRequest )
    {
        return true;
    }
    var callback = { success: function( o )
                              {
                                  var content = document.getElementById( CLASSLISTS_MAIN_CONTENT_ID );
                                  if ( !content )
                                  {
                                      return;
                                  }
                                  content.innerHTML = o.responseText;
                              }
                   };
    var classListsURL = classListsBuildURL( baseURL );
    classListsWait( imgLoader );
    var transaction = YAHOO.util.Connect.asyncRequest( 'GET', classListsURL, callback );
    YAHOO.util.Event.preventDefault( e );
}

function classListsWait( imgLoader )
{
    var content = document.getElementById( CLASSLISTS_MAIN_CONTENT_ID );
    if ( !content )
    {
        return;
    }
    content.innerHTML = '<p style="text-align:center;padding-top:4em;"><img src="' + imgLoader + '" alt="Loading..." /></p>';
}

function classListsBuildURL( baseURL )
{
    var classIdentfier = classListsGetSelectValue( 'classIdentifier' );
    var sortMethod = classListsGetSelectValue( 'sortMethod' );
    var sortOrder  = classListsGetSelectValue( 'sortOrder' );
    return baseURL + '/' + classIdentfier + '/' + sortMethod + '/' + sortOrder + '/ajax';

}

function classListsGetSelectValue( selectID )
{
    var element = document.getElementById( selectID );
    if ( !element )
    {
        return '';
    }
    return element.options[element.selectedIndex].value;
}
