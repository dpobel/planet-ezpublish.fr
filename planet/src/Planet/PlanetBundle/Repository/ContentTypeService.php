<?php

namespace Planet\PlanetBundle\Repository;

use eZ\Publish\Core\SignalSlot\ContentTypeService as SignalSlotContentTypeService;


class ContentTypeService extends SignalSlotContentTypeService
{

    protected $typesMap = array();

    public function loadContentTypeByIdentifier( $identifier )
    {
        if ( !isset( $this->typesMap[$identifier] ) )
        {
            $this->typesMap[$identifier] = parent::loadContentTypeByIdentifier( $identifier );
            $id = $this->typesMap[$identifier]->id;
            $this->typesMap[$id] = $this->typesMap[$identifier];
        }
        return $this->typesMap[$identifier];
    }

    public function loadContentType( $id )
    {
        if ( !isset( $this->typesMap[$id] ) )
        {
            $this->typesMap[$id] = parent::loadContentType( $id );
            $identifier = $this->typesMap[$id]->identifier;
            $this->typesMap[$identifier] = $this->typesMap[$id];
        }
        return $this->typesMap[$id];
    }

}
