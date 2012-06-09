<?php
/**
 * File containing the ezpRelationAjaxUploader class.
 *
 * @copyright Copyright (C) 1999-2012 eZ Systems AS. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License v2
 * @version 1.5.0
 * @package ezjscore
 * @subpackage ajaxuploader
 */

/**
 * This class handles AJAX Upload for eZObjectRelation attributes
 *
 * @package ezjscore
 * @subpackage ajaxuploader
 */
class ezpRelationAjaxUploader extends ezpRelationListAjaxUploader
{
    /**
     * Checks if a file can be uploaded.
     *
     * @return boolean
     */
    public function canUpload()
    {
        $access = eZUser::instance()->hasAccessTo( 'content', 'create' );
        if ( $access['accessWord'] === 'no' )
        {
            return false;
        }
        return true;
    }

}

?>
