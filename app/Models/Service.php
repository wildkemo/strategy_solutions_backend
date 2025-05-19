<?php

namespace App\Models;

class Service {
    protected $title;

    protected $description;

    protected $category;
    
    protected $features;

    protected $icon;
    protected $service_status;


    public function getTitle():string {
        return $this->title;
    }
    public function setTitle($title) {
        $this->title = $title;
    }

    // Description
    public function getDescription():string {
        return $this->description;
    }
    public function setDescription($description) {
        $this->description = $description;
    }

    // Category
    public function getCategory():string {
        return $this->category;
    }
    public function setCategory($category) {
        $this->category = $category;
    }

    // Features
    public function getFeatures():string {
        return $this->features;
    }
    public function setFeatures($features) {
        $this->features = $features;
    }

    // Icon
    public function getIcon():string {
        return $this->icon;
    }
    public function setIcon($icon) {
        $this->icon = $icon;
    }

    

    
    public function addToDB(DatabaseHandler $dbHandler): int {
        
        $title = $this->getTitle();
        $exists = $dbHandler->is_existing("services", "title", $title);
    
        if(!$exists){
           
            $data = [
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'category' => $this->getCategory(),
                'features' => $this->getFeatures(),
                'icon' => $this->getIcon(),

            ];
        
            $op = $dbHandler->insert('services', $data);

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