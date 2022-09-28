<?php

namespace App\Service\Helper;

use Exception;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Helper implements HelperInterface
{
    /**
     * This function is used to read json data from file and convert the data into array
     *
     * @param string $file
     * @return array|null
     */
    public function convertFileDataIntoArray(string $file): ?array
    {
        try {
            if (file_exists($file)) {
                return json_decode(file_get_contents($file), true);
            } else {
                throw new FileNotFoundException("File Not Found");
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * This function is used to make array consisting of unique companiese using company name as identifier
     *
     * @param array $data
     * @return array
     */
    public function getCompanyDataFromShipments(array $data): array
    {
        $company = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists($value['company']['name'], $company)) {
                $company[$value['company']['name']] = $value['company'];
            }
        }
        return $company;
    }

    /**
     * This function is used to make array consisting of unique carriers using carrier name as identifier
     *
     * @param array $data
     * @return array
     */
    public function getCarriersDataFromShipments(array $data): array
    {
        $carrier = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists($value['carrier']['name'], $carrier)) {
                $carrier[$value['carrier']['name']] = $value['carrier'];
            }
        }
        return $carrier;
    }

    /**
     * This function is used to make array consisting of unique shipments using shipment id as identifier
     *
     * @param array $data
     * @return array
     */
    public function getShipmentsData(array $data): array
    {
        $shipments = [];
        foreach ($data as $key => $value) {
            if (!array_key_exists($value['id'], $shipments)) {
                $shipments[$value['id']] = $value;
            }
        }
        return $shipments;
    }

    /**
     * This function is used to calculate cost of shipment on basis of the shipment distance in kilometers
     *
     * @param float $distanceInKm
     * @return float|null
     */
    public function getCostOfShipment(float $distanceInKm): ?float
    {
        $cost = 0;
        switch ($distanceInKm) {
            case ($distanceInKm <= 100):
                $cost =  $distanceInKm * .30;
                break;
            case ($distanceInKm > 100 && $distanceInKm <= 200):
                $cost =  (($distanceInKm - 100) * .25) + (100 * .30);
                break;
            case ($distanceInKm > 200 && $distanceInKm <= 300):
                $cost =  (($distanceInKm - 200) * .20) + (100 * .25) + (100 * .30);
                break;
            case ($distanceInKm > 300):
                $cost =  (($distanceInKm - 300) * .15) + (100 * .20) + (100 * .25) + (100 * .30);
                break;
        }
        return number_format($cost, 2, '.', '');
    }

    /**
     * This function is used to convert Distance in metres to Distance in Kilometers
     *
     * @param [type] $distanceInMeters
     * @return float|null
     */
    public function getDistanceInKm($distanceInMeters): ?float
    {
        return $distanceInMeters / 1000;
    }
}
