<?php

namespace App\Models;

class Admin extends User {
    protected $level;
    

    public function getLevel(): int {
        return $this->level;
    }

    public function setlevel(int $level): void {
        $this->level = $level;
    }

    

    
    public function addToDB(DatabaseHandler $dbHandler): bool {

        $exists = $dbHandler->is_existing("admins", "email", $this->getEmail());

        if(!$exists){

            $data = [
                //'id' => $this->getId(),
                'name' => $this->getName(),
                'email' => $this->getEmail(),
                'password' => $this->getPassword(),
                'level' => $this->getLevel()
            ];
            
    
            $op = $dbHandler->insert('admins', $data);
            
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