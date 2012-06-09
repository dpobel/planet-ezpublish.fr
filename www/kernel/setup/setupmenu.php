<?php
/**
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version  2012.5
 * @package kernel
 */

$Module = $Params['Module'];

$http = eZHTTPTool::instance();

$contentIni = eZINI::instance( 'content.ini' );

$Module->setTitle( ezpI18n::tr( 'kernel/setup', 'Setup menu' ) );
$tpl = eZTemplate::factory();

$Result = array();
$Result['content'] = $tpl->fetch( 'design:setup/setupmenu.tpl' );
$Result['path'] = array( array( 'url' => '/setup/menu',
                                'text' => ezpI18n::tr( 'kernel/setup', 'Setup menu' ) ) );

?>
