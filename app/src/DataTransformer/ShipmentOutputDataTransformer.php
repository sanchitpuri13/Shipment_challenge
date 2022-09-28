<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ShipmentOutput;
use App\Entity\Shipment;

final class ShipmentOutputDataTransformer implements DataTransformerInterface
{
    /**
     * This function is used to transform the Output object to custom structure
     *
     * @param [type] $data
     * @param string $to
     * @param array $context
     * @return void
     */
    public function transform($data, string $to, array $context = [])
    {
        $output = new ShipmentOutput();
        $output->id = $data->getShipmentId();
        $output->distance = $data->getDistanceInMeters();
        $output->time = $data->getShipmentTime();
        $output->cost = $data->getCost();
        $output->company['name'] =  $data->getCompany()->getName();
        $output->company['email'] =  $data->getCompany()->getEmail();
        $output->carrier['name'] =  $data->getCarrier()->getName();
        $output->carrier['email'] =  $data->getCarrier()->getEmail();
        $output->route[0]['stop_id'] = $data->getOriginStopId();
        $output->route[0]['postcode'] = $data->getOriginPostcode();
        $output->route[0]['city'] = $data->getOriginCity();
        $output->route[0]['country'] = $data->getOriginCountry();
        $output->route[1]['stop_id'] = $data->getDestinationStopId();
        $output->route[1]['postcode'] = $data->getDestinationPostcode();
        $output->route[1]['city'] = $data->getDestinationCity();
        $output->route[1]['country'] = $data->getDestinationCountry();
        return $output;
    }

    /**
     * This function is responsible for identifying the object to be transfomed is Shipment object or not
     *
     * @param [type] $data
     * @param string $to
     * @param array $context
     * @return boolean
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return ShipmentOutput::class === $to && $data instanceof Shipment;
    }
}
