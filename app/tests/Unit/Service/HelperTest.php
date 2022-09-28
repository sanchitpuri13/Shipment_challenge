<?php

namespace App\tests\Unit\Service;

use Faker\Factory;
use App\Service\Helper\Helper;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class HelperTest extends KernelTestCase
{
    private Generator $faker;
    private string $filePath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->filePath = realpath('./tests/files/test_shipments.json');
    }

    public function testConvertFileDataIntoArray()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $this->assertIsArray($helperObject->convertFileDataIntoArray($this->filePath));
    }

    public function testFailureConvertFileDataIntoArray()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $this->expectException(FileNotFoundException::class);
        $helperObject->convertFileDataIntoArray(2);
    }

    public function testGetCompanyDataFromShipments()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $companyInput = $helperObject->convertFileDataIntoArray($this->filePath);

        $this->assertIsArray($helperObject->getCompanyDataFromShipments($companyInput));
    }

    public function testGetCarriersDataFromShipments()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $carrierInput = $helperObject->convertFileDataIntoArray($this->filePath);

        $this->assertIsArray($helperObject->getCarriersDataFromShipments($carrierInput));
    }

    public function testGetShipmentsData()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);
        $shipmentInput = $helperObject->convertFileDataIntoArray($this->filePath);

        $this->assertIsArray($helperObject->getShipmentsData($shipmentInput));
    }

    public function testGetCostOfShipment()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $this->assertIsFloat($helperObject->getCostOfShipment($this->faker->numberBetween(0, 99)));
        $this->assertIsFloat($helperObject->getCostOfShipment($this->faker->numberBetween(100, 199)));
        $this->assertIsFloat($helperObject->getCostOfShipment($this->faker->numberBetween(200, 299)));
        $this->assertIsFloat($helperObject->getCostOfShipment($this->faker->numberBetween(300, 500)));
    }


    public function testGetDistanceInKm()
    {
        self::bootKernel();

        $container = static::getContainer();

        $helperObject = $container->get(Helper::class);

        $this->assertIsFloat($helperObject->getDistanceInKm($this->faker->randomDigit()));
    }
}
