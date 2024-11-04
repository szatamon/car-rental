<?php

namespace Tests\Module\CarBrand\Controller;

use App\Module\CarBrand\Controller\CarBrandController;
use App\Module\CarBrand\Entity\CarBrand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CarBrandControllerTest extends WebTestCase
{
    private CarBrandController $controller;
    private EntityManagerInterface $entityManagerMock;

    protected function setUp(): void
    {
        self::bootKernel();

        // Mockowanie EntityManager
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);

        // Tworzenie instancji kontrolera
        $this->controller = new CarBrandController($this->entityManagerMock);
    }

    public function testGetAllCarBrands()
    {
        // Tworzymy mocka dla CarBrand
        $carBrandMock1 = $this->createMock(CarBrand::class);
        $carBrandMock1->method('getId')->willReturn(1);
        $carBrandMock1->method('getName')->willReturn('Test Brand 1');

        $carBrandMock2 = $this->createMock(CarBrand::class);
        $carBrandMock2->method('getId')->willReturn(2);
        $carBrandMock2->method('getName')->willReturn('Test Brand 2');

        // Ustawiamy, że findAll zwraca nasze mocki
        $carBrandRepositoryMock = $this->createMock(\App\Module\CarBrand\Repository\CarBrandRepository::class);
        $carBrandRepositoryMock->method('findAll')->willReturn([$carBrandMock1, $carBrandMock2]);

        // Ustawiamy mock repozytorium w EntityManager
        $this->entityManagerMock
            ->method('getRepository')
            ->willReturn($carBrandRepositoryMock);

        // Wywołanie metody getAllCarBrands
        $response = $this->controller->getAllCarBrands();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                [
                    'id' => 1,
                    'name' => 'Test Brand 1',
                ],
                [
                    'id' => 2,
                    'name' => 'Test Brand 2',
                ],
            ]),
            $response->getContent()
        );
    }
}
