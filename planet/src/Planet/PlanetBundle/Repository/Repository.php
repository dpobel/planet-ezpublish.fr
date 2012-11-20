<?php

namespace Planet\PlanetBundle\Repository;

use eZ\Publish\Core\SignalSlot\Repository as SignalSlotRepository,
    Planet\PlanetBundle\Repository\LocationService,
    Planet\PlanetBundle\Repository\ContentTypeService;


class Repository extends SignalSlotRepository
{

    public function getLocationService()
    {
        if ( $this->locationService !== null )
            return $this->locationService;

        $this->locationService = new LocationService( $this, $this->repository->getLocationService(), $this->signalDispatcher );
        return $this->locationService;
    }

    public function getContentTypeService()
    {
        if ( $this->contentTypeService !== null )
            return $this->contentTypeService;

        $this->contentTypeService = new ContentTypeService( $this->repository->getContentTypeService(), $this->signalDispatcher );
        return $this->contentTypeService;
    }
}
