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
        $carBrandRepository = $this->entityManager->getRepository(CarBrand::class);

        $carBrands = $carBrandRepository->findAll();

        $data = array_map(function (CarBrand $carBrand) {
            return [
                'id' => $carBrand->getId(),
                'name' => $carBrand->getName(),
            ];
        }, $carBrands);

        return new JsonResponse($data);
    }
}
