<?php

namespace App\Module\Vehicle\Controller;

use App\Module\Vehicle\Entity\Vehicle;
use App\Module\CarBrand\Entity\CarBrand;
use App\Module\Adress\Entity\Address;
use App\Module\Vehicle\Repository\VehicleRepository;
use App\Module\CarBrand\Repository\CarBrandRepository;
use App\Module\Address\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/vehicles', name: 'api_vehicles_')]
class VehicleController extends AbstractController
{
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(VehicleRepository $vehicleRepository): JsonResponse
    {
        $vehicles = $vehicleRepository->findAll();
        return $this->json($vehicles);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Vehicle $vehicle): JsonResponse
    {
        return $this->json($vehicle);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        CarBrandRepository $carBrandRepository,
        AddressRepository $addressRepository,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $carBrand = $carBrandRepository->find($data['brandId']);
        if (!$carBrand) {
            return $this->json(['error' => 'Invalid brand ID'], 400);
        }

        $vehicle = new Vehicle();
        $vehicle->setRegistrationNumber($data['registrationNumber']);
        $vehicle->setVin($data['vin']);
        $vehicle->setClientEmail($data['clientEmail']);
        $vehicle->setIsRented($data['isRented'] ?? false);
        $vehicle->setBrand($carBrand);

        // Opcjonalne przypisanie adresów
        if (isset($data['clientAddressId'])) {
            $clientAddress = $addressRepository->find($data['clientAddressId']);
            $vehicle->setClientAddress($clientAddress);
        }

        if (isset($data['currentLocationId'])) {
            $currentLocation = $addressRepository->find($data['currentLocationId']);
            $vehicle->setCurrentLocation($currentLocation);
        }

        $em->persist($vehicle);
        $em->flush();

        return $this->json($vehicle, 201);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Request $request,
        Vehicle $vehicle,
        CarBrandRepository $carBrandRepository,
        AddressRepository $addressRepository,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['brandId'])) {
            $carBrand = $carBrandRepository->find($data['brandId']);
            $vehicle->setBrand($carBrand);
        }

        $vehicle->setRegistrationNumber($data['registrationNumber'] ?? $vehicle->getRegistrationNumber());
        $vehicle->setVin($data['vin'] ?? $vehicle->getVin());
        $vehicle->setClientEmail($data['clientEmail'] ?? $vehicle->getClientEmail());
        $vehicle->setIsRented($data['isRented'] ?? $vehicle->isRented());

        $em->flush();

        return $this->json($vehicle);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Vehicle $vehicle, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($vehicle);
        $em->flush();

        return $this->json(['status' => 'Vehicle deleted']);
    }
}