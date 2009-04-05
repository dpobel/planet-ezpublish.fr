<?php
/**
 * File containing the ezcFeedTextElement class.
 *
 * @package Feed
 * @version 1.2.1
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Class defining a text element.
 *
 * @property string $text
 *                  The actual text of this feed element.
 * @property string $type
 *                  The type of the value stored in text.
 *
 * @package Feed
 * @version 1.2.1
 */
class ezcFeedTextElement extends ezcFeedElement
{
    /**
     * The actual text.
     *
     * @var string
     */
    public $text;

    /**
     * The type of the text.
     *
     * @var string
     */
    public $type;

    /**
     * Returns the text attribute.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->text . '';
    }
}
?>
