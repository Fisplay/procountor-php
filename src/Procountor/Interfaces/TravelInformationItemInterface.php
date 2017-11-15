<?php
namespace Procountor\Interfaces;

use DateTime;

interface TravelInformationItemInterface extends AbstractResourceInterface {
    //Travel departure date. ,
    public function getDeparture(): ?DateTime;

    //Travel return date. ,
    public function getArrival(): ?DateTime;

    //Travel destinations. ,
    public function getPlaces(): ?string;

    //Travel purpose.
    public function getPurpose(): ?string;
}
