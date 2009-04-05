<?php
/**
 * File containing the ezcFeedRequiredMetaDataMissingException class.
 *
 * @package Feed
 * @version 1.2.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Thrown when some data is missing for a channel.
 *
 * @package Feed
 * @version 1.2.1
 */
class ezcFeedRequiredMetaDataMissingException extends ezcFeedException
{
    /**
     * Constructs a new ezcFeedRequiredMetaDataMissingException.
     *
     * @param string $attribute The attribute which caused the exception
     */
    public function __construct( $attribute )
    {
        parent::__construct( "There is no data for required element '{$attribute}'." );
    }
}
?>
