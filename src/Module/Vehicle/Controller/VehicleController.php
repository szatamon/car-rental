<?php

namespace App\Module\Vehicle\Controller;

use App\Module\Vehicle\Entity\Vehicle;
use App\Module\CarBrand\Entity\CarBrand;
use App\Module\Adress\Entity\Address;
use App\Module\Vehicle\Repository\VehicleRepository;
use App\Module\CarBrand\Repository\CarBrandRepository;
use App\Module\Address\Repository\AddressRepository;
use App\Traits\AddressTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/vehicles', name: 'api_vehicles_')]
class VehicleController extends AbstractController
{
    use AddressTrait;
    
    /**
     * @OA\Get(
     *     path="/api/vehicles",
     *     summary="Get list of all vehicles",
     *     @OA\Response(response=200, description="List of vehicles")
     * )
     */
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(VehicleRepository $vehicleRepository): JsonResponse
    {
        $vehicles = $vehicleRepository->findAll();
        
        $data = array_map(function (Vehicle $vehicles) {
            return [
                'id' => $vehicles->getId(),
                'brand' => $vehicles->getBrand()->getName(),
                'registrationNumber' => $vehicles->getRegistrationNumber(),
                'vin' => $vehicles->getVin(),
                'address' => $vehicles->getClientAddress() ? [
                    'street' => $vehicles->getClientAddress()->getStreet(),
                    'city' => $vehicles->getClientAddress()->getCity(),
                    'state' => $vehicles->getClientAddress()->getState(),
                    'zipCode' => $vehicles->getClientAddress()->getZipCode(),
                    'country' => $vehicles->getClientAddress()->getCountry(),
                ] : null,
            ];
        }, $vehicles);

        return $this->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/vehicles/{id}",
     *     summary="Get details of a specific vehicle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the vehicle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Vehicle details"),
     *     @OA\Response(response=404, description="Vehicle not found")
     * )
     */
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Vehicle $vehicle): JsonResponse
    {
        $data = [
            'id' => $vehicle->getId(),
            'brand' => $vehicle->getBrand()->getName(),
            'registrationNumber' => $vehicle->getRegistrationNumber(),
            'vin' => $vehicle->getVin(),
            'clientEmail' => $vehicle->getClientEmail(),
            'customerAddress' => $vehicle->getClientAddress() ? [
                'street' => $vehicle->getClientAddress()->getStreet(),
                'city' => $vehicle->getClientAddress()->getCity(),
                'state' => $vehicle->getClientAddress()->getState(),
                'zipCode' => $vehicle->getClientAddress()->getZipCode(),
                'country' => $vehicle->getClientAddress()->getCountry(),
            ] : null,
        ];
    
        return $this->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/vehicles",
     *     summary="Create a new vehicle",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="registrationNumber", type="string"),
     *             @OA\Property(property="vin", type="string"),
     *             @OA\Property(property="clientEmail", type="string"),
     *             @OA\Property(property="brand", type="object", @OA\Property(property="id", type="integer")),
     *             @OA\Property(property="customerAddress", type="object",
     *                 @OA\Property(property="street", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="state", type="string"),
     *                 @OA\Property(property="zipCode", type="string"),
     *                 @OA\Property(property="country", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=201, description="Vehicle created"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        CarBrandRepository $carBrandRepository,
        AddressRepository $addressRepository,
        EntityManagerInterface $em
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $carBrand = $carBrandRepository->find($data['brand']['id']);
        if (!$carBrand) {
            return $this->json(['error' => 'Invalid brand ID'], 400);
        }
        $vehicle = new Vehicle();
        $vehicle->setRegistrationNumber($data['registrationNumber']);
        $vehicle->setVin($data['vin']);
        $vehicle->setClientEmail($data['clientEmail'] ?? null);
        $vehicle->setBrand($carBrand);
        if($data['customerAddress']) {
            $this->setAddressRepository($addressRepository);
            $clientAddress = $this->findOrCreateAddress($data['customerAddress']);
            $vehicle->setClientAddress($clientAddress);
        }

        $em->persist($vehicle);
        $em->flush();

        return $this->json($vehicle, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/vehicles/{id}",
     *     summary="Update an existing vehicle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the vehicle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="registrationNumber", type="string"),
     *             @OA\Property(property="vin", type="string"),
     *             @OA\Property(property="clientEmail", type="string"),
     *             @OA\Property(property="brand", type="object", @OA\Property(property="id", type="integer")),
     *             @OA\Property(property="customerAddress", type="object",
     *                 @OA\Property(property="street", type="string"),
     *                 @OA\Property(property="city", type="string"),
     *                 @OA\Property(property="state", type="string"),
     *                 @OA\Property(property="zipCode", type="string"),
     *                 @OA\Property(property="country", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Vehicle updated"),
     *     @OA\Response(response=400, description="Invalid input")
     * )
     */
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

    // Znalezienie marki pojazdu
    if (isset($data['brand']['id'])) {
        $carBrand = $carBrandRepository->find($data['brand']['id']);
        if (!$carBrand) {
            return $this->json(['error' => 'Invalid brand ID'], 400);
        }
        $vehicle->setBrand($carBrand);
    }

    // Aktualizacja podstawowych pól
    $vehicle->setRegistrationNumber($data['registrationNumber'] ?? $vehicle->getRegistrationNumber());
    $vehicle->setVin($data['vin'] ?? $vehicle->getVin());
    $vehicle->setClientEmail($data['clientEmail'] ?? $vehicle->getClientEmail());

    // Aktualizacja adresu klienta, jeśli jest podany
    if (isset($data['customerAddress'])) {
        $this->setAddressRepository($addressRepository);
        $clientAddress = $this->findOrCreateAddress($data['customerAddress']);
        $vehicle->setClientAddress($clientAddress);
    } else {
        // Jeśli adres nie jest podany, można usunąć bieżący adres lub pozostawić bez zmian
        $vehicle->setClientAddress(null); // opcjonalnie
    }

    $em->flush();

    return $this->json($vehicle);
}

    /**
     * @OA\Delete(
     *     path="/api/vehicles/{id}",
     *     summary="Delete a vehicle",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the vehicle",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Vehicle deleted")
     * )
     */
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Vehicle $vehicle, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($vehicle);
        $em->flush();

        return $this->json(['status' => 'Vehicle deleted']);
    }
}