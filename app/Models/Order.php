<?php

namespace App\Models;

class Order {
    protected $name;
    protected $email;
    protected $service_type;
    protected $service_description;


    public function getName(): string 
{
    return $this->name;
}

public function setName(string $name): void 
{
    $this->name = $name;
}

public function getEmail(): string 
{
    return $this->email;
}

public function setEmail(string $email): void 
{
    $this->email = $email;
}

public function getServiceType(): string 
{
    return $this->service_type;
}

public function setServiceType(string $service_type): void 
{
    $this->service_type = $service_type;
}

public function getServiceDescription(): string 
{
    return $this->service_description;
}

public function setServiceDescription(string $service_description): void 
{
    $this->service_description = $service_description;
}





    public function addToDB(DatabaseHandler $dbHandler): int {
        
        $exists = $dbHandler->is_existing("customers", "email", $this->getEmail());
    
        if($exists == true){

            $fetchedname = $dbHandler->getOneValue("customers", "name", "email", $this->getEmail());
            $this->setName($fetchedname);

           
            $data = [
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'service_description' => $this->getServiceDescription(),
                'service_type' => $this->getServiceType(),
                'status' => 'Pending'
            ];

            // $data = [
            //     'name' => 'kariiim',
            //     'email' => 'karim@gmail.com',
            //     'service_description' => 'ssdsds',
            //     'service_type' => 'erter',
            // ];
        
            $op = $dbHandler->insert('orders', $data);

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