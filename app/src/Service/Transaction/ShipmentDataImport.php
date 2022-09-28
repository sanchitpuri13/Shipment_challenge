<?php

namespace App\Service\Transaction;

use Exception;
use App\Entity\Carrier;
use App\Entity\Company;
use App\Entity\Shipment;
use App\Service\Helper\Helper;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Transaction\TransactionInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use App\Factory\EntityFactory\EntityObjectFactory;

class ShipmentDataImport implements TransactionInterface
{
    private $em;
    private $helperObject;

    public function __construct(EntityManagerInterface $em, Helper $helperObject)
    {
        $this->em = $em;
        $this->helperObject = $helperObject;
    }

    /**
     * This function is used to begin the database transaction
     *
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->em->getConnection()->beginTransaction();
    }

    /**
     * This function is used to commit the database transaction
     *
     * @return void
     */
    public function commitTransaction(): void
    {
        $this->em->getConnection()->commit();
    }

    /**
     * This function is used to rollback the database transaction
     *
     * @return void
     */
    public function rollbackTransaction(): void
    {
        $this->em->getConnection()->rollback();
    }

    /**
     * This function is used to create the company data in batch process
     *
     * @param array $companyData
     * @param ProgressBar $progressBar
     * @return void
     */
    public function createCompany(array $companyData, ProgressBar $progressBar): void
    {
        try {
            $this->beginTransaction();
            $index = 0;
            $batchSize = 20;
            foreach ($companyData as $company) {

                $progressBar->advance();

                if (!is_null($this->getCompany($company['name']))) {
                    continue;
                }

                $index++;
                $companyObj = EntityObjectFactory::getObjectForEntity('Company');
                $companyObj->setName($company['name']);
                $companyObj->setEmail($company['email']);
                $this->em->persist($companyObj);

                if (($index % $batchSize) == 0) {
                    $this->em->flush();
                    $this->em->clear();
                }
            }
            $this->em->flush();
            $this->em->clear();
            $this->commitTransaction();
        } catch (Exception $ex) {
            $this->rollbackTransaction();
            throw $ex;
        }
    }

    /**
     * This function is used to create the carrier data in batch process
     *
     * @param array $carrierData
     * @param ProgressBar $progressBar
     * @return void
     */
    public function createCarrier(array $carrierData, ProgressBar $progressBar): void
    {
        try {
            $this->beginTransaction();
            $index = 0;
            $batchSize = 20;
            foreach ($carrierData as $carrier) {
                $progressBar->advance();

                if (!is_null($this->getCarrier($carrier['name']))) {
                    continue;
                }

                $index++;
                $carrierObj = EntityObjectFactory::getObjectForEntity('Carrier');
                $carrierObj->setName($carrier['name']);
                $carrierObj->setEmail($carrier['email']);
                $this->em->persist($carrierObj);
                if (($index % $batchSize) == 0) {
                    $this->em->flush();
                    $this->em->clear();
                }
            }
            $this->em->flush();
            $this->em->clear();
            $this->commitTransaction();
        } catch (Exception $ex) {
            $this->rollbackTransaction();
            throw $ex;
        }
    }

    /**
     * This function is used to create the shipment data in batch process
     *
     * @param array $shipmentData
     * @param ProgressBar $progressBar
     * @return void
     */
    public function createShipment(array $shipmentData, ProgressBar $progressBar): void
    {
        try {
            $this->beginTransaction();
            $index = 0;
            $batchSize = 20;
            foreach ($shipmentData as $shipment) {
                $progressBar->advance();

                if (!is_null($this->getShipment($shipment['id']))) {
                    continue;
                }

                $index++;
                $shipmentObj = EntityObjectFactory::getObjectForEntity('Shipment');

                $shipmentObj->setShipmentId($shipment['id']);
                $shipmentObj->setDistanceInMeters($shipment['distance']);
                $shipmentObj->setDistanceInKm($this->helperObject->getDistanceInKm($shipment['distance']));
                $shipmentObj->setShipmentTime($shipment['time']);
                $shipmentObj->setOriginStopId($shipment['route'][0]['stop_id']);
                $shipmentObj->setOriginPostcode($shipment['route'][0]['postcode']);
                $shipmentObj->setOriginCity($shipment['route'][0]['city']);
                $shipmentObj->setOriginCountry($shipment['route'][0]['country']);
                $shipmentObj->setDestinationStopId($shipment['route'][1]['stop_id']);
                $shipmentObj->setDestinationPostcode($shipment['route'][1]['postcode']);
                $shipmentObj->setDestinationCity($shipment['route'][1]['city']);
                $shipmentObj->setDestinationCountry($shipment['route'][1]['country']);

                $shipmentObj->setCompany($this->getCompany($shipment['company']['name']));
                $shipmentObj->setCarrier($this->getCarrier($shipment['carrier']['name']));

                $shipmentObj->setCost($this->helperObject->getCostOfShipment($this->helperObject->getDistanceInKm($shipment['distance']), $shipment['time']));

                $this->em->persist($shipmentObj);

                if (($index % $batchSize) == 0) {
                    $this->em->flush();
                    $this->em->clear();
                }
            }
            $this->em->flush();
            $this->em->clear();
            $this->commitTransaction();
        } catch (Exception $ex) {
            $this->rollbackTransaction();
            throw $ex;
        }
    }

    /**
     * This function is used to search the company using company name
     *
     * @param string $name
     * @return Company|null
     */
    private function getCompany(string $name): ?Company
    {
        return $this->em->getRepository(Company::class)->findOneByCompanyName($name);
    }

    /**
     * This function is used to search the carrier using carrier name
     *
     * @param string $name
     * @return Carrier|null
     */
    private function getCarrier(string $name): ?Carrier
    {
        return $this->em->getRepository(Carrier::class)->findOneByCarrierName($name);
    }

    /**
     * This function is used to search the shipment using shipment id
     *
     * @param integer $shipmentId
     * @return Shipment|null
     */
    private function getShipment(int $shipmentId): ?Shipment
    {
        return $this->em->getRepository(Shipment::class)->findOneByShipmentId($shipmentId);
    }
}
