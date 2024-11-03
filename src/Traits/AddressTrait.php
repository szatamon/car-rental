<?php

namespace App\Traits;

use App\Module\Address\Entity\Address;
use App\Module\Address\Repository\AddressRepository;

trait AddressTrait
{
    private AddressRepository $addressRepository;

    public function setAddressRepository(AddressRepository $addressRepository): void
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Finds an existing address or creates a new one based on the provided data.
     *
     * @param array $data
     * @return Address
     */
    public function findOrCreateAddress(array $data): Address
    {
        $address = $this->addressRepository->findOneBy([
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'zipCode' => $data['zipCode'] ?? null,
            'country' => $data['country'] ?? null,
        ]);

        if (!$address) {
            $address = new Address();
            $address->setStreet($data['street'] ?? '');
            $address->setCity($data['city'] ?? '');
            $address->setState($data['state'] ?? '');
            $address->setZipCode($data['zipCode'] ?? '');
            $address->setCountry($data['country'] ?? '');

            $this->addressRepository->save($address); // Użycie metody save z AddressRepository
        }

        return $address;
    }
}
