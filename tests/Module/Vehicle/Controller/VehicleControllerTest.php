<?php

namespace Tests\Module\Vehicle\Controller;

use App\Module\Address\Repository\AddressRepository;
use App\Module\CarBrand\Repository\CarBrandRepository;
use App\Module\Vehicle\Controller\VehicleController;
use App\Module\Vehicle\Entity\Vehicle;
use App\Module\Vehicle\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VehicleControllerTest extends WebTestCase
{
    private VehicleController $controller;
    private VehicleRepository $vehicleRepositoryMock;
    private CarBrandRepository $carBrandRepositoryMock;
    private AddressRepository $addressRepositoryMock;
    private EntityManagerInterface $entityManagerMock;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->vehicleRepositoryMock = $this->createMock(VehicleRepository::class);
        $this->carBrandRepositoryMock = $this->createMock(CarBrandRepository::class);
        $this->addressRepositoryMock = $this->createMock(AddressRepository::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $this->controller = new VehicleController();

        $container = self::getContainer();
        $container->set(VehicleRepository::class, $this->vehicleRepositoryMock);
        $container->set(CarBrandRepository::class, $this->carBrandRepositoryMock);
        $container->set(AddressRepository::class, $this->addressRepositoryMock);
        $container->set(EntityManagerInterface::class, $this->entityManagerMock);

        $this->controller->setContainer($container);
    }

    public function testListVehicles()
    {
        $vehicleMock = $this->createMock(Vehicle::class);
        $vehicleMock->method('getId')->willReturn(1);
        $vehicleMock->method('getRegistrationNumber')->willReturn('ABC123');
        $vehicleMock->method('getVin')->willReturn('1HGCM82633A123456');

        $carBrandMock = $this->createMock(\App\Module\CarBrand\Entity\CarBrand::class);
        $carBrandMock->method('getName')->willReturn('Test Brand'); // Ustawiamy nazwę marki

        $vehicleMock->method('getBrand')->willReturn($carBrandMock);

        $this->vehicleRepositoryMock
            ->method('findAll')
            ->willReturn([$vehicleMock]);

        $response = $this->controller->list($this->vehicleRepositoryMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                [
                    'id' => 1,
                    'brand' => 'Test Brand', // Sprawdź, czy zwracamy nazwę marki
                    'registrationNumber' => 'ABC123',
                    'vin' => '1HGCM82633A123456',
                    'address' => null,
                ],
            ]),
            $response->getContent()
        );
    }

    public function testShowVehicle()
    {
        $vehicleMock = $this->createMock(Vehicle::class);
        $vehicleMock->method('getId')->willReturn(1);
        $vehicleMock->method('getRegistrationNumber')->willReturn('ABC123');
        $vehicleMock->method('getVin')->willReturn('1HGCM82633A123456');

        $this->carBrandRepositoryMock
            ->method('find')
            ->willReturn($this->createMock(\stdClass::class));

        $response = $this->controller->show($vehicleMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateVehicle()
    {
        $data = [
            'registrationNumber' => 'ABC123',
            'vin' => '1HGCM82633A123456',
            'clientEmail' => 'client@example.com',
            'brand' => ['id' => 1],
            'customerAddress' => null,
        ];

        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getContent')->willReturn(json_encode($data));

        $carBrandMock = $this->createMock(\App\Module\CarBrand\Entity\CarBrand::class);
        $this->carBrandRepositoryMock
            ->method('find')
            ->with(1)
            ->willReturn($carBrandMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('persist');

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $response = $this->controller->create($requestMock, $this->carBrandRepositoryMock, $this->addressRepositoryMock, $this->entityManagerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testUpdateVehicle()
    {
        $vehicleMock = $this->createMock(Vehicle::class);
        $vehicleMock->method('getId')->willReturn(1);
        $vehicleMock->method('getRegistrationNumber')->willReturn('ABC123');

        $data = [
            'registrationNumber' => 'XYZ456',
            'vin' => '1HGCM82633A123456',
            'clientEmail' => 'client@example.com',
            'brand' => ['id' => 1],
            'customerAddress' => null,
        ];

        $requestMock = $this->createMock(Request::class);
        $requestMock->method('getContent')->willReturn(json_encode($data));

        $carBrandMock = $this->createMock(\App\Module\CarBrand\Entity\CarBrand::class);
        $this->carBrandRepositoryMock
            ->method('find')
            ->willReturn($carBrandMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $response = $this->controller->update($requestMock, $vehicleMock, $this->carBrandRepositoryMock, $this->addressRepositoryMock, $this->entityManagerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testDeleteVehicle()
    {
        $vehicleMock = $this->createMock(Vehicle::class);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('remove')
            ->with($vehicleMock);

        $this->entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $response = $this->controller->delete($vehicleMock, $this->entityManagerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['status' => 'Vehicle deleted']),
            $response->getContent()
        );
    }
}
