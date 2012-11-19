<?php

namespace Planet\PlanetBundle\Repository;

use eZ\Publish\Core\SignalSlot\Repository as SignalSlotRepository,
    Planet\PlanetBundle\Repository\LocationService;


class Repository extends SignalSlotRepository
{

    public function getLocationService()
    {
        if ( $this->locationService !== null )
            return $this->locationService;

        $this->locationService = new LocationService( $this, $this->repository->getLocationService(), $this->signalDispatcher );
        return $this->locationService;
    }

}
