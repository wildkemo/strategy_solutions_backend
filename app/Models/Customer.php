<?php

namespace App\Models;

class Customer extends User {
    protected $gender;
    protected $phone;

    public function getPhone(): string {
        return $this->phone;
    }

    public function setPhone(string $phone): void {
        $this->phone = $phone;
    }

    public function getGender(): string {
        return $this->gender;
    }

    public function setGender(string $gender): void {
        $this->gender = $gender;
    }

    

    
    public function addToDB(DatabaseHandler $dbHandler): int {
        $email = $this->getEmail();
        $exists = $dbHandler->is_existing("customers", "email", $email);
    
        if(!$exists){
           
            $data = [
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(), // No hashing
                'phone' => $this->getPhone(),
                'gender' => $this->getGender()
            ];
        
            $op = $dbHandler->insert('customers', $data);

            if($op == true){
                return 0;
            }else{
                return 1;
            }

        }else{
            return 2;
        }
    
        
    }
}