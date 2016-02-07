<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Base\Entity;

/**
 * Description of AbstractEntity
 *
 * @author mauricioschmitz
 */

use Zend\Stdlib\Hydrator\ClassMethods;

abstract class AbstractEntity{
    
    /**
     * 
     * @param array $options
     */
    public function __construct(Array $options = array()) {
        $hydrator = new ClassMethods();
        $hydrator->hydrate($options, $this);
    }
    
    /**
     *  @return array
     */
    public function toArray(){
        $hydrator = new ClassMethods();
        return $hydrator->extract($this);
    }
}
