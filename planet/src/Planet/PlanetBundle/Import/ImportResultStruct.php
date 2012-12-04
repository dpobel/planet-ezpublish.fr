<?php

namespace Planet\PlanetBundle\Import;

use eZ\Publish\API\Repository\Values\Content\Content;

/**
 * Holds the result of an import
 */
class ImportResultStruct
{
    /**
     * The list of created contents
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    protected $created = array();

    /**
     * The list of updated contents
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    protected $updated = array();

    /**
     * The list of unchanged contents
     *
     * @var \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    protected $unchanged = array();

    /**
     * Returns the list of created contents
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Add a content as created
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Content $content
     */
    public function addCreated( Content $content )
    {
        $this->created[] = $content;
    }

    /**
     * Returns the list of updated contents
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add a content as updated
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Content $content
     */
    public function addUpdated( Content $content )
    {
        $this->updated[] = $content;
    }

    /**
     * Returns the list of unchanged contents
     *
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function getUnchanged()
    {
        return $this->unchanged;
    }

    /**
     * Add a content as unchanged
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Content $content
     */
    public function addUnchanged( Content $content )
    {
        $this->unchanged[] = $content;
    }

}
