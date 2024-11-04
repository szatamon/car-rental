<?php

namespace App\Module\CarBrand\Controller;

use App\Module\CarBrand\Entity\CarBrand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CarBrandController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/carbrands', name: 'get_all_car_brands', methods: ['GET'])]
    public function getAllCarBrands(): JsonResponse
    {
        // Pobieranie repozytorium CarBrand
        $carBrandRepository = $this->entityManager->getRepository(CarBrand::class);

        // Pobranie wszystkich marek samochodów
        $carBrands = $carBrandRepository->findAll();

        // Mapowanie wyników do tablicy prostych danych
        $data = array_map(function (CarBrand $carBrand) {
            return [
                'id' => $carBrand->getId(),
                'name' => $carBrand->getName(),
            ];
        }, $carBrands);

        // Zwracanie odpowiedzi JSON
        return new JsonResponse($data);
    }
}
