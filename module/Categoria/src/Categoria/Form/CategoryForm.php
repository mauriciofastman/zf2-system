<?php

namespace Categoria\Form;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Categoria\Form\CategoryFilter;
use Zend\Form\Element\Button;
/**
 * Description of CategoryForm
 *
 * @author mauricioschmitz
 */
class CategoryForm extends Form{
    
    public function __construct() {
        parent::__construct(null);
        
        $this->setAttribute('method','POST');
        
        $this->setInputFilter(new CategoryFilter());
        //Input nome
        $nome = new Text('nome');
        $nome->setLabel('Nome')
                ->setAttributes(array(
                    'maxlenght' => 255,
                    
                ));
        $this->add($nome);
        
        //Botão submit
        $button = new Button('submit');
        $button->setLabel('Salvar')
                ->setAttributes(array(
                    'type' => 'submit',
                    'class' => 'btn tbn-default'
                ));
        
        $this->add($button);
    }
}
