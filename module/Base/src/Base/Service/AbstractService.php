<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base\Service;

/**
 * Description of AbstractEntity
 *
 * @author mauricioschmitz
 */
use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

abstract class AbstractService{
    
    protected $em;
    protected $entity;
    
    /**
     * 
     * @param EntityManager
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function save(Array $data = array()){
        if(isset($data['id'])){
           $entity = $this->em->getReference($this->entity, $data['id']) ;
           
           $hydrator = new ClassMethods();
           $hydrator->hydrate($data, $entity);
           
        }else{
           $entity = new $this->entity($data);
                   
        }
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    public function remove(Array $data = array()){
        $entity = $this->em->getRepository($this->entity)->findOneBy($data);
        
        if($entity){
            $this->em->remove($entity);
            $this->em->flush();
            
            return $entity;        
        }
    }
}
