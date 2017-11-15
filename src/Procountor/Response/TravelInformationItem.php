<?php
namespace Procountor\Response;

use Procountor\Interfaces\TravelInformationItemInterface;

use DateTime;
use stdClass;

class TravelInformationItem extends AbstractResponse implements TravelInformationItemInterface {

    //Travel departure date. ,
    public function getDeparture(): ?DateTime
    {
        return new DateTime($this->data->departure);
    }

    //Travel return date. ,
    public function getArrival(): ?DateTime
    {
        return new DateTime($this->data->arrival);
    }

    //Travel destinations. ,
    public function getPlaces(): ?string
    {
        return $this->data->places;
    }

    //Travel purpose.
    public function getPurpose(): ?string
    {
        return $this->data->purpose;
    }

}

