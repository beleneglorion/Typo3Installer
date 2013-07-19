<?php

namespace TypoInstaller;

class Typo3Manager {
    
    protected $data;
    protected $branches = array();
    
    public function __construct(){
        
        
        $this->data = json_decode(file_get_contents('http://get.typo3.org/json'));
        
        
    }
    
    
    public function getBranches()
    {
        
      if(empty($this->branches)) {
       foreach($this->data as $prop=>$nothing)
       {
           if(is_numeric($prop)) {
               $this->branches[]=$prop;
           }
           
       }
      }
        
     return $this->branches;
       
    }
    
     
    public function getBranch($branch)
    {
        
    
        if(isset($this->data->$branch)) {
            return $this->data->$branch;
        }
        
       return null;
    }
    
    public function getReleases($branch)
    {
        $br = $this->getBranch($branch);
        $returnValue = array();
       
        if(!is_null($br)) {
            foreach($br->releases as $prop=>$nothing)
            {
              $returnValue[]=$prop;
            }
        }
       return $returnValue;
    }
    
    
    public function getRelease($branch,$release)
    {
        $br = $this->getBranch($branch);
        if(!is_null($br) && isset($br->releases->$release)) {
            return $br->releases->$release;
        }
       
       return null;
    }
    
    public function getData()
    {
        
        return $this->data;
    }
            
    
    
    
    
    
}