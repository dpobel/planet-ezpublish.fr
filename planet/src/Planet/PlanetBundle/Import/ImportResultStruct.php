<?php

namespace Planet\PlanetBundle\Import;

use eZ\Publish\API\Repository\Values\Content\Content;

class ImportResultStruct
{
    protected $created = array();

    protected $updated = array();

    protected $unchanged = array();

    public function getCreated()
    {
        return $this->created;
    }

    public function addCreated( Content $content )
    {
        $this->created[] = $content;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function addUpdated( Content $content )
    {
        $this->updated[] = $content;
    }

    public function getUnchanged()
    {
        return $this->unchanged;
    }

    public function addUnchanged( Content $content )
    {
        $this->unchanged[] = $content;
    }


}
