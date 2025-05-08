<?php

namespace App\Models;

class Customer extends User {
    protected $service_type;
    protected $service_description;

    public function getServiceType(): string {
        return $this->service_type;
    }

    public function setServiceType(string $service_type): void {
        $this->service_type = $service_type;
    }

    public function getServiceDescription(): string {
        return $this->service_description;
    }

    public function setServiceDescription(string $service_description): void {
        $this->service_description = $service_description;
    }

    /**
     * Adds the customer to the database using the DatabaseHandler class.
     *
     * @param DatabaseHandler $dbHandler
     * @return bool True if successful, false otherwise.
     */
    public function addCustomerToDB(DatabaseHandler $dbHandler): bool {
        $data = [
            //'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'service_type' => $this->getServiceType(),
            'service_description' => $this->getServiceDescription(),
        ];
        

        return $dbHandler->insert('customers', $data);
    }
}